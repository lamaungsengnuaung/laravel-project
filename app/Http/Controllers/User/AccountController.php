<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    // user profile
    public function detail()
    {
        return view('user.profile.account');
    }
    // direct admin editpage
    public function editpage()
    {
        return view('user.profile.edit');
    }
    //  // changePassword Page
    public function changePasswordPage()
    {
        return view('user.profile.changePassword');
    }
    // change password
    public function changePassword(Request $request)
    {
        // dd(Auth::user()->id);
        $this->PasswordValidationCheck($request);

        // dd($request->toArray());
        $user = User::select('password')->where('id', Auth::user()->id)->first();

        $dbhashValue = $user->password; // hash value
        if (Hash::check($request->password, $dbhashValue)) {
            User::select('password')->where('id', Auth::user()->id)
                ->update([
                    'password' => Hash::make($request->newPassword)
                ]);
            return back()->with(['updatedMessage' => 'Successfully Updated new Password']);
        }
        // Auth::login($user);
        return back()->with(['errorMessage' => 'The old password is not match, Try again!']);
    }


    // update account
    /* for image
            1. old img name | check->DB | store */
    public function update($id, Request $request)
    {
        $this->dataValidationCheck($request);

        $data = $this->GetUserData($request);
        if ($request->hasFile('image')) {

            // deletting process of stroge>public>image.png
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;
            Storage::delete('public/' . $dbImage); //shorthand of illuminat/sup/fac/storage/
            // finish process
            // request image named & located at
            $fileName = date('jmYis') . '_' . $request->file('image')->getClientOriginalName();
            $data['image'] = $fileName;
            $request->file('image')->storeAs('public', $fileName); // no need to add '/'

        }
        User::where('id', $id)->update($data);

        return redirect()->route('user#account');
    }

    // request user data
    private function GetUserData($request)
    {
        return [
            'name' => $request['name'],
            'email' => $request['email'],
            'gender' => $request['gender'],

            'phone' => $request['phone'],
            'address' => $request['address'],
            'updated_at' => Carbon::now(),
        ];
    }
    private function PasswordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'password' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ])->validate();
    }
    private function dataValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required'],
            'image' => ['mimes:webp,jpg,png,jpeg'],
            'gender' => ['required'],
            'address' => ['required'],
        ])->validate();
    }
}
