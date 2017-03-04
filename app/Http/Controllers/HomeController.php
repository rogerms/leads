<?php

namespace App\Http\Controllers;

use App\Feature;
use app\Helpers\Helper;
use App\Http\Requests;
use App\Lead;
use App\Source;
use App\Status;
use App\Label;
use App\TakenBy;
use Illuminate\Http\Request;
use App\SalesRep;
use DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $google_auth_page = "/gapi";

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
        Helper::flash_message($message, $result);
        return response()->json($message);
    }

    public  function lists()
    {
        $this->authorize('edit-user');
        $takers = TakenBy::all();
        $statuses = Status::OrderBy('display_order')->get();
        $job_labels = Label::job()->get();
        $lead_labels = Label::lead()->get();
        $sources = Source::all();
        $features = Feature::all();

        $property_types = DB::table('property_types')->get();
        $customer_types = DB::table('customer_types')->get();
        $job_types = DB::table('job_types')->get();

        return view('lists', compact(
            'takers',
            'statuses',
            'sources',
            'property_types',
            'customer_types',
            'job_types',
            'features',
            'lead_labels',
            'job_labels'
        ));
    } //        return view('label.edit');

    public  function labels()
    {
        $this->authorize('edit');
        $job_labels = Label::job()
            ->leftJoin('job_label', function ($join) {
                $join->on('job_label.label_id', '=', 'labels.id')
                     ->whereNull('deleted_at');
            })
            ->select(DB::raw('labels.*, COUNT(job_label.id) as number'))
            ->groupBy('labels.id')
            ->get();

        $lead_labels = Label::lead()
            ->leftJoin('lead_label', function ($join) {
                $join->on('lead_label.label_id', '=', 'labels.id')
                    ->whereNull('deleted_at');
            })
            ->select(DB::raw('labels.*, COUNT(lead_label.id) as number'))
            ->groupBy('labels.id')
            ->get();



        return view('label.edit', compact(
            'lead_labels',
            'job_labels'
        ));
    }

    public  function delete_label($id)
    {
        $label = Label::find($id);
        if(\Gate::allows('edit'))
        {
            $label->jobs()->detach();
            $label->leads()->detach();
            $result = $label->delete();
            return response()->json(['result' => $result]);
        }
        return response()->json(['result' => false]);
    }

    public  function sort_labels(Request $request)
    {
        $display_order = 0;
        $result = true;
        if(!empty($request->item))
        foreach ($request->item as $id)
        {
            $result &= DB::table('labels')
                ->where('id', $id)
                ->update(['display_order' => $display_order++]);
        }

        if(!empty($request->status))
        foreach ($request->status as $id)
        {
            $result &= DB::table('status')
                ->where('id', $id)
                ->update(['display_order' => $display_order++]);
        }

        return response()->json(['result' => $result]);
    }

    public  function update_list(Request $request, $id)
    {
        $this->authorize('edit-user');

        $obj = null;
        $table_name =  null;
        $result = false;
        $action = "Created/Updated";
        $label_type = null;
        if(empty($request->name)) return false;

        switch ($request->type)
        {
            case 'status':
                $obj = Status::findOrNew($id);
                break;
            case 'job_label':
                $obj = Label::findOrNew($id);
                $label_type = 'job';
                break;
            case 'takenby':
                $obj = TakenBy::findOrNew($id);
                break;
            case 'source':
                $obj = Source::findOrNew($id);
                break;
            case 'feature':
                $obj = Feature::findOrNew($id);
                break;
            case 'lead_label':
                $obj = Label::findOrNew($id);
                $label_type = 'lead';
                break;
            default:
                $table_name = $request->type;
        }

        if($obj != null)
        {
            $obj->name = $request->name;
            if($request->order != null)
                $obj->display_order = $request->order;

            if(!empty($label_type))//only for labels table
            {
                $obj->type = $label_type;
            }

            $result = $obj->save();
        }
        elseif (!empty($table_name)) {
            if ($id == 0) {
                $data = ['name' => $request->name, 'updated_at' => date("Y-m-d H:i:s")];
                $result = DB::table($table_name)->insert($data);
                $action = "Created";
            } else {
                $result = DB::table($table_name)
                    ->where('id', $id)
                    ->update(['name' => $request->name, 'updated_at' => date("Y-m-d H:i:s")]);
            }
        }
        $message = sprintf('Item %s table successfully', $action);
        Helper::flash_message($message, $result);
        return response()->json($message);
    }

    public function gapi()
    {
        $google = Helper::google_client();

        if (\Request::has('code'))
        {//store token
            $google->authenticate(\Request::input('code'));
            $this->sessionAccessToken($google->getAccessToken());
            Helper::put_refresh_token($google->getRefreshToken());
            Helper::flash_message('You are now successfully authenticated!', true);
            return redirect($this->google_auth_page);
        }

        $refresh_token = Helper::get_refresh_token();
        if(!empty($refresh_token))
        {
            if(!Session::has('access_token'))
            {
                Session::put('access_token', "placeholder");//forcing logout button to appear
            }
            return view('gapi.index');
        }
        // if user is authorized, but token is not set
        if ($google->getRefreshToken())
        {
            Helper::put_refresh_token($google->getRefreshToken());
            return view('gapi.index');
        }
        // if token is not set, print Google API Auth link
        else
        {
            return view('gapi.index')->with('google_auth_url', $google->createAuthUrl());
        }
    }

    public function logout_gapi()
    {
        $refresh_token = Helper::get_refresh_token();
        $google_client = Helper::google_client();

        if(empty($refresh_token))
        {//if no refresh token try to get access_code from session...
            $google_client->setAccessToken(Session::get('access_token'));
        }
        else//with refresh token we can get auth
        {
            $google_client->refreshToken($refresh_token);
        }

        $google_client->revokeToken();
        Session::forget('access_token');
        Helper::del_refresh_token();
        Helper::flash_message('Successfully logged out! ', true);
        return redirect($this->google_auth_page);
    }

    public function add_calendar_event($id)
    {
        $refresh_token = Helper::get_refresh_token();
        if(empty($refresh_token)) {
            return response()->json(['success' => false, 'url' => $this->google_auth_page]);
        }

        $google = Helper::google_client();
        $google->refreshToken($refresh_token);

        $service = new \Google_Service_Calendar($google);
        $event = $this->calendar_event($id);
        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
        return response()->json(['success' => true, 'msg' => $event->htmlLink]);
    }

    private function calendar_event($id)
    {
        $lead = Lead::findOrFail($id);

        $event = new \Google_Service_Calendar_Event([
            'summary' => $lead->customer_name,
            'location' => "$lead->street, $lead->city, UT $lead->zip",
            'description' => "http://leads.strongrockpavers/lead/$id",

            'start' => [
                'dateTime' => $lead->appointment->format("Y-m-d\TH:i:s"),
                'timeZone' => 'America/Denver',
            ],

            'end' => [
                'dateTime' => $lead->appointment->addHour()->format("Y-m-d\TH:i:s"),
                'timeZone' => 'America/Denver',
            ],
                'attendees' => [
                    ['email' => strtolower($lead->salesrep->name).'@strongrockpavers.com' ],
                    ['email' => 'sales@strongrockpavers.com'],
                ],
            'reminders' => [
                'useDefault' => FALSE,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 24 * 60],
                    ['method' => 'popup', 'minutes' => 15],
                ],
            ],
        ]);

        return $event;
    }

    private function  sessionAccessToken($token)
    {
        Session::put('access_token', $token);
    }

    public function sqltest()
    {
//        $users = DB::connection('sqlsrv')->table('users')->get();
//        foreach ($users as $user)
//        {
//            echo $user;
//        }
        phpinfo();
        return 'done';
    }
}
