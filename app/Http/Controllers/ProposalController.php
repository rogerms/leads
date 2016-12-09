<?php

namespace App\Http\Controllers;

use App\Proposal;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Job;
use DB;
use Illuminate\Support\Facades\URL;
use Auth;


class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function edit(Request $request, $id)
    {
        $this->authorize('edit-job');
        $job_id = $request->jobid;
        $job = Job::find($job_id);
        $_id = $job->proposal['id'];
        $proposal = Proposal::find($_id);
        $user_id = Auth::user()->id;


        if($proposal == null)
        {
            $version = count(Proposal::withTrashed()->where('job_id', $job_id)->get()) + 1;
            $proposal = new Proposal();
            $proposal->job_id  = $job_id;
            $proposal->version  = $version;
        }

        $proposal->text = $request->text;

        if($proposal->created_by == null)
            $proposal->created_by = $user_id;
        $proposal->updated_by = $user_id;

        $result = $proposal->save();

        return response()->json(['result' => $result, 'author' => $proposal->created_by, 'id' =>  $proposal->id]);
    }

    public function create(Request $request, $job_id)
    {
        $this->authorize('edit-job');

        $job = Job::find($job_id);
        $proposal = $job->proposal()->first();
        $version = 1;
        $result = true;
        if(!is_null($proposal))
        {
            $version = $proposal->version + 1;
            $result =  $proposal->delete();
        }

        $np = $job->proposal()->create([
            'text' => "",
            'version' => $version,
            'created_by' => Auth::user()->id
        ]);

        $db = DB::select("select count(*) as counter from job_proposals where job_id = $job->id")[0];

        return response()->json(['result' => $result,
            'id' => $np->id,
            'counter' => $db->counter,
        ]);
    }

    public function index(Request $request, $id)
    {
        $this->authorize('edit-job');

        $props = Job::find($id)->proposals()->get();

        return view('job.proposals', compact('props'));
    }

    public function show(Request $request, $id)
    {
        $job = Job::find($id);
        $job->load('proposal');
        $proposal = $job->proposal ? $job->proposal: new Proposal();
        $proposal->job_id = $id;
        $url = URL::to('/');
        $token = $request->api_token;
        return view('proposal', compact('proposal', 'url', 'token'));
    }
}