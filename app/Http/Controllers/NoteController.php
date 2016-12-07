<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NoteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $result = false;
        $note = new Note;
        $note->lead_id = $request->leadid;
        $note->job_id = $request->jobid;
        $note->note = $request->note;
        $note->user_id = Auth::user()->id;
        $result &= $note->save();

        if($result)
        	return response()->json(['result' => 'sucessful', 'note' => $note->note]);
        return response()->json(['result' => 'error']);
    }

    public function add(Request $request)
    {
        
        $note = new Note;
        $note->job_id = $request->jobid;
        $note->lead_id = $request->leadid;
        $user = Auth::user();
        $note->user_id = $user->id;
        $note->note = $request->note;
        $note->is_personal = $user->cant('edit-job'); //true if user == type(viewer)
        $result = $note->save();

        if($result == true)
        {
            return response()->json(['result' => 'success',
                'note' => $note->note,
                'id' => $note->id,
                'created' => $note->created_at->diffForHumans()
            ]);
        }
        return response()->json(['result' => 'failed', 'data' => '']);

    }

    public function delete($note_id)
    {
        $note = Note::find($note_id);
        if(Gate::allows('delete-note', $note))
        {
            $result = $note->delete();
            return response()->json(['result' => $result]);
        }
        return response()->json(['result' => false]);
    }
}
