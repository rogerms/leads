<?php

namespace App\Http\Controllers;

use App\Drawing;
use app\Helpers\Helper;
use app\Helpers\Notification;
use app\Helpers\NotificationHub;
use App\Label;
use App\Material;
use App\Note;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Job;
use App\Removal;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use PDF;
use Auth;


class JobController extends Controller
{
    var $destinationPath = 'tmp/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $this->authorize('read-job', $job);

        $job->load('notes', 'features', 'removals', 'materials', 'proposal');

        $arr = [
            'job' => $job,
            'property_types' => DB::table('property_types')->get(),
            'customer_types' => DB::table('customer_types')->get(),
            'job_types' => DB::table('job_types')->Orderby('name', 'asc')->get(),
            'features' => DB::table('features')->Orderby('name', 'asc')->get()
        ];

        if($request->fmt == 'json')
        {
            return response()->json($arr);
        }

        return view('lead.lead', $arr);
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
//
//            $sortby = ($request->sortby) ? $request->sortby : 'jobs.updated_at';
//            $sortby = str_replace(
//                ['ID', 'Job#', 'Customer Name', 'Date Sold', 'City', 'Sales Rep'],
//                ['jobs.id', 'code', 'customer_name', 'date_sold', 'city', 'sales_reps.name'],
//                $sortby
//            );
/*
            $direction = ($request->sortdirection == 1) ? 'ASC' : 'DESC';

            $jobs = Job::join('leads', 'jobs.lead_id', '=', 'leads.id')
                ->join('sales_reps', 'sales_reps.id', '=', 'leads.sales_rep_id')
                ->leftJoin('paver_groups', 'paver_groups.job_id', '=', 'jobs.id')
                ->leftJoin('notes', function($join){
                    $join->on('notes.job_id', '=', 'jobs.id')
                        ->whereNull('notes.deleted_at')
                        ->where('notes.note',  'not like',  '#%');
                })

                ->orderBy($sortby, $direction)
                ->select('jobs.id', 'code', 'leads.id as lead_id', 'customer_name', 'date_sold', 'city',
                    'sales_reps.name as sales_rep',
                    'crew',
                    'needs_skid as skid',
                    'jobs.start_date',
                    'jobs.size as job_size',
                     DB::raw("GROUP_CONCAT(DISTINCT notes.note ORDER BY notes.job_id SEPARATOR ', ') as job_notes")
// GROUP_CONCAT(DISTINCT CONCAT(DATE_FORMAT(paver_groups.delivery_at, '%c/%e'), if(paver_groups.delivered is null, '', ' &#x2714;'))  ORDER BY paver_groups.job_id,paver_groups.id SEPARATOR '<br>') as pavers_delivery,")
                    )
                ->groupBy('notes.job_id')
                ->where('jobs.date_sold', '<>', '')
                ->paginate(15);

            $jobs->appends(['sortby' => $sortby, 'sortdirection' => $request->sortdirection]);
            */

            $search = str_replace(["'", '"', 'delete', 'update'], ["\\'", "\\\"", ''], $request->searchtx);

