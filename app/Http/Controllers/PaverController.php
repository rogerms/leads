<?php

namespace App\Http\Controllers;


use App\PaverGroup;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Job;
use App\Paver;
use app\Helpers\Helper;
use PDF;

class PaverController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request, $job_id)
    {
        $job = Job::find($job_id);
        $job->load('pavergroups');
        $job->pavergroups->load('pavers');

        if($request->fmt == 'json')
        {
            return response()->json(['pavergroups' =>  $job->pavergroups]);
        }
        return view('job.paver', compact('job'));
    }

    public function update(Request $request)
    {
        $this->authorize('edit-job');
        $result = true;
        if($request->jobid == null) return 'false';
		if (count($request->pavergroups) > 0)//doesn't break if paver is empty
		{
            $result &= $this->update_pavers($request->pavergroups, $request->jobid);
        }

        $result = ($result == true)? 'success': 'failed';
        return response()->json(['result' => $result ]);
    }

    public function delete($id)
    {
        $this->authorize('edit-job');
        $paver = Paver::find($id);
        $paver->delete();
        return response()->json(['result' => 'success']);
    }

    private function update_pavers($pavergroups, $job_id)
    {
        //return var_dump($request->pavers);
        $result = true;
        foreach($pavergroups as $sgroup)
        {
            //update group
            $id = $sgroup['id'];
            $group = PaverGroup::findOrNew($id);

            $group->manufacturer = $sgroup['manu'];
            $group->portlands = $sgroup['portland'];
            $group->orderedby = $sgroup['orderedby'];
            $group->handledby = $sgroup['handledby'];
            $group->delivery_at = Helper::db_date($sgroup['delivery']);
            $group->note = $sgroup['note'];
            $group->order_date =  Helper::db_date($sgroup['orderdate']);
            $group->delivered = Helper::db_date($sgroup['delivered']);
            $group->delivery_addr = $sgroup['addr'];

            if(empty($sgroup['addr']))
            {
                $job = Job::find($job_id);
                $lead = $job->lead;
                //steet, city, state zip
                $group->delivery_addr = sprintf("%s, %s, %s %s",
                    $lead->street,
                    $lead->city,
                    $lead->state,
                    $lead->zip
                );
            }

            $group->job_id = $job_id;
            $result &= $group->save();

        if(isset($sgroup['pavers']))
            foreach($sgroup['pavers'] as $s)
            {
                $sid = $s['id'];
                $paver = new Paver;
                if($sid != 0)
                {
                    $paver = Paver::find($sid);
                }
                $paver->group_id = $group->id;
                $paver->paver = $s['paver'];
                $paver->color = $s['color'];
                $paver->size = $s['size'];
                $paver->sqft = $s['sqft'];
                $paver->weight = $s['weight'];
                $paver->price = $s['price'];
                $paver->qty = $s['qty'];
                $paver->qty_unit = $s['qty_unit'];
                $paver->tumbled = $s['tumbled'];
                $result &= $paver->save();
            }
        }
        return $result;
    }

    private function dbDate($datestr)
    {
        $date = strtotime($datestr);
        return date('Y-m-d H:i:s', $date);
    }

    public  function pdf($id)
    {
        $pavergroup = PaverGroup::find($id);

        $jobname = $this->job_name($pavergroup);
        $pdf = PDF::loadView('pdf.paver', compact('pavergroup', 'jobname'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream();
    }

    public  function html($id)
    {
        $pavergroup = PaverGroup::find($id);
        $jobname = $this->job_name($pavergroup);

        return view('pdf.paverhtml', compact('pavergroup', 'jobname'));
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
}