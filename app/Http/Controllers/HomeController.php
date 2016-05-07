<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Lead;
use App\Source;
use App\Status;
use App\TakenBy;
use Illuminate\Http\Request;
use App\SalesRep;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('home');
    }

    public  function reps()
    {
        $this->authorize('edit-user');
        $reps = SalesRep::all();
        return view('reps', compact('reps'));
    }

    public  function update_rep(Request $request, $id)
    {
        $this->authorize('edit-user');
        $rep = SalesRep::find($id);
        $is_new = false;
        if($rep == null)
        {
            $is_new = true;
            $rep = new SalesRep();
        }
        $rep->name = $request->name;
        $rep->phone = $request->phone;
        $rep->active = $request->active;
        $result = $rep->save();
        $message = $is_new == true? 'Rep added successfully': 'Rep Updated successfully';
        $this->get_message($message, $result);
        return response()->json($message);
    }

    private function get_message($text, $passed = false)
    {
        $message['text'] = $text;
        $message['class'] = 'alert-success';
        $message['title'] = 'Info!';

        if($passed == false)
        {
            $message['class'] = 'alert-danger';
            $message['title'] = 'Error!';
        }
        \Session::flash('message', $message);
    }

    public  function lists()
    {
        $this->authorize('edit-user');
        $takers = TakenBy::all();
        $statuses = Status::all();
        $sources = Source::all();

        return view('lists', compact('takers', 'statuses', 'sources'));
    }

    public  function update_list(Request $request, $id)
    {
        $this->authorize('edit-user');

        $obj = null;
        switch ($request->type)
        {
            case 'status':
                $obj = Status::findOrNew($id);
                break;
            case 'takenby':
                $obj = TakenBy::findOrNew($id);
                break;
            case 'source':
                $obj = Source::findOrNew($id);
                break;
        }

        $obj->name = $request->name;
        $result = $obj->save();
        $message = 'Item Created/Updated successfully';
        $this->get_message($message, $result);
        return response()->json($message);
    }
}
