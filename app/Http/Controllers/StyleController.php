<?php

namespace App\Http\Controllers;


use App\StyleGroup;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\Style;
use DB;
use Illuminate\Support\Facades\Input;


class StyleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($job_id)
    {
        $job = Job::find($job_id);

        return view('job.style', compact('job'));
    }

    public function update(Request $request)
    {
        $this->authorize('edit-job');
        $result = true;
        if($request->jobid == null) return 'false';
		if (count($request->stylegroups) > 0)//doesn't break if style is empty
		{
            $result &= $this->update_styles($request->stylegroups, $request->jobid);
        }

        $result = ($result == true)? 'success': 'failed';
        return response()->json(['result' => $result ]);
    }

    public function delete($id)
    {
        $this->authorize('edit-job');
        $style = Style::find($id);
        $style->delete();
        return response()->json(['result' => 'success']);
    }

    private function update_styles($stylegroups, $job_id)
    {
        //return var_dump($request->styles);
        $result = true;
        foreach($stylegroups as $sgroup)
        {
            //update group
            $id = $sgroup['id'];
            $group = StyleGroup::findOrNew($id);

            $group->manufacturer = $sgroup['manu'];
            $group->portlands = $sgroup['portland'];
            $group->orderedby = $sgroup['orderedby'];
            $group->handledby = $sgroup['handledby'];
            $group->delivery_at = $sgroup['delivery'];
            $group->note = $sgroup['note'];
            $group->order_date = $sgroup['orderdate'];
            $group->delivery_addr = $sgroup['addr'];

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
                $style->size = $s['size'];
                $style->sqft = $s['sqft'];
                $style->weight = $s['weight'];
                $style->price = $s['price'];
                $style->qty = $s['qty'];
                $style->qty_unit = $s['qty_unit'];
                $style->tumbled = $s['tumbled'];
                $result &= $style->save();
            }
        }
        return $result;
    }

    private function dbDate($datestr)
    {
        $date = strtotime($datestr);
        return date('Y-m-d H:i:s', $date);
    }

    public  function style_pdf($id)
    {
        $stylegroup = StyleGroup::find($id);

        $jobname = $this->job_name($stylegroup);
        $pdf = PDF::loadView('pdf.style', compact('stylegroup', 'jobname'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->inline();

//      return view('pdf.style', compact('stylegroup', 'jobname'));
    }

    public  function style_html($id)
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
}