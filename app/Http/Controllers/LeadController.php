<?php

namespace App\Http\Controllers;

use App\Style;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lead;
use App\TakenBy;
use App\Source;
use App\Status;
use App\SalesRep;
use App\Note;
use App\Drawing;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
//use Input; worked before adding upload function
use Auth;
use Illuminate\Support\Facades\Input;
use Cache;
use App\Person\Hello;


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

//        if (\Gate::denies('read-job', $lead)) {
//            $lead->job = null;
//        }
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
            JOIN status ON status.id = leads.status_id
            JOIN sales_reps ON sales_reps.id = leads.sales_rep_id
            JOIN taken_by ON taken_by.id = leads.taken_by_id
            JOIN sources ON sources.id = leads.source_id
            WHERE 1";

            if($request->searchby == 'Tag')
            {
                if(strpos($search, '#') === false || strpos($search, '#') != 0) $search = '#'.$search;
//                $query .= sprintf(" AND notes.note LIKE '%s%%' ", $search);
                $query .= " AND notes.note LIKE '$search%'";
            }
            elseif($request->searchby == 'Addr')
            {
                $query .= " AND leads.street LIKE '%$search%' ";
            }
            elseif($request->searchby == 'Job#')
            {
                $query .= " AND jobs.id = '$search' ";
            }
            else
            {
                $query .= " AND leads.customer_name LIKE '%$search%' ";
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
            //group
            $query .= " GROUP BY leads.id ORDER BY jobs.id DESC";


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


             $leads = new Paginator($leads, 15); //<<  >> array_slice($leads, 0, 15),

//            $pagination  =  $this->my_pagination($leads, 15, 1);
//            $leads = $pagination['data'];

            return response()->json([
                'leads' => view('partials.leads', ['leads' => $leads ])->render(),
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

            $leads = Lead::orderBy('updated_at', 'desc')->orderBy('status_id', 'asc')->paginate(15); //<< prev  next >>

            $status = DB::select("SELECT ".
                        "status.name,
                        count(leads.status_id) count
                        FROM leads
                        RIGHT JOIN status ON status.id = leads.status_id
                        GROUP BY status.name");

            $reps = DB::select("SELECT ".
                        "sales_reps.name,
                        count(leads.sales_rep_id) count
                        FROM leads
                        RIGHT JOIN sales_reps ON sales_reps.id = leads.sales_rep_id
                        GROUP BY sales_reps.name");

            $appts = DB::select(
                        "SELECT ".
                        "SUM(if(DATE(appointment) = DATE(now()), 1, 0)) today,
                        SUM(if(DATE(appointment) = DATE(ADDDATE(now(), 1)), 1, 0)) tomorrow,
                        COUNT(appointment) week
                        FROM leads
                        WHERE appointment >= DATE(now()) AND appointment < ADDDATE(DATE(NOW()), INTERVAL 1 WEEK)");

            return view('lead.index', ['leads' => $leads, 'status_count' => $status, 'reps_count' => $reps, 'appts' => $appts[0]]);
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
		$lead->appointment = $request->appointment." ".$request->apptime.":00";
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
        $date = strtotime($request->appointment." ".$request->apptime);
        $this->authorize('edit');
    	$id = $request->id;
    	$lead = Lead::find($id);
        $lead->customer_name = $request->customer;
        $lead->contact_name = $request->contact;
        $lead->street = $request->street;
        $lead->city = $request->city;
        $lead->zip = $request->zip;
        $lead->phone = $request->phone;
        $lead->email = $request->email;
        $lead->appointment =  date('Y-m-d H:i:s', $date);
        $lead->taken_by_id = $request->takenby;
        $lead->source_id = $request->source;
        $lead->sales_rep_id = $request->salesrep;
        $lead->status_id = $request->status;

        $result = $lead->save();

        $result = ($result  == true)? 200: 400;
		return response()->json(['result' => $result, 'date'=> $date]);

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
    public function getcities(Request $request)
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

    public function get_pagination(Request $request)
    {
        $leads = Cache::get('leads_pages');
        $pagination  =  $this->my_pagination($leads, 15, $request->page);
        $leads = $pagination['data'];

        return response()->json([
            'leads' => view('layouts.leads', ['leads' => $leads ])->render(),
            'next_page' => $pagination['next'],
            'prev_page' => $pagination['prev']

        ]);
    }

    function my_pagination($array, $size=15, $page=1)
    {
        if(!is_numeric($page)) return [];
        $chunks = array_chunk($array, $size);
        $chunks_size = sizeof($chunks);
        $_page = ($page-1 < 0)? 0: ($page > $chunks_size)? $chunks_size -1: $page -1;
        $prev = ($_page == 0)? null: $_page - 1;
        $next = ($_page+1 == $chunks_size)? null: $_page+1;
//        dd(['data' => $chunks[$_page], 'prev' => $prev, 'next' => $next]);
        return ['data' => $chunks[$_page], 'prev' => $prev, 'next' => $next];
    }

    public function services()
    {
        echo "Page";
        echo hello('james'); //testing  function inside customHelper
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
