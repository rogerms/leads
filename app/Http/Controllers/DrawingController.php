<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Drawing;
use Illuminate\Support\Facades\DB;
//use Input; worked before adding upload function
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Cache;
use Illuminate\Support\Facades\Storage;


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
        $drawing = Drawing::findOrFail($id);

        if(self::can_see($drawing))
        {
            $file_name = $drawing->path;
            // readfile($this->destinationPath.$file_name);
            $file_path = $this->destinationPath . $file_name;
            $contents = Storage::get($file_path);
            header("Content-Type: " . $this->mime_type($file_name));
            header("Content-Length: " . (string)(Storage::size($file_path)));
            echo $contents;

        }
        else{
            abort(403);
        }
    }

    public function get_image_data($id)
    {
        $drawing = Drawing::findOrFail($id);

        if(self::can_see($drawing))
        {
            $file_name = $drawing->path;
            // readfile($this->destinationPath.$file_name);
            $file_path = $this->destinationPath . $file_name;
            $contents = Storage::get($file_path);
            // convert to base64 encoding
            $imageData = base64_encode($contents);
            // Format the image SRC:  data:{mime};base64,{data};
            $src = 'data: '.$this->mime_type($file_name).';base64,'.$imageData;

            return $src;
        }
        return "";
    }

    public function delete(Request $request, $id)
    {
        $this->authorize('edit-job');

        $drawing = Drawing::find($id);
        $lead = $drawing->lead;
        $result = $drawing->delete();
        $drawings = $this->filter($lead->drawings);

        if($request->fmt == 'json')
        {
            return response()->json(['result' => $result]);
        }
        
        return response()->json(['result' => $result,
            'cards' => view('partials.drawing', ['drawings' => $drawings])->render(),
        ]);
    }

    public function create(Request $request, $lead_id)
    {
        //$this->authorize('edit-job');
        $file = $request->file('image');
        $filename = md5(microtime() . $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
        //Input::file('image')->move($this->destinationPath, $filename); // public folder
        Storage::put($this->destinationPath.$filename, File::get($file)); // can use to upload to ftp, amazons3..
        //$path = $request->file('image')->store('drawings');
        if($lead_id < 1) abort(500);

        $d = new Drawing();
        $d->lead_id = $lead_id;
        $d->path = $filename;
        $d->label = Input::get('label');
        $d->visibility = Input::get('visibility');
        $d->created_by = Auth::user()->id;
        $d->save();

        $drawing = Drawing::where('lead_id', $lead_id)->get();
        $drawings = $this->filter($drawing);

        if($request->fmt == 'json')
        {
            return response()->json(['drawing' => $d]);
        }

        return response()->json(['success' => true,
            'cards' => view('partials.drawing', ['drawings' => $drawings])->render(),
            'file' => asset($this->destinationPath . $filename),
            'id' => $d->id
        ]);

    }

    public function change_visibility(Request $request, $id)
    {
        $this->authorize('edit-job');
        $drw = Drawing::find($id);
        $drw->visibility = $request->visibility; //switch
        $result = $drw->save();
        return response()->json(['success' => $result]);
       // Drawing::where('id', $id)->update(['visibility' => true]);
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
        $this->authorize('edit-job');

        $drawing = Drawing::find($id);
        $drawing->label = $request->label;
        if($request->visibility >= 0)
        {
            $drawing->visibility = $request->visibility;
        }

        $drawing->save();

        return response()->json([
            'success' => true,
            'label' => $drawing->label,
            'drawing' =>  $drawing
        ]);
    }

    //unused
    public function destroy($id)
    {
        $this->authorize('delete-job');

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

    public static function filter($drawings)
    {
        if (\Gate::denies('delete-job')) {// not admin
            $draw = [];
            foreach($drawings as $d)
            {
                if(DrawingController::can_see($d))
                {
                    $draw[] =  $d;
                }
            }
            return $draw;
        }
        return $drawings; //admin gets everything
    }
    
    private static function can_see($item)
    {
        ///superuser at least
        if(Gate::allows('delete-job')) return true;
        //public
        if($item->visibility == 2) return true;
        //createdd by user
        if($item->created_by == Auth::user()->id) return true;
        //role = user and  visibility = protected
        if(Auth::user()->role->name == 'User' && $item->visibility == 1) return true;
        //dd(Auth::user()->role);
        return false;
    }

    private function mime_type($filename)
    {
        //find extension
        $arr = explode('.', $filename);
        $extension = end($arr);
        switch(strtolower($extension))
        {
            case 'gif':
                return 'image/gif';
            case 'png':
                return 'image/png' ;
            case 'jpeg':
            case 'jpg':
                return 'image/jpeg';
            case 'bmp':
                return 'image/bmp';
            case 'pdf':
                return 'application/pdf';
            default:
                return 'application/octet-stream';
        }
    }
}
