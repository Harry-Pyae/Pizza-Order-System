<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Usercontroller extends Controller
{
    // user home page
    public function home(){
        $pizza = Product::orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizza', 'category', 'cart', 'history'));
    }

    // direct details page
    public function details(){
        return view('user.profile.details');
    }

    // edit details page
    public function edit(){
        return view('user.profile.edit');
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
        return redirect()-> route('user#AccountDetails')->with(['UpdateSuccess' => 'Account Details Updated']);
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

    // user change password page
    public function changePasswordPage(){
        return view('user.password.changePassword');
    }

    // change password
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

    // direct contact page
    public function contact(){
        return view('user.contact.contact');
    }

    // contact to send message to admins
    public function contactSend(Request $request){
        $this->contactValidationCheck($request);
        $data = $this->getContactData($request);
        Contact::create($data);
        return redirect()->route('user#home')->with(['MessageSent' => 'Your message has been sent to admins']);
    }

    // contact validation check
    private function contactValidationCheck($request){
        Validator::make($request->all(), [ 'message' => 'required' ])->validate();
    }

    // get/request contact data
    private function getContactData($request){
        return [
            'name' => Auth::user()->name ,
            'email' => Auth::user()->email ,
            'message' => $request->message ,
            'updated_at' => Carbon::now()
        ];
    }

    // filter pizza
    public function filter($categoryId){
        $pizza = Product::where('category_id', $categoryId)->orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizza', 'category', 'cart', 'history'));
    }

    // pizza details
    public function pizzaDetails($pizzaId){
        $pizza = Product::where('id', $pizzaId)->first();
        $pizzaList = Product::get();
        return view('user.main.details', compact('pizza', 'pizzaList'));
    }

    // cart list
    public function cartList(){
        $cartList = Cart::select('carts.*', 'products.name as pizza_name', 'products.price as pizza_price', 'products.image as pizza_image')
                    ->leftJoin('products', 'products.id', 'carts.product_id')
                    ->where('carts.user_id', Auth::user()->id)
                    ->get();

        $totalPrice = 0;
        foreach($cartList as $c){
            $totalPrice += $c->pizza_price * $c->qty;
        }
        return view('user.main.cart', compact('cartList', 'totalPrice'));
    }

    // history
    public function history(){
        $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate('5');
        return view('user.main.history', compact('order'));
    }
}
