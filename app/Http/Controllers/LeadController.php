<?php

namespace App\Http\Controllers;


use App\Phone;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Lead;
use App\TakenBy;
use App\Source;
use App\Status;
use App\SalesRep;
use App\Note;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
//use Input; worked before adding upload function
use Auth;
use Cache;
use app\Helpers\Helper;
//use App\Person\Hello;


class LeadController extends Controller 
{
    var $destinationPath = 'drawings/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {

        $lead = Lead::findOrFail($id);

        $this->authorize('read', $lead);

        $lead->drawings = DrawingController::filter($lead->drawings);

        $lead->address = $this->get_address($lead);
        return view('lead.lead',
        	[
        	'lead' => $lead,
        	'statuses' => Status::orderBy('name')->get(),
        	'salesreps' => SalesRep::all(),
        	'takenbies' => TakenBy::all(),
    		'sources' => Source::all(),
            'property_types' => DB::table('property_types')->get(),
            'customer_types' => DB::table('customer_types')->get(),
            'job_types' => DB::table('job_types')->Orderby('name', 'asc')->get(),
            'features' => DB::table('features')->Orderby('name', 'asc')->get()
        	]); 
    }

    private function get_address($lead)
    {
        $tmp = "$lead->street+$lead->city+UT+$lead->zip";
        $tmp = preg_replace('/\s+/', '+',$tmp);
        return "https://www.google.com/maps/place/$tmp";
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //$leads = DB::table('leads')->paginate(15);

        if ($request->ajax()) 
        {
            $search = str_replace(["'", '"', 'delete', 'update'], ["\\'", "\\\"", ''], $request->searchtx);

            $query = "SELECT ".
                "leads.*,
            DATE_FORMAT(leads.appointment, '%b %e, %Y at %h:%i%p') appointmentfmt,
            status.name as status_name,
            sales_reps.name as sales_rep_name,
            taken_by.name as taken_by_name,
            sources.name as source_name,
            GROUP_CONCAT(DISTINCT jobs.id ORDER BY jobs.id SEPARATOR ' ') as job_ids,
            IF(DATE(appointment) = DATE(NOW()),1,0) today,
            IF(DATE(appointment) = ADDDATE(DATE(NOW()),1),1,0) tomorrow,
            IF(appointment >= DATE(now()) AND appointment < ADDDATE(DATE(NOW()), INTERVAL 1 WEEK),1,0) week
            FROM leads
            LEFT JOIN notes ON notes.lead_id = leads.id
            LEFT JOIN jobs ON jobs.lead_id=leads.id
            LEFT JOIN notes j_notes ON j_notes.job_id = jobs.id
            JOIN status ON status.id = leads.status_id
            JOIN sales_reps ON sales_reps.id = leads.sales_rep_id
            JOIN taken_by ON taken_by.id = leads.taken_by_id
            JOIN sources ON sources.id = leads.source_id
            WHERE 1";

            if($request->searchby == 'Tag')
            {
                if(strpos($search, '#') === false || strpos($search, '#') != 0) $search = '#'.$search;
//                $query .= sprintf(" AND notes.note LIKE '%s%%' ", $search);
                $query .= " AND ((notes.note LIKE '$search%' AND notes.deleted_at is null) OR  (j_notes.note LIKE '$search%' AND j_notes.deleted_at is null))";
            }
            elseif($request->searchby == 'Addr')
            {
                $query .= " AND (leads.street LIKE '%$search%' OR leads.city LIKE '%$search%')";
            }
            elseif($request->searchby == 'Job#')
            {
                $query .= " AND (jobs.id = '$search' OR j.code like LIKE '%$search%')";
            }
            elseif($request->searchby == 'Email')
            {
                $query .= " AND leads.email LIKE '%$search%' ";
            }
            elseif($request->searchby == 'Phone')
            {
                $phone_number =  str_replace([' ', '(', ')', '-'], "", $search);
                $query .= " AND REPLACE(REPLACE(REPLACE(REPLACE(leads.phone,' ',''),'(',''),')',''),'-', '') = $phone_number";
            }
            else
            {
                $query .= " AND (leads.customer_name LIKE '%$search%' OR leads.contact_name LIKE '%$search%')";
            }

            if (count($request->statuses) > 0)
            {
                $query .= " AND status.name IN (".implode(",", $request->statuses).")";
            }

            if(count($request->reps) > 0)
            {
                $query .= " AND sales_reps.name IN (".implode(",", $request->reps).")";
            }

            if($request->week == '1')
            {
                $query .= " AND appointment >= DATE(now()) AND appointment < ADDDATE(DATE(NOW()), INTERVAL 1 WEEK)";
            }
            if($request->today == '1' && $request->tomorrow == '1')
            {
                $query .= " AND (DATE(appointment) = DATE(NOW()) OR DATE(appointment) = ADDDATE(DATE(NOW()), 1))";
            }
            elseif($request->today == '1' && $request->week != '1')
            {
                $query .= " AND DATE(appointment) = DATE(NOW())";
            }
            elseif($request->tomorrow == '1' && $request->week != '1')
            {
                $query .= " AND DATE(appointment) = ADDDATE(DATE(NOW()), 1)";
            }

            $sort = "leads.updated_at DESC";
            if($request->sortby)
            {
                $sortby = str_replace(
                    ['customer name', 'sales rep', 'status'],
                    ['customer_name', 'sales_reps.name', 'status.name'],
                    strtolower($request->sortby)
                );

                $direction = ($request->sortdirection == 1)? 'ASC': 'DESC';
                $sort = "$sortby $direction";
            }

            $query .= " GROUP BY leads.id ORDER BY $sort";


            //return $query;

            $leads = DB::select($query);
            $status_count = [];
            $reps_count = [];
            $today_count = 0;
            $tomorrow_count = 0;
            $week_count = 0;
            $leads_count = count($leads);


            foreach($leads as $lead)
            {
                if(!isset($status_count[$lead->status_name]))
                    $status_count[$lead->status_name] = 0;
                if(!isset($reps_count[$lead->sales_rep_name]))
                    $reps_count[$lead->sales_rep_name] = 0;

                $status_count[$lead->status_name]++;
                $reps_count[$lead->sales_rep_name]++;

                $today_count += $lead->today;
                $tomorrow_count += $lead->tomorrow;
                $week_count += $lead->week;
            }
            $perPage = 15;
            $currentPage = $request->page?:1;
            $currentItems = array_slice($leads, $perPage * ($currentPage - 1), $perPage);

            $leads = new LengthAwarePaginator($currentItems, $leads_count, 15, $currentPage);

//            dd($leads);

            return response()->json([
                'leads' => view('partials.leads', ['leads' => $leads ])->render(),
                'links' => sprintf('<div>%s</div>', $leads->links()),
                'status' => $status_count,
                'reps' => $reps_count,
                'today' => $today_count,
                'tomorrow' => $tomorrow_count,
                'week' => $week_count,
                'count' => $leads_count,
                'next_page' => 0,
                'prev_page' => 1,
                'q' => $query
            ]);
        }
        else
        {
            $status = DB::select("SELECT name, 0 as count FROM status");
            $reps = DB::select("SELECT name, 0 as count FROM sales_reps");

            return view('lead.index', ['leads' => [], 'status_count' => $status, 'reps_count' => $reps]);
        }

/*         $admins = DB::table('users')
        ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
        ->where('users_roles.role_id', '=' ,0)
        ->orderBy($sort, $sort_dir)
        ->paginate($this->perpage);*/
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $this->authorize('edit');
        return view('lead.create',
                [
                    'statuses' => Status::all(),
                    'salesreps' => SalesRep::all(),
                    'takenbies' => TakenBy::all(),
                    'sources' => Source::all()
                ]);
    }

    public function store(Request $request)
    {
        $this->authorize('edit');
        // Validate the request...
        $lead = new Lead;
        $lead->customer_name = $request->customer;
		$lead->contact_name = $request->contact;
		$lead->street = $request->street;
		$lead->city = $request->city;
		$lead->zip = $request->zip;
		$lead->phone = $request->phone;
		$lead->email = $request->email;
		$lead->appointment = Helper::db_datetime($request->appointment, $request->apptime);
		$lead->taken_by_id = $request->takenby;
		$lead->source_id = $request->source;
		$lead->sales_rep_id = $request->salesrep;
		$lead->status_id = $request->status;

        $result = $lead->save();

        if($request->note != "")
        {
            $note = new Note;
            $note->note = $request->note;
            $note->lead_id = $lead->id;
            $note->user_id = Auth::user()->id;
            $result &= $note->save();
        }

        // if($result)
        // 	return response()->json(['result' => 'sucessful']);
        // return response()->json(['result' => 'error']);

        $r = ($result)? ['created' => $lead->id]: [];

        $message['text'] = 'Lead created successufully';
        $message['class'] = 'alert-success';
        $message['title'] = 'Info!';

        if($result == false)
        {
            $message['text'] = 'Error trying to create lead';
            $message['class'] = 'alert-danger';
            $message['title'] = 'Error!';
        }
        return redirect()->action('LeadController@index', $r)->with('message', $message);
    }

    public function update(Request $request)
    {
        $this->authorize('edit');
    	$id = $request->id;
    	$lead = Lead::find($id);
        $lead->customer_name = $request->customer;
        $lead->contact_name = $request->contact;
        $lead->street = $request->street;
        $lead->city = $request->city;
        $lead->state = $request->state;
        $lead->zip = $request->zip;
        $lead->phone = $request->phone;
        $lead->email = $request->email;
        $lead->appointment = Helper::db_datetime($request->appointment, $request->apptime);
        $lead->taken_by_id = $request->takenby;
        $lead->source_id = $request->source;
        $lead->sales_rep_id = $request->salesrep;
        $lead->status_id = $request->status;

        $result = $lead->save();
        
        $note = new Note();
        if (!empty($request->note))
        {
            $note->lead_id = $lead->id;
            $note->note = $request->note;
            $note->user_id = Auth::user()->id;
            $note->created = $note->save();
        }

        if (!empty($request->phones))
        {
            foreach($request->phones as $p)
            {
                $phone = Phone::find($p['id']);
                if($phone != null)
                {
                    $phone->number = $p['number'];
                    $phone->save();
                }
            }
        }

        $result = ($result  == true)? 200: 400;
		return response()->json(['result' => $result, 'note' => $note]);

		// App\Flight::where('active', 1)
  //         ->where('destination', 'San Diego')
  //         ->update(['delayed' => 1]);
    }

    /**
     * used for auto sugest terms to the search bar
     */
    public function getdata(Request $request)
    {
        $term = $request->term;
        $leads = DB::table('leads')->select('customer_name')->where('customer_name', 'like', "%$term%")->get();

        $result_arr = [];

        foreach ($leads as $lead) {
            $result_arr[] = $lead->customer_name;
        }

        return response()->json($result_arr);
    }

    // auto sugest
    public function getcities()
    {
        /*   @var Request $request */
        /*   @var DB  */
        //cities
        $style_arr = [];
        $color_arr = [];
        $size_arr = [];
        $manu_arr = [];
        $removal_arr = [];

        $city_arr = Cache::remember('cities', 60, function(){
            $tmp = [];
            $cities = DB::table('cities')->select('name')->get();
            foreach ($cities as $key => $citie) {
                $tmp[] = $citie->name;
            }
            return $tmp;
        });

        //style
        $styles = DB::table('job_style')->select(DB::raw('distinct style'))
                                        ->where('style', '<>', '')
                                        ->where('style', '<>', 'n/a')
                                        ->get();

        foreach ($styles as $style) {
            $style_arr[] = $style->style;
        }

        //manufacturer
        $manus = DB::table('job_style')->select(DB::raw('distinct manufacturer'))
                                        ->where('manufacturer', '<>', '')
                                        ->where('manufacturer', '<>', 'n/a')
                                        ->get();

        foreach ($manus as $manu) {
            $manu_arr[] = $manu->manufacturer;
        }

        //color
        $colors = DB::table('job_style')->select(DB::raw('distinct color'))
                                        ->where('color', '<>', '')
                                        ->where('color', '<>', 'n\a')
                                        ->get();

        foreach ($colors as $color) {
            $color_arr[] = $color->color;
        }

        //size
        $sizes = DB::table('job_style')->select(DB::raw('distinct size'))
                                        ->where('size', '<>', '')
                                        ->where('size', '<>', 'n/a')
                                        ->get();

        foreach ($sizes as $size) {
            $size_arr[] = $size->size;
        }

        $removals = DB::table('job_removals')->select(DB::raw('distinct name'))
            ->where('name', '<>', '')
            ->where('name', '<>', 'n/a')
            ->get();

        foreach ($removals as $removal) {
            $removal_arr[] = $removal->name;
        }

         return response()->json([
             'cities' => $city_arr,
             'styles' => $style_arr,
             'manus' => $manu_arr,
             'colors' => $color_arr,
             'sizes' => $size_arr,
             'removals' => $removal_arr
         ]);
    }


    public function services()
    {
        
//        return $pdf->stream();

//        $today = strtotime('1/1/2014');
//        $years = strtotime('1/1/2031');
//
//        while($today < $years)
//        {
//            $date =  date('Y-m-d', $today) ."\n";
//            DB::table('dates')->insert(
//                ['date_value' => $date]
//            );
//            $today += (60*60*24);
//        }
//        echo "done";


// Add 1 day - expect time to remain at 08:00
//        while(d1 < '2031-01-01') {

        //echo "Page";
        //echo hello('james'); //testing  function inside customHelper
        //echo Hello::show('Joe');
//        Cache::forever('leads_pages',
//      //      ['name' => 'Mary', 'age' => 25]);
//        var_dump(Cache::get('leads_pages'));
//        var_dump(Cache::has('leads_pages'));


        //capitalize word
//        $styles = DB::table('job_style')->get();
//        foreach($styles as $style1)
//        {
//            //print($style->id.'<br>');
//            $style = Style::find($style1->id);
//            $style->style =ucwords($style->style);
//            $style->color =ucwords($style->color);
//            $style->size = ucwords($style->size);
//            $style->manufacturer=ucwords($style->manufacturer);
//            $style->save();
//            print($style->style.'<br>');
//
//        }

//        $styles = DB::table('job_style')->get();
//        foreach($styles as $style1)
//        {
//            //print($style->id.'<br>');
//            $style = Style::find($style1->id);
//            $sizes = explode(',', $style->size);
//            //print("<b>($style->job_id, $style->style, $style->color,$style->manufacturer,$style->size)</b><br>");
//            foreach($sizes as $size) {
//                $size = trim($size);
//                print("($style->job_id, '$style->style',  '$style->color' ,'$style->manufacturer','$size'),<br>");
//            }
//        }



        //insert removals
/*        $str = "insert into job_removals (job_id, name) values";
        $rems = DB::table('jobs_all2')->where('removal', '<>', '')->get();
        foreach($rems as $rem)
        {
            $job_id = $rem->Job_Number;
            foreach(explode(' ', trim($rem->Removal)) as $item)
            {
               $str .= "('$job_id','".ucfirst ($item)."'),";

            }
        }
        print($str);*/

        //needs to change /config/database fetch to FETCH_ASSOC
        /*
       $result = "";
        $feats = DB::table('features')->get();
        $feat_arr = array();
        foreach($feats as $feat)
        {
            $feat_arr[$feat['name']] = $feat['id'];
        }

        $tb_name = [
            'BBQ' => 'BBQ',
            'BP' => 'BP',
            'DW' => 'DW',
            'FP' => 'FP',
            'Fpit' => 'Fpit',
            'Gas Fpit' => 'Gas_Fpit',
            'Pavilion' => 'Pavilion',
            'Pch' => 'Pch',
            'Pergola' => 'Pergola',
            'Pizza Oven' => 'Pizza_Oven',
            'Pool' => 'Pool',
            'Rad.Heat' => 'Rad_Heat',
            'RW' => 'RW',
            'Sealer' => 'Sealer',
            'Steps' => 'Steps',
            'SW' => 'SW',
            'Wat. Feat.' => 'Wat_Feat',
            'WW' => 'WW'
        ];

        $job_arr = [];

        foreach ($feat_arr as $key => $value) {
            # code...

            $_key = $tb_name[$key];
    
            $jobs = DB::table('jobs_all2')->select("Job_Number", $_key)->where('Job_Number', '>', '268')->get();
         
            foreach($jobs as $job)
            {
//                if($job[$_key] == 1)
//                {
                    $job_arr[$job['Job_Number']][] = ['feat' => $value, 'active' => ($job[$_key]==1? 1: 0)];
//                }
            }

        }

        foreach ($job_arr as $key => $values) {
            foreach ($values as $value) {
                  echo "($key, $value[feat], $value[active]),";
            }
        }
        echo count($job_arr);
        $this->printr($job_arr); */


        //$jobs = DB::table('jobs')->select(DB::raw('distinct id'))->get();


  /*      foreach ($jobs as $job) {
            $features = DB::table('feature_job')->select('feature_id')->where('job_id', $job->id)->get();
            $feat_arr = array();

            foreach ($features as $feat) {
                $feat_arr[] = $feat->feature_id;
            }

            for($i=1; $i < 19; $i++)
            {
                if(!in_array($i, $feat_arr))
                {
                    DB::table('feature_job')->insert(['feature_id' => $i, 'job_id' => $job->id, 'active' => 0]);
                }
            }
        }*/

    }

    public function printr($arr)
    {
        print("<pre>".print_r($arr, true)."</pre>");
    }

    public function edit($id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}


//session_start();
//
//$username = sanitize($_POST['username']);
//$password = md5(sanitize($_POST['password']));
//
//$query = sprintf("SELECT * FROM `members` WHERE username='%s' AND password='%s'",
//    $username, $password);
//
//$sql = mysql_query($query);
//
//if(mysql_num_rows($sql))
//{
//// login OK
//    $_SESSION['username'] = $username;
//}
//else
//{
//    $login_error = true;
//}
