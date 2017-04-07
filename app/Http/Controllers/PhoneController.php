<?php

namespace App\Http\Controllers;

use App\Phone;
use Illuminate\Http\Request;
use App\Http\Requests;

class PhoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->authorize('edit');
        $result = false;
        $phone = new Phone();
        $phone->lead_id = $request->leadid;
        $phone->number = $request->value;
        $phone->label = $request->label;
        $result &= $phone->save();

        if ($result)
            return response()->json(['result' => true, 'note' => $phone->number]);
        return response()->json(['result' => null]);
    }

    public function add(Request $request)
    {
        $this->authorize('edit');

        $phone = new Phone();
        $phone->lead_id = $request->leadid;
        $phone->number = $request->value;
        $phone->label = $request->label;
        $result = $phone->save();

        if ($result == true) {
            return response()->json(['result' => true,
                'number' => $phone->number,
                'label' => $phone->label,
                'id' => $phone->id,
                'created' => $phone->created_at->diffForHumans()
            ]);
        }
        return response()->json(['result' => null, 'data' => '']);

    }

    public function update($data)
    {
        $this->authorize('edit');

        $phone = Phone::findOrFail($data['id']);

        $phone->number = $data['value'];
        $phone->label = $data['label'];

        return $phone->save();
    }

    public function delete($phone_id)
    {
        $this->authorize('edit');

        $phone = Phone::findOrFail($phone_id);
        $result = $phone->delete();
        
        return response()->json(['result' => $result]);
    }
}
