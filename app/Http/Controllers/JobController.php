<?php

namespace App\Http\Controllers;

use App\Feature;
use App\Material;
use App\StyleGroup;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lead;
use App\Job;
use App\Note;
use App\Style;
use App\Removal;
use DB;
use Illuminate\Support\Facades\Input;
use PDF;


class JobController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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

            Cache::forever('jobs_pages', $leads);


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
                'leads' => view('layouts.leads', ['leads' => $leads ])->render(),
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

            $jobs = Job::orderBy('id', 'desc')->paginate(15); //<< prev  next >>

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

            return view('job.index', compact('jobs'));
        }

        /*         $admins = DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->where('users_roles.role_id', '=' ,0)
                ->orderBy($sort, $sort_dir)
                ->paginate($this->perpage);*/
    }
	public function create($id)
    {
        $this->authorize('edit-job');

        $job = new Job;
        $lead = Lead::find($id);
         return view('job/create',
        	[
                'property_types' => DB::table('property_types')->get(),
                'customer_types' => DB::table('customer_types')->get(),
                'job_types' => DB::table('job_types')->Orderby('name', 'asc')->get(),
                'features' => DB::table('features')->Orderby('name', 'asc')->get(),
                'lead' => $lead,
                'job' => $job,
                'features' => Feature::all()
        	]); 
    }

	public function store(Request $request)
    {
        // Validate the request...
        // return var_dump($request);
        $this->authorize('edit-job');

        $result = true;
        $job = new Job;
		$job->lead_id = $request->leadid;

		$job = $this->update_job($job, $request);

		$feat_arr = [];

		foreach($request->features as $key => $value)
		{
			$feat_arr[] = ['job_id' => $job->id, 'feature_id' => $key, 'active' => ($value == 'true')];
		}
		DB::table('feature_job')->insert($feat_arr);

        if (count($request->stylegroups) > 0)//doesn't break if style is empty
        {
            $result &= $this->update_styles($request->stylegroups, $job->id);
		}

		if($request->removals  != null)
        {
            $result &= $this->update_removals($request->removals, $job);
        }

        if($request->materials  != null)
        {
            $result &= $this->update_materials($request->materials, $job->id);
        }

        $message['text'] = 'Job created successufully';
        $message['class'] = 'alert-success';
        $message['title'] = 'Info!';

        if($result == false)
        {
            $message['text'] = 'Error trying to create job';
            $message['class'] = 'alert-danger';
            $message['title'] = 'Error!';
        }

        \Session::flash('message', $message);

        $result = ($result == true)? 'success': 'failed';
        return response()->json(['result' => $result ]);
    }

    public function update(Request $request)
    {
        $this->authorize('edit-job');

        $id = $request->id;
    	$job = Job::findOrFail($id);

        $job = $this->update_job($job, $request);

        $result = ($job != null);

		foreach($request->features as $k => $v)
		{
			DB::table('feature_job')
				->where(['job_id' => $job->id, 'feature_id' => $k])
				->update(['active' => ($v == 'true')]);
		}

		if (count($request->stylegroups) > 0)//doesn't break if style is empty
		{
            $result &= $this->update_styles($request->stylegroups, $job->id);
        }

		if (count($request->removals) > 0)//doesn't break if removal is empty
		{
            $result &= $this->update_removals($request->removals, $job);
		}

        if($request->materials  != null)
        {
            $result &= $this->update_materials($request->materials, $job->id);
        }

        $result = ($result == true)? 'success': 'failed';
        return response()->json(['result' => $result ]);
    }

    private function update_styles($stylegroups, $job_id)
    {
        //return var_dump($request->styles);
        $result = true;
        foreach($stylegroups as $sgroup)
        {
            //update group
            $id = $sgroup['id'];
            $group = new StyleGroup();
            if($id != 0)
            {
                $group = StyleGroup::find($id);
            }
            $group->manufacturer = $sgroup['manu'];
            $group->portlands = $sgroup['portland'];
            $group->orderedby = $sgroup['orderedby'];
            $group->handledby = $sgroup['handledby'];
            $group->delivery_at = $sgroup['delivery'];
            $group->note = $sgroup['note'];
            $group->job_id = $job_id;
            $result &= $group->save();

            if(isset($sgroup['styles']))
                foreach($sgroup['styles'] as $s)
                {
                    $sid = $s['id'];
                    $style = new Style;
                    if($sid != 0)
                    {
                        $style = Style::find($sid);
                    }
                    $style->group_id = $group->id;
                    $style->style = $s['style'];
                    $style->color = $s['color'];
//                    $style->manufacturer = $s['manu'];
                    $style->size = $s['size'];
                    $style->sqft = $s['sqft'];
                    $style->weight = $s['weight'];
                    $style->price = $s['price'];
                    $style->palets = $s['palets'];
                    $style->tumbled = $s['tumbled'];
                    $result &= $style->save();
                }
        }
        return $result;
    }

    private function update_removals($removals, $job)
    {
        //return var_dump($request->styles);
        $result = true;
        foreach($removals as $r)
        {
            $id = $r['id'];
            $removal = new Removal;
            if($id != '0')
            {
                $removal = $job->removals->find($id);
            }
            $removal->job_id = $job->id;
            $removal->name = $r['name'];

            $result &= $removal->save();
        }
        return $result;
    }

    private function update_materials($materials, $job_id)
    {
        $result = true;
        foreach($materials as $material)
        {
            $mat = Material::findOrNew($material['id']);
            $mat->job_id = $job_id;
            $mat->name = $material['name'];
            $mat->qty = $material['qty'];
            $result &= $mat->save();
        }
        return $result;
    }

    private function update_job(Job $job, Request $request)
    {
        $job->size = $request->size;
        $job->customer_type = $request->customertype;
        $job->contractor = $request->contractor;
        $job->date_sold = $this->dbDate($request->datesold);
        $job->job_type = $request->jobtype;
        $job->sqft_price = $request->sqftprice;
        $job->proposal_amount = $request->proposalamount;
        $job->invoiced_amount = $request->invoicedamount;
        $job->pavers_ordered = ($request->paversordered == 'true');
        $job->prelien = ($request->prelien == 'true');
        $job->bluestakes = ($request->bluestakes == 'true');
        $job->property_type = $request->propertytype;
        $job->crew = $request->crew;
        $job->downpayment_done = $request->downpayment;

        $job->save();
        return $job;
    }

    private function dbDate($datestr)
    {
        $date = strtotime($datestr);
        return date('Y-m-d H:i:s', $date);
    }

    public  function style_print($id)
    {
        $stylegroup = StyleGroup::find($id);

        $jobname = $this->job_name($stylegroup);
        $pdf = PDF::loadView('pdf.style', compact('stylegroup', 'jobname'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->inline();

//      return view('pdf.style', compact('stylegroup', 'jobname'));
    }

    public  function style_view($id)
    {
        $stylegroup = StyleGroup::find($id);
        $jobname = $this->job_name($stylegroup);

        return view('pdf.stylehtml', compact('stylegroup', 'jobname'));
    }

    private function job_name($sgroup)
    {
        if($sgroup->job['customer_type'] == 'Contractor')
        {
            return $sgroup->job['contractor'];
        }
        else
        {
            return $sgroup->job->lead['customer_name'];
        }
    }


//    public function upload($lead_id)
//    {
//        //$this->authorize('edit-job');
//
//        $file = Input::file('image');
//
//        $destinationPath = 'drawings/';
//        $filename = md5(microtime() . $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
//        Input::file('image')->move($destinationPath, $filename);
//
//        DB::table('job_images')->insert(['job_id' => $lead_id,
//                                            'path' => $filename,
//            'created_at' => date('Y-m-d H:i:s'),
//            'updated_at' => date('Y-m-d H:i:s')]);
//
//
//        return response()->json(['success' => true, 'file' => asset($destinationPath . $filename)]);
//
//    }

}