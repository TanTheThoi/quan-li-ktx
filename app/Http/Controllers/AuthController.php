<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Mail\MyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use App\users;
use App\User;
use Hash;
use App\sinhvien;
use App\canboquanly;

class AuthController extends Controller
{
    public function getLogin() {
        if(Auth::check()){
            return redirect()->back();
        } else {
    	   return view('auth.login');
        }
    }
    public function postLogin(Request $request) {
    	$rules = [
    		'email' =>'required|email',
    		'password' => 'required|min:6'
    	];
    	$messages = [
    		'password.min' => 'Mật khẩu phải chứa ít nhất 6 ký tự',
    	];
    	$validator = Validator::make($request->all(), $rules, $messages);

    	if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator)->withInput();
    	} else {
    		$email = $request->input('email');
    		$password = $request->input('password');

    		if( Auth::attempt(['email' => $email, 'password' =>$password])) {
    			return redirect()->intended('/');
    		} else {
    		}
    	}
	}
    public function sendMail(Request $request){
        $user  = User::where('email',$request->email)->first();
        if($user){
            $pass = rand();
            $user->update([
                'password' => bcrypt($pass)
            ]);
            Mail::to($request->email)->send(new MyMail($pass));
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đã đổi mật khẩu thành công, Kiểm tra email để lấy mật khẩu']);
        }
        return redirect()->back()->with(['flag'=>'danger','message'=>'Email không tồn tại']);
    }
	public function logout(){
		Auth::logout();
		return redirect('login');
	}
    public function getRegister() {
        return view('auth.register');
    }
    public function postRegister(UserRegisterRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->gender = $request->gender;
        $user->image = "user.jpg";
        $user->ltk = "sinhvien";
        $user->save();
        return redirect()->route('login')->with(['flag'=>'danger','message'=>'Tạo thành khoản thành công, mời bạn đăng nhập']);
    }
    public function getForgot() {
        return view('auth.forgot');
    }

    public function admin_create_account(Request $request){
         $rules = [
            'email' =>'required|email',
            'password' => 'required|min:6|confirmed'
        ];
        $messages = [
            'password.min' => 'Mật khẩu phải chứa ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không đúng'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $email = $request->input('email');
            $count = users::where('email',$email)->count();
            if($count>0){
                return redirect()->back()->with(['flag'=>'danger','message'=>'Email đã được sử dụng']);   
            }
            else{
                $mscb = canboquanly::max('mscb') + 1;
                $user = new User();
                canboquanly::insert(['mscb'=>$mscb,'email'=>$email]);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->image = "user.jpg";
                $user->ltk = "quanly";
                $user->save();
                $id = users::where('email',$email)->value('id');
                return redirect()->route('admin_details_cb',$id)->with(['flag2'=>'danger','message'=>'Tạo thành khoản thành công, mời cập nhật thông tin cán bộ']);

            }
        }
    }
}

?>