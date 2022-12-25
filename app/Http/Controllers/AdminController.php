<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    // direct details page
    public function details(){
        return view('admin.account.details');
    }

    // edit details page
    public function edit(){
        return view('admin.account.edit');
    }

    // update details page
    public function update($id, Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        // image
        if($request->hasFile('image')){
            // old image check  | exist -> old image(delete) | new image store
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $request -> file('image')->storeAs('public', $fileName);
            $data ['image'] = $fileName;
        }

        User::where('id', $id)->update($data);
        return redirect()-> route('admin#details')->with(['UpdateSuccess' => 'Account Details Updated']);
    }

    // direct admin list
    public function list(){
        $admin = User::when(request('key'), function($query){
                $query->orWhere('name', 'like', '%'.request('key').'%')
                        ->orWhere('email', 'like', '%'.request('key').'%')
                        ->orWhere('gender', 'like', '%'.request('key').'%')
                        ->orWhere('phone', 'like', '%'.request('key').'%')
                        ->orWhere('address', 'like', '%'.request('key').'%');
                })
                ->where('role', 'admin')
                ->paginate(3);
                $admin->appends(request()->all());
        return view('admin.account.list', compact('admin'));
    }

    // admin ajax change role
    public function ajaxChangeRole(Request $request){
        $updateSource = [ 'role' => $request->role ];
        User::where('id', $request->userId)->update($updateSource);
    }

    // admin change role page
    public function changeRole($id){
        $account = User::where('id', $id)->first();
        return view('admin.account.changeRole', compact('account'));
    }

    // admin role change function
    public function change($id, Request $request){
        $data = $this->requestUserData($request);
        User::where('id', $id)->update($data);
        return redirect()->route('admin#list');
    }

    private function requestUserData($request){
        return [
            'role' => $request->role,
        ];
    }

    // delete admin account
    public function delete($id){
        User::where('id', $id)->delete();
        return redirect()->route('admin#list')->with(['deleteSuccess'=>'Admin Account Deleted']);
    }

    // account validation check
    private function accountValidationCheck($request){
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required' ,
            'image' => 'mimes:png,jpg,jpeg|file',
            'gender' => 'required',
            'address' => 'required',
        ])->validate();
    }

    // get/request user data
    private function getUserData($request){
        return [
            'name' => $request->name ,
            'email' => $request->email ,
            'phone' => $request->phone ,
            'gender' => $request->gender ,
            'address' => $request->address ,
            'updated_at' => Carbon::now()
        ];
    }

    //change password
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    public function changePassword(Request $request){

        // change password
        $this->PasswordValidationCheck($request);
        $user = User::select('password')->where('id', Auth::user()->id)->first();
        $dbHashValue = $user->password; // hash value

        if(Hash::check($request->oldPassword, $dbHashValue)) {
            $data = ['password' => Hash::make($request->newPassword)];
            User::where('id', Auth::user()->id)->update($data);
            // Auth::logout();
            // return redirect()->route('auth#loginPage');
            return back()->with(['changeSuccess'=>'Password Changed Successfully']);
        }
        return back()->with(['notMatch'=>'The Old Password does not match']);
    }

    //password validation check
    private function PasswordValidationCheck($request){
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6|max:10',
            'newPassword' => 'required|min:6|max:10',
            'confirmPassword' => 'required|min:6|max:10|same:newPassword',
        ])->validate();
    }
}
