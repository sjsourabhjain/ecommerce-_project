<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Helper;
use Auth;
use Hash;
use DB;


class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        try{
            if(Auth::guard('admin')->check()){
                return redirect()->route('admin.dashboard');
            }
            return view('admin.login.index');
        }catch(\Exception $e){
            return redirect()->route('admin.login')->with('error',ERROR_MSG);
        }
    }
    public function login(Request $request){
        //dd("login");
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        try{
            if(Auth::guard('admin')->attempt(["email"=>$request->email,'password'=>$request->password,"role_id"=>["1",'2'],"status"=>ACTIVE])){
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('admin.home')->with('error','Invalid Credentials');
            }
        }catch(\Exception $e){
            echo $e->getMessage(); die;
            return redirect()->route('admin.home')->with('error',ERROR_MSG);
        }
    }
    public function forgot_password(){
        try{
            return view('admin.login.forgot_password');
        }catch(Exception $e){
            return redirect()->route('admin.home')->with('error',ERROR_MSG);
        }
    }
    public function send_verification_email(request $request){
        //dd("send");
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        try{
            $user_details = User::where(["email"=>$request->email])->first();

            if($user_details->role_id!=1){
                return redirect()->back()->with('error', 'The selected email is invalid.');
            }
            $token = Helper::str_random(64);
            
            /*$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $length = 64;
            $token = substr(str_shuffle(str_repeat($pool, 5)), 0, $length);*/

            DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
            );

            $data = ['email' => $request->email,'url'=>route('admin.reset_password',$token)];

            Mail::send('emails.email_verification', $data, function ($message) use ($data){
                $message->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
                $message->to($data["email"]);
                $message->subject('Dareecha: Reset Password Request');
            });

            return redirect()->route('admin.home')->with('success', 'Password reset mail sent.');
        }catch(\Exception $e){
            return redirect()->route('admin.home')->with('error',ERROR_MSG);
        }
    }
    public function reset_password($token){
        try{
            $data["token"] = $token;
            return view('admin.login.reset_password',$data);
        }catch(\Exception $e){
            return redirect()->route('admin.home')->with('error',ERROR_MSG);
        }
    }
    public function reset(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        try{
            $updatePassword = DB::table('password_resets')
                ->where(['email' => $request->email, 'token' => $request->token])
                ->first();

            if(!$updatePassword)
                return back()->withInput()->with('error', 'Invalid token!');

            $user = User::where(['email'=>$request->email,'status'=>ACTIVE,'role_id'=>1])->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where(['email'=> $request->email])->delete();

            return redirect()->route('admin.home')->with('success','Your password has been updated!');
        }catch(\Exception $e){
            return redirect()->route('admin.home')->with('error',ERROR_MSG);
        }
    }
    public function logout(){
        try{
            Auth::guard('admin')->logout();
            Session::forget('applocale');
            return redirect()->route('admin.home');            
        }catch(\Exception $e){
            return redirect()->route('admin.home')->with('error',ERROR_MSG);
        }
    }
}
?>