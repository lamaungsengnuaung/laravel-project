<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //

    // changePassword Page
    public function changePasswordPage()
    {
        return view('admin.account.changePassword');
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

    // direct admin detail page
    public function detailpage()
    {
        return view('admin.account.detail');
    }
    // direct admin editpage
    public function editpage()
    {
        return view('admin.account.edit');
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

        return redirect()->route('admin#info');
    }
    /*

    where(function (Builder $query) {
            $key = request('searchData');
            return $query->where('name', 'like', "%{$key}%")
                ->orWhere('address', 'like', "%{$key}%")
                ->orWhere('email', 'like', "%{$key}%");
    })
    */

    // admin list
    public function list()
    {
        $adminsData = User::where('role', '=', 'admin')->where(function ($query) {
            $key = request('searchData');
            $query->where('name', 'like', "%{$key}%")->orwhere('address', 'like', "%{$key}%")->orwhere('email', 'like', "%{$key}%")->orwhere('phone', 'like', "%{$key}%");
        })
            ->paginate(2);
        $adminsData->appends(request()->all());
        // dd($adminsData->toArray());
        return view('admin.account.list', compact('adminsData'));
    }
    // delete
    public function delete($id)
    {
        $delete = User::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => 'Admin Account Removed ..']);
    }
    // direct change roll Page
    public function changeRollpage($id)
    {
        $admin = User::where('id', $id)->first();
        // dd($data);

        return view('admin.account.role', compact('admin'));
    }
    // convert admin
    public function convert(Request $request)
    {
        // dd($request->id);
        $data = ['role' => $request['role']];
        // dd($data);
        $update = User::where('id', $request->id)->update($data);

        return redirect()->route('admin#list')->with(['roleChange' => 'Admin Role Change Successfully ..']);
    }
    // ajax change admin role
    public function change(Request  $request)
    {
        // logger($request->all());
        $updatedRole = ['role' => $request->currentRole];
        User::where('id', $request->adminId)->update($updatedRole);
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
            'image' => ['mimes:jpg,png,jpeg|file'],
            'gender' => ['required'],
            'address' => ['required'],
        ])->validate();
    }

    // Admin controll customer
    public function customerlist()
    {
        $customersData = User::where('role', 'user')->where(function ($query) {
            $key = request('searchData');
            $query->where('name', 'like', "%{$key}%")->orWhere('address', 'like', "%{$key}%")->orwhere('phone', 'like', "%{$key}%");
        })->paginate(2);
        // dd($customersData->toArray());
        $customersData->append(request()->all());
        return view('admin.customer.list', compact('customersData'));
    }
    // customer delete
    public function customerdelete($id)
    {
        $delete = User::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => 'Customer Account banned ..']);
    }
    // ajax change role
    public function customerRole(Request $request)
    {
        logger($request->all());
        $updatedRole = ['role' => $request->currentRole];
        $customer = User::where('id', $request->customerId)->update($updatedRole);
        logger($customer);
    }
}