            $query = "SELECT ".
                "leads.customer_name,
            leads.city,
            DATE_FORMAT(leads.appointment, '%b %e at %h:%i%p') appointmentfmt,
            status.name as status_name,
            sales_reps.name as sales_rep,
            taken_by.name as taken_by_name,
            sources.name as source_name,
            jobs.lead_id as lead_id,
            jobs.code,
            jobs.id,
            GROUP_CONCAT(DISTINCT labels.name ORDER BY labels.display_order SEPARATOR '<br>') as job_labels,
			DATE_FORMAT(jobs.start_date, '%m/%d/%Y') as start_date,
            DATE_FORMAT(jobs.date_sold, '%m/%d/%Y') as date_sold,
            GROUP_CONCAT(DISTINCT jobs.size ORDER BY jobs.id SEPARATOR '<br>') as job_size,
            GROUP_CONCAT(DISTINCT j_notes.note ORDER BY j_notes.job_id SEPARATOR '. ') as job_notes,
            GROUP_CONCAT(DISTINCT CONCAT(DATE_FORMAT(paver_groups.delivery_at, '%c/%e'), if(paver_groups.delivered is null, '', ' &#x2714;'))  ORDER BY paver_groups.job_id,paver_groups.id SEPARATOR '<br>') as pavers_delivery,
            GROUP_CONCAT(DISTINCT concat(material_rb.qty, 'x', material_rb.delivered) ORDER BY material_rb.job_id SEPARATOR '<br>')  as rb_qty,
            GROUP_CONCAT(DISTINCT concat(material_sand.qty, 'x', material_sand.delivered) ORDER BY material_sand.job_id  SEPARATOR '<br>') as sand_qty,
            GROUP_CONCAT(DISTINCT if(jobs.needs_skid=1,'&#x2714;', '') ORDER BY jobs.id SEPARATOR ' ') as skid,
            GROUP_CONCAT(DISTINCT jobs.crew ORDER BY jobs.id SEPARATOR ' ') as crew
            FROM leads
            LEFT JOIN notes ON notes.lead_id = leads.id
            LEFT JOIN jobs ON jobs.lead_id=leads.id
            LEFT JOIN notes j_notes ON j_notes.job_id = jobs.id AND j_notes.deleted_at is null AND j_notes.note not like '#%'
            LEFT JOIN status ON status.id = leads.status_id
            LEFT JOIN sales_reps ON sales_reps.id = leads.sales_rep_id
            LEFT JOIN taken_by ON taken_by.id = leads.taken_by_id
            LEFT JOIN sources ON sources.id = leads.source_id
            LEFT JOIN job_label ON job_label.job_id = jobs.id and job_label.deleted_at is null
            LEFT JOIN labels ON labels.id = job_label.label_id AND labels.type = 'job'
            LEFT JOIN job_materials as material_rb ON material_rb.job_id = jobs.id and material_rb.name='rb'
            LEFT JOIN job_materials as material_sand ON material_sand.job_id = jobs.id and material_sand.name='sand' 
            LEFT JOIN paver_groups ON paver_groups.job_id = jobs.id
            WHERE jobs.date_sold is not null";

            if(count($request->labels) > 0)
            {
                $query .= " AND labels.name IN (".implode(",", $request->labels).")";
            }

            $sort = "jobs.updated_at desc";
            if($request->sortby)
            {
                $sortby = str_replace(
                    ['id', 'job#', 'customer name', 'date sold', 'city', 'sales rep', 's/f','pavers','rb','sand','date sold','start date','skid','notes'],
                    ['jobs.id', 'jobs.code', 'customer_name', 'jobs.date_sold', 'city', 'sales_reps.name', 'size', '','material_rb.qty','material_sand.qty', 'jobs.date_sold','start_date','',''],
                    strtolower($request->sortby)
                );

                if(!empty($sortby))
                {
                    $direction = ($request->sortdirection == 1)? 'ASC': 'DESC';
                    $sort = "$sortby $direction";
                }
            }

            $query .= " GROUP BY jobs.id ORDER BY $sort";

            //return $query;
            $jobs = DB::select($query);
            $counters = $this->process_counters($jobs);
            $perPage = 20;
            $currentPage = $request->page?:1;
            $currentItems = array_slice($jobs, $perPage * ($currentPage - 1), $perPage);

            $jobs = new LengthAwarePaginator($currentItems, $counters['jobs'], $perPage, $currentPage);
            $jobs->setPath('jobs');

            //** notes */
            //LeadController::process_job_notes($leads);
//            dd($leads);\

            if($request->fmt == 'json')
            {
                return response()->json(compact('jobs'));
            }

