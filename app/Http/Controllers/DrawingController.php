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
        $result = $drawing->delete();
        $drawings = $this->filter($lead->drawings, $lead);
        
        return response()->json(['result' => $result,
            'cards' => view('partials.drawing', ['drawings' => $drawings])->render(),
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
        $d->label = Input::get('label');
        $d->created_by = Auth::user()->id;
        $d->save();

        $drawing = Drawing::where('lead_id', $lead_id)->get();
        $drawings = $this->filter($drawing);

        return response()->json(['success' => true,
            'cards' => view('partials.drawing', ['drawings' => $drawings])->render(),
            'file' => asset($this->destinationPath . $filename),
            'id' => $d->id
        ]);

    }

    public function select(Request $request, $id)
    {
        $drw = Drawing::find($id);
        $drw->selected = !$drw->selected; //switch
        $result = $drw->save();
        return response()->json(['success' => $result]);
       // Drawing::where('id', $id)->update(['selected' => true]);
    }

    public function printr($arr)
    {
        print("<pre>".print_r($arr, true)."</pre>");
    }

    public function index()
    {
        //
    }
    public function edit(Request $request, $id)
    {
        $this->authorize('edit');

        $drawing = Drawing::find($id);
        $drawing->label = $request->label;
        $drawing->save();

        return response()->json([
            'success' => true,
            'label' => $drawing->label
        ]);
    }

    //unused
    public function destroy($id)
    {
        $this->authorize('edit');

        $drawing = Drawing::find($id);
        $lead = $drawing->lead;
        $path = $drawing->path;
        $result = $drawing->delete();
        if($result == true) // from folder 
        {
            $result &= unlink($this->destinationPath.$path);
        }
        return response()->json(['result' => $result,
            'cards' => view('partials.drawing', ['drawings' => $lead->drawings])->render(),
        ]);
    }

    private function filter($drawings)
    {
        if (\Gate::denies('delete-job')) {
            $draw = [];
            foreach($drawings as $d)
            {
                if($d->selected == 1 || $d->created_by == Auth::user()->id)
                    $draw[] =  $d;
            }
            return $draw;
        }
        return $drawings;
    }
}
