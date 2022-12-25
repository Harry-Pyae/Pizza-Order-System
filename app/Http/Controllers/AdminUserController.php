<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // direct user list page
    public function userList(){
        $users = User::where('role', 'user')->paginate(4);
        return view('admin.user.list', compact('users'));
    }

    // change role with ajax
    public function changeRole(Request $request){
        $updateSource = [ 'role' => $request->role ];
        User::where('id', $request->userId)->update($updateSource);
    }

    // delete user account from admin account
    public function deleteUser($id){
        User::where('id', $id)->delete();
        return redirect()->route('admin#userList')->with(['deleteSuccess'=>'User Account Deleted']);
    }

    // direct admin's user contact page
    public function contact(){
        $contact = Contact::when(request('key'), function($query){
            $query->where('name', 'like', '%'.request('key').'%');
        })->paginate(4);
        return view('admin.contact.contact', compact('contact'));
    }

    // direct contact details page
    public function contactInfo($id){
        $contactInfo = Contact::where('id', $id)->first();
        return view('admin.contact.contactInfo', compact('contactInfo'));
    }
}
