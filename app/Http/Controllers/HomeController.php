<?php

namespace App\Http\Controllers;

use app\Helpers\Helper;
use App\Http\Requests;
use App\Source;
use App\Status;
use App\TakenBy;
use Illuminate\Http\Request;
use App\SalesRep;
use DB;

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
     * @return
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

    public  function lists()
    {
        $this->authorize('edit-user');
        $takers = TakenBy::all();
        $statuses = Status::all();
        $sources = Source::all();

        $property_types = DB::table('property_types')->get();
        $customer_types = DB::table('customer_types')->get();
        $job_types = DB::table('job_types')->get();

        return view('lists', compact('takers', 'statuses', 'sources', 'property_types', 'customer_types', 'job_types'));
    }

    public  function update_list(Request $request, $id)
    {
        $this->authorize('edit-user');

        $obj = null;
        $table_name =  null;
        $result = false;
        if(empty($request->name)) return false;

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
            default:
                $table_name = $request->type;
        }

        if($obj != null)
        {
            $obj->name = $request->name;
            $result = $obj->save();
        }
        elseif (!empty($table_name)) {
            if ($id == 0) {
                $result = DB::table($table_name)->insert(
                    ['name' => $request->name, 'updated_at' => date("Y-m-d H:i:s")]
                );
            } else {
                $result = DB::table($table_name)
                    ->where('id', $id)
                    ->update(['name' => $request->name, 'updated_at' => date("Y-m-d H:i:s")]);
            }
        }
        
        $message = 'Item Created/Updated successfully';
        Helper::get_message($message, $result);
        return response()->json($message);
    }
}
