<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Lead;
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

    public function get_xls($id)
    {
        $lead = Lead::find($id);
        $content = "";

        $lead_arr = $lead->toArray();
        $keys = array_keys($lead_arr);
        $content .= implode(",", $keys)."\n";
        $content .= implode(",", $lead_arr);

        return response($content)
            ->withHeaders([
                'Content-Type' => 'text/csv',
                'Content-disposition' => 'attachment;filename=MyVerySpecial.csv'

            ]);
    }
}
