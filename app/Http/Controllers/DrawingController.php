<?php

namespace App\Http\Controllers;

use App\Style;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Drawing;
use Illuminate\Support\Facades\DB;
//use Input; worked before adding upload function
use Auth;
use Illuminate\Support\Facades\Input;
use Cache;


class DrawingController extends Controller
{
    var $destinationPath = 'drawings/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {

    }

    public function delete($id)
    {
        $this->authorize('edit');

        $drawing = Drawing::find($id);
        $lead = $drawing->lead;
        $path = $drawing->path;
        $result = $drawing->delete(); //from database
        if($result == true) // from folder
        {
            $result &= unlink($this->destinationPath.$path);
        }
        return response()->json(['result' => $result,
            'cards' => view('partials.drawing', ['drawings' => $lead->drawings])->render(),
        ]);
    }

    public function create($lead_id)
    {
        //$this->authorize('edit-job');

        $file = Input::file('image');
        $filename = md5(microtime() . $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
        Input::file('image')->move($this->destinationPath, $filename);

        if($lead_id < 1) abort(500);

        $d = new Drawing();
        $d->lead_id = $lead_id;
        $d->path = $filename;
        $d->title = Input::get('title');
        $d->save();

        $drawings = Drawing::where('lead_id', $lead_id)->get();

        return response()->json(['success' => true,
            'cards' => view('partials.drawing', ['drawings' => $drawings])->render(),
            'file' => asset($this->destinationPath . $filename),
            'id' => $d->id
        ]);

    }

    public function select(Request $request, $id)
    {
        $lead_id = $request->leadid;
        Drawing::where('lead_id', $lead_id)->update(['selected' => false]);
        Drawing::where('id', $id)->update(['selected' => true]);

    }

    public function printr($arr)
    {
        print("<pre>".print_r($arr, true)."</pre>");
    }

    public function index()
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
