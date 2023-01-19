<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Country;
use Helper;
use Hash;
use DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard(){
        try{
            return view('admin.dashboard');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }
    public function profile($id){
        try{
            $data["user_details"] = User::where(["id"=>$id])->first();
            return view('admin.user.profile',$data);
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }
    public function index(Request $request){
        try{
            $data["users"] = User::where('role_id',4)->latest()->get();
            return view('admin.user.list_user',$data);
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('admin.user.add_user');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = $request->validate([
            'full_name'     => 'required|string',
            'email'  => 'nullable|email|unique:users',
            'mob_no'     => 'required|numeric|unique:users|digits_between:8,12',
            'password'=> 'required|string|min:3|max:8',
        ],[],[
            'full_name'=>'Name',
            'email'=>'Email',
            'mob_no'=>'Mobile No.',
            'password'=>'Password'
        ]);

        try{
            $password = $request->password;
            $request->request->add(['password'=>Hash::make($password)]);
            $request->request->add(['role_id'=>4,'status'=>ACTIVE]);

            if(User::create($request->all())){
                return redirect()->route('admin.list_user')->with('success','User Added Successfully.');
            }else{
                return redirect()->route('admin.list_user')->with('error','User not added');
            }
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data["user_details"] = User::where(["id"=>$id])->with(["countryCode"])->first();
            return view('admin.user.show_user',$data);
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $data["user_details"] = User::where(["id"=>$id])->firstOrFail();
            return view('admin.user.edit_user',$data);
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = $request->validate([
            'full_name'     => 'required|string',
            'email'  => 'nullable|email|unique:users,email,'.$request->update_id,
            'mob_no'     => 'required|numeric|digits_between:8,12|unique:users,mob_no,'.$request->update_id,
        ],[],[
            'full_name'=>'Name',
            'email'=>'Email',
            'mob_no'=>'Mobile No.',
        ]);
        try{
            $user_details = User::where(["id"=>$request->update_id])->update($validator);
            return redirect()->route('admin.list_user')->with('success','User Updated Successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try{
            User::where(["id"=>$id])->delete();
            return redirect()->route('admin.list_user')->with('success','User Deleted Successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }
    public function update_user_status($id){
        try{
            $user_details = User::where(["id"=>$id])->first();

            $status = ($user_details->status==INACTIVE) ? ACTIVE : INACTIVE;

            $user_details->status = $status;
            $user_details->save();
            return redirect()->route('admin.list_user')->with('success','User Status Updated Successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }
}
?>