            return response()->json([
                'jobs' => view('partials.jobs', ['jobs' => $jobs])->render(),
                'sortby' => $sort,
                'links' => sprintf('<div>%s</div>', $jobs->links()),
                'labels' => $counters['labels'],
                'count' => $counters['jobs'],
            ]);
        }
        else
        {
            $labels = Label::job()->select('name', DB::raw('0 as count'))->get();
            return view('job.index',
                [
                    'jobs' => [],
                    'labels_count' => $labels
                ]);
        }
    }

	public function create(Request $request, $id)
    {
        $this->authorize('edit-job');

        $job = new Job;
        $job->lead_id = $id;
        $job->save();

        if ($request->fmt == 'json')
        {
            return response()->json(['id' => $job->id]);
        }
        return redirect("lead/$id");
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
		DB::table('job_features')->insert($feat_arr);

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

        $materials = null;
        $removals = null;
        $job = $this->update_job($job, $request);
        $labels = null;

        $result = ($job != null);

        if($job->just_sold === true)
        {
            //update lead status
            $ld = $job->lead;
            $ld->status_id = 7; //status=sold
            $ld->save();
            //send email
            $this->emailJobSold($job);
            //add just_sold label
            $labels = $this->add_label($job, 'just sold');
            //job sold notification
            $this->sendNotification($job);
        }


        if($request->features)
		foreach($request->features as $k => $v)
		{
            $id = DB::table('job_features')->where(['job_id' => $job->id, 'feature_id' => $k])->value('feature_id');
            if(empty($id))
            {
                DB::table('job_features')->insert([
                        'job_id' => $job->id,
                        'feature_id' => $k,
                        'active' => ($v == 'true')
                    ]);
            }
            else
            {
                DB::table('job_features')
                    ->where(['job_id' => $job->id, 'feature_id' => $k])
                    ->update(['active' => ($v == 'true')]);
            }
		}

		if (count($request->stylegroups) > 0)//doesn't break if style is empty
		{
            $result &= $this->update_styles($request->stylegroups, $job->id);
        }

		if (count($request->removals) > 0)//doesn't break if removal is empty
		{
            $removals = $this->update_removals($request->removals, $job);
		}

        if($request->materials  != null)
        {
            $materials = $this->update_materials($request->materials, $job);
        }

        $note = new Note();
        if($result  == true)
        {
            if (!empty($request->note))
            {
                $note->job_id = $job->id;
                $note->note = $request->note;
                $note->user_id = Auth::user()->id;
                $note->created = $note->save();
            }
        }

        $result = ($result == true)? 'success': 'failed';
        $updated = $job->updated_at->format('m/d/Y h:i A');

        return response()->json([
            'result' => $result, //succesful or not
            'updated' => $updated, //job data last updated
            'note' => $note, //if a new note was created return it to be added to the list
            'sold'=> $request->startdate, //test
            'jobnum' => Helper::show_job_num($job), //update jobnumber on job title
            'labels' => $labels,
            'materials' => $materials,
            'removals' => $removals
        ]);
    }

    private function add_label($job, $name)
    {
        $label = Label::where('name', $name)->first();
        if(!empty($label))
        {
            $job->labels()->attach($label->id);

            return $job->labels()->get();
        }
        return null;
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
        $new = false;
        foreach($removals as $r)
        {
            $id = $r['id'];
            $removal = new Removal;
            if($id != '0')
            {
                $removal = $job->removals->find($id);
            }
            else
            {
               $new = true;
            }
            $removal->job_id = $job->id;
            $removal->name = $r['name'];

            $removal->save();
        }
        if($new === true) return $job->removals()->get();

        return null;
    }

    private function update_materials($materials, $job)
    {
        $new = false;
        foreach($materials as $material)
        {
            if($material['id'] == 0)
                $new = true;

            $mat = Material::findOrNew($material['id']);
            $mat->job_id = $job->id;
            $mat->name = $material['name'];
            $mat->qty = $material['qty'];
            $mat->qty_unit= $material['unit'];
            $mat->vendor = $material['vendor'];
            $mat->delivered = $material['delivered'];
            $mat->save();
        }

        if($new === true) return $job->materials()->get();

        return null;
    }

    private function update_job(Job $job, Request $request)
    {
        $sold = Helper::db_date($request->datesold);
        $just_sold = false;

//        dd($job->date_sold);

        if(empty($job->date_sold) && $sold != null)
        {
            $job->code = $this->create_job_code($job);
            $just_sold = true;
        }

        $job->size = $request->size;
        $job->customer_type = $request->customertype;
        $job->contractor = $request->contractor;
        $job->date_sold = $sold;
        $job->job_type = $request->jobtype;
        $job->sqft_price = $request->sqftprice;
        $job->proposal_amount = $request->proposalamount;
        $job->invoiced_amount = $request->invoicedamount;
        $job->pavers_ordered = ($request->paversordered == 'true');
        $job->prelien = ($request->prelien == 'true');
        $job->bluestakes = ($request->bluestakes == 'true');
        $job->noadd_fee = ($request->noaddfee == 'true');
        $job->needs_skid = ($request->skid == 'true');
        $job->property_type = $request->propertytype;
        $job->crew = $request->crew;
        $job->downpayment = $request->downpayment;
        $job->start_date = Helper::db_date($request->startdate);
        $job->signed_at = Helper::db_date($request->signedat);

        $job->save();

        $job->just_sold = $just_sold;

        return $job;
    }
    
    public function print_preview_html($id)
    {
        $job = Job::find($id);
        $job->load('lead');
        $draw = Drawing::where('lead_id',  $job->lead_id)->where('visibility', 2)->get();

        $path = count($draw) > 0? $draw[0]->path: '';
        $job->name = $this->get_job_name($job);
        $job->style_summary = $this->get_style_summary($job);

        return view('pdf.job', compact('job', 'path'));
    }

    public function print_preview(Request $request, $id)
    {
        $this->authorize('edit');
        $job = Job::find($id);
        $output = isset($request->output);
        return $this->get_job_pdf($job, $output);
    }

    public function print_installer($id)
    {
        $job = Job::find($id);
        $draws = Drawing::where('lead_id',  $job->lead_id)->where('label', 'like', 'installer%')->get();
        $imgs_data = [];

        foreach ($draws as $draw)
        {
            if(isset($draw->path))
            {
                $_draw = new DrawingController();
                $imgs_data[] = $_draw->get_image_data($draw->id);
            }
        }

        $job->name = $this->get_job_name($job);
        $job->style_summary = $this->get_style_summary($job);

        return view('pdf.installer', compact('job', 'descs', 'imgs_data'));

        //$pdf = \PDF::loadView('pdf.installer', compact('job', 'descs', 'img_data'));
        //$pdf->setPaper('letter', 'portrait');
        //return $pdf->stream();
    }

    private function get_job_pdf(Job $job, $output=false)
    {
        $draw = Drawing::where('lead_id',  $job->lead_id)->public()->first();
        $job->descs = Note::where('job_id', $job->id)->where('note', 'like', '#description %')->get();
//        $draw = $job->lead->drawings->first(function ($key, $value) {
//            return $value->visibility == 2;
//        });
        $path = isset($draw->path)? $draw->path: '';
        $job->name = $this->get_job_name($job);
        $job->style_summary = $this->get_style_summary($job);

        $pdf = \PDF::loadView('pdf.job', compact('job', 'path'));
        $pdf->setPaper('letter', 'portrait');

        if($output === true)
            return $pdf->output();
        return $pdf->stream();
    }

    public function email_pdf($id)
    {
        $job = Job::find($id);
        $data = $this->get_job_pdf($job);
        $email_body = "Check attachment for a copy of the proposal\n\nThank you\n".$job->lead->salesrep['name'];

        \Mail::raw($email_body, function ($message) use($job, $data) {
            $message->from('sales@strongrockpavers.com', 'Strong Rock Pavers');
            $message->to('office@strongrockpavers.com');
            $message->subject("Job Proposal");
            $message->attachData($data, 'document.pdf');
        });
        $passed = true;
        Helper::flash_message('Email sent successufully', $passed);

        return back();
    }

    public function email_pdf_customer(Request $request, $id)
    {
        $job = Job::find($id);
        $data = $this->get_job_pdf($job);

        $email_body = urldecode($request->message);

        $v = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'message'  => 'required',
            'subject'  => 'required'
        ]);

        if ($v->fails())
        {
            $error = implode(' ', $v->errors()->all());
            Helper::flash_message($error, false);
            return redirect()->back();
        }

        \Mail::raw($email_body, function ($message) use($data, $request) {
            $message->from('sales@strongrockpavers.com', 'Strong Rock Pavers');
            $message->to($request->email);
            $message->subject($request->subject);
            $message->attachData($data, 'document.pdf');
        });

        Helper::flash_message('Email sent successufully', true);//passed=true|false
        return back();
    }

    private function get_style_summary($job)
    {
        $notes = $job->notes->filter(function ($value, $key) {
            return (0 === strpos($value->note, '#paver '));
        });

       if($notes->first() != null)
           return str_replace("#paver ", "", $notes->first()->note);

        return '';
    }

    private function get_job_name($job)
    {
        if($job->customer_type == 'Contractor')
            return $job->contractor;
        return $job->lead->customer_name;
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

    private function create_job_code($job)
    {
        if(!empty($job->code)) return $job->code;

        $result = DB::select("SELECT CONCAT('U', DATE_FORMAT(now(), '%y'),'-', RIGHT(CONCAT('000',COUNT(id)+1), 3)) `code` FROM jobs j WHERE (j.date_sold IS NOT NULL AND YEAR(j.date_sold)=YEAR(NOW())) OR j.code REGEXP CONCAT('^U',DATE_FORMAT(now(),'%y'))");
        $result[0]->code;
        return $result[0]->code;
    }

    private function emailJobSold(Job $job)
    {
        $url = url('lead/'.$job->lead_id);
        $email_body = "Job with id:$job->id and number:$job->code has been sold\n\n".
                      "<a href='$url'>$url</a>";

        \Mail::raw($email_body, function ($message) use($job) {
            $message->from('sales@strongrockpavers.com', 'Strong Rock Pavers');
            $message->to('office@strongrockpavers.com');
            $message->subject("Job Sold");
        });
        return true;
    }

    public function sendNotification(Job $job)
    {
        $connectionString = 'Endpoint=sb://srp-notification.servicebus.windows.net/;SharedAccessKeyName=DefaultFullSharedAccessSignature;SharedAccessKey=nXoAUATnM/GMkKGpOkK6FUf3Xk014pV9nBdqJR0hYVM=';
        $hubPath = "leads";

        //---- chrome extensions notification
        $hub = new NotificationHub($connectionString, $hubPath);
        $leadurl = url("lead/$job->lead_id");
        $jobname = $this->get_job_name($job);
        $jobid = $job->id;
        $leadid = $job->lead_id;

        $message = json_encode(['data' => [
            'name' => $jobname,
            'jobid' => $jobid,
            'leadurl' => $leadurl
            ]
        ]);


        $notification = new Notification("gcm", $message);
        $hub->sendNotification($notification, ""); //param: notification, tag

        //---- windows store app notification
        $toast = "<toast activationType='protocol' launch='$leadurl'>
                   <visual>
                    <binding  template='ToastGeneric'>
                      <text>Job Just Sold</text>
                      <text>Name: $jobname</text>
                      <text>ID: $jobid</text>
                      <image placement='AppLogoOverride' src='ms-appx:///Assets\BadgeLogo.scale-200.png' />
                    </binding>
                  </visual>
                  <audio src='ms-winsoundevent:Notification.Reminder'/>
                 <actions>
                    <action activationType='foreground' content='Show' arguments='$leadid' />
                    <action activationType='protocol' content='Show on Browser' arguments='$leadurl' />
                  </actions>
                </toast>";

        $notification = new Notification("windows", $toast);
        $notification->headers[] = 'X-WNS-Type: wns/toast';
        $hub->sendNotification($notification, null);

        return true;
    }

    public function show_note()
    {
        return view('note');
    }

    public function save_note()
    {
        return 'done';
    }

    private function process_counters($jobs)
    {
        $labels_count = [];

        foreach($jobs as $job)
        {
            $labels = explode("<br>", $job->job_labels);
            foreach($labels as $label)
            {
                if(!isset($labels_count[$label]))
                    $labels_count[$label] = 0;

                $labels_count[$label]++;
            }
        }
        return [
            'jobs' => count($jobs),
            'labels' => $labels_count,
        ];
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