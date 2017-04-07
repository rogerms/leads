<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;
use App\Http\Requests;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->authorize('edit');
        $result = false;
        $email = new Email();
        $email->lead_id = $request->leadid;
        $email->email = $request->value;
        $email->label = $request->label;
        $result &= $email->save();

        if ($result)
            return response()->json(['result' => true, 'note' => $email->email]);
        return response()->json(['result' => null]);
    }

    public function add(Request $request)
    {
        $this->authorize('edit');

        $email = new Email();
        $email->lead_id = $request->leadid;
        $email->email = $request->value;
        $email->label = $request->label;
        $result = $email->save();

        if ($result == true) {
            return response()->json(['result' => true,
                'email' => $email->email,
                'label' => $email->label,
                'id' => $email->id,
                'created' => $email->created_at->diffForHumans()
            ]);
        }
        return response()->json(['result' => null, 'data' => '']);

    }

    public function update($data)
    {
        $this->authorize('edit');

        $email = Email::findOrFail($data['id']);

        $email->email = $data['value'];
        $email->label = $data['label'];

        return $email->save();
    }

    public function delete($email_id)
    {
        $this->authorize('edit');

        $email = Email::findOrFail($email_id);
        $result = $email->delete();
        
        return response()->json(['result' => $result]);
    }
}
