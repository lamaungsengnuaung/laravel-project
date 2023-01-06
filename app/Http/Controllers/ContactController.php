<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // admin // direct contact list
    public function list()
    {
        $message = Contact::orderBy('created_at', 'desc')->get();
        // dd($msg);
        return view('admin.contact.list', compact('message'));
    }
    // admin //  ajax read detail
    public function detail(Request $request)
    {
        // logger($request->all());
        $detail = Contact::where('id', $request->id)->first();
        // logger($detail);
        return response()->json($detail, 200);
    }

    // user // direct contactPage
    public function contactPage()
    {
        return view('user.main.contact');
    }
    // save message to database
    public function message(Request $request)
    {
        $this->accountValidationCheck($request);
        if ($request->name != Auth::user()->name || $request->email != Auth::user()->email) {
            return back()->with(['errorMessage' => 'Your Name and Email do not exist ! Try again ....']);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];
        Contact::create($data);
        return back()->with(['messageSuccess' => 'Successfully Submitted ....']);
    }

    private function accountValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'message' => ['required']
        ])->validate();
    }
}
