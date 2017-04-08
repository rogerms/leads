<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Lead;
use App\Job;
use DB;

class ReportController extends Controller
{
    var $destinationPath = 'tmp/';

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function upload()
    {
        $file = Input::file('report');
        $filename = 'report.'.$file->getClientOriginalExtension();
        $file->move($this->destinationPath, $filename);

        // Return it's location
        $result = \Excel::load($this->destinationPath.'/'.$filename)->get();
        $result = $result->toArray();
        return dd($result);
    }

    public function upload_show()
    {
        return view('report.upload');
    }

    public function lead($id)
    {
//        $lead  = Lead::find($id) //doesn't work

//        $data = DB::table('leads')->where('id', $id)->get()->toArray();
//        $data = $data->toArray();
//        $data = Lead::where('leads.id', $id)
//            ->join('sources', 'leads.source_id', '=', 'sources.id')
//            ->join('sales_reps', 'leads.sales_rep_id', '=', 'sales_reps.id')
//            ->join('taken_by', 'leads.taken_by_id', '=', 'taken_by.id')
//            ->join('status', 'leads.status_id', '=', 'status.id')
//            ->get([
//                'leads.id as Id',
//                'contact_name as Customer',
//                'email as Email',
//                'leads.phone as Phone',
//                'street as Street',
//                'city as City',
//                'zip as ZipCode',
//                'sources.name as Source',
//                'status.name as Status',
//                'taken_by.name as Takeby',
//                'sales_reps.name as Rep']);

        $data1  = Lead::with('source')
            ->with('status')
            ->with('salesrep')
            ->with('takenby')->where('id', $id)->get();
        $data = $data1;
        $data->status_name = $data1[0]->status->name;



//        foreach($data1 as $d)
//        {
//            $data[]  = ['contact' => $d->contact_name, 'email' => $d->email, 'phone' => $d->phone, 'street' => $d->street];
//        }
//        dd($data);

        \Excel::create('Leads', function($excel) use($data) {
            $excel->sheet('Sheet 1', function($sheet) use($data) {
                $sheet->fromModel($data);
            });
        })->export('xlsx');

    }

    public function job($id)
    {

        $job = Job::find($id);
        $lead = $job->lead;

        $data[] = [

                    'JobID' => $job->id,
                    'JobNumber' => job_number($job),
                    'JobName' => job_name($job),
                    'DateSold' => $job->date_sold->format('m/d/Y'),
                    'CustomerName' =>  $lead->customer_name,
                    'Phone' =>  $lead->phone,
                    'Email' =>  $lead->email,
                    'StreetAddress' => $lead->street,
                    'City' =>  $lead->city,
                    'State' =>  'UT',
                    'ProposalAmount' => $job->proposal_amount,
                    'DownPaymentPercentage' => number_fmt($job->downpayment).'%',
        ];

        \Excel::create('Job_Export', function($excel) use($data) {
            $excel->sheet('Sheet 1', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');

    }

    public function jobs()
    {

        $jobs = Job::with('lead')->get();
        foreach($jobs as $job) {
            $lead = $job->lead;
            if($job->lead_id == null)
                $lead = new Lead();
            $data []= [
                    'JobID' => $job->id,
                    'JobNumber' => job_number($job),
                    'JobName' => job_name($job),
                    'DateSold' => (empty($job->date_sold))? "": $job->date_sold->format('m/d/Y'),
                    'CustomerName' =>  $lead->customer_name,
                    'Phone' =>  $lead->phone,
                    'Email' =>  $lead->email,
                    'StreetAddress' => $lead->street,
                    'City' =>  $lead->city,
                    'State' =>  $lead->state,
                    'ProposalAmount' => $job->proposal_amount,
                    'DownPaymentPercentage' => number_fmt($job->downpayment, true).'%',
            ];

        }

        \Excel::create('Jobs_Export', function($excel) use($data) {
            $excel->sheet('Sheet 1', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');

    }

    public function leads()
    {

        $leads = Lead::all();

        foreach($leads as $lead) {
            $data []= [
                'LeadID' => $lead->id,
                'CustomerName' =>  $lead->customer_name,
                'Phone' =>  $lead->phone,
                'Email' =>  $lead->email,
                'StreetAddress' => $lead->street,
                'City' =>  $lead->city,
                'State' =>  'UT',
                'CreationDate' => $lead->created_at->format('m/d/Y')
            ];
        }

        \Excel::create('Leads_Export', function($excel) use($data) {
            $excel->sheet('Sheet 1', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');

    }
}
