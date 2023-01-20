<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Country;
use DataTables;
use Hash;
use DB;

class SubAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        try{
            $data["sub_admins"] = User::where(["role_id"=>2])->latest()->get();
            if ($request->ajax()) {
                return Datatables::of($data["sub_admins"])
                        ->addIndexColumn()
                        ->addColumn('status', function($row){
                            if($row["status"]==1){
                                return '<a href="'.route("admin.update_sub_admin_status",$row['id']).'"><span class="badge badge-success">Active</span></a>';
                            }else{
                                return '<a href="'.route("admin.update_sub_admin_status",$row['id']).'"><span class="badge badge-warning">Inactive</span></a>';
                            }
                        })
                        ->addColumn('action', function($row){
                            $btn = '<a href="'.route('admin.show_sub_admin',$row['id']).'"><button type="button" class="icon-btn preview"><i class="fal fa-eye"></i></button></a>';
                            $btn .= '<a href="'.route('admin.edit_sub_admin',$row['id']) .'"><button type="button" class="icon-btn edit"><i class="fal fa-edit"></i></button></a>';

                            return $btn;
                        })
                        ->rawColumns(['status','action'])
                        ->make(true);
            }
            return view('admin.sub_admin.list_sub_admin');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error','Something went wrong.');
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
            $data["permissions"] = Permission::get();
            return view('admin.sub_admin.add_sub_admin',$data);
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error','Something went wrong.');
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
            'mob_no'     => 'required|numeric|digits_between:8,12',
        ],[],[
            'full_name'=>'Full Name',
            'email'=>'Email',
            'country_code'=>'Country Code',
            'mob_no'=>'Mobile No.'
        ]);

        try{
            $user = new User();
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->role_id = "2";
            $user->status = "1";
            //$user->is_email_verified = "1";
            $user->email_verified_at = date("Y-m-d H:i:s");
            $user->mob_no = $request->mob_no;
            $user->password = Hash::make($request->password);
            $user_details = $user->save();
            $user->assignRole('sub_admin');

            if(!empty($request->permissions)){
                $user->syncPermissions($request->permissions);
            }
            return redirect()->route('admin.list_sub_admin')->with('success','Sub Admin Added Successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error','Something went wrong.');
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
            return view('admin.sub_admin.show_sub_admin',$data);
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error','Something went wrong.');
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
            $data["user_details"] = User::where(["id"=>$id])->first();
            $data["permissions"] = Permission::get();
            $data["user_permissions"] = $data["user_details"]->getAllPermissions()->toArray();
            if(!empty($data["user_permissions"])){
                $data["user_permissions"] = array_column($data["user_permissions"],"name");
            }
            return view('admin.sub_admin.edit_sub_admin',$data);
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error','Something went wrong.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $validator = $request->validate([
            'full_name'     => 'required|string',
            'email'  => 'nullable|email|unique:users,email,'.$request->update_id,
            'mob_no'     => 'required|numeric|digits_between:8,12'
        ],[],[
            'full_name'=>'Full Name',
            'email'=>'Email',
            'mob_no'=>'Mobile No.'
        ]);
        try{
            if($request->password!=""){
                $validator['password'] = Hash::make($request->password);
            }

            $user_details = User::where(["id"=>$request->update_id])->update($validator);

            $user_details = User::findOrFail($request->update_id);

            $user_details->syncPermissions($request->permissions);

            return redirect()->route('admin.list_sub_admin')->with('success','Sub Admin Updated Successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error','Something went wrong.');
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
            return redirect()->route('admin.sub_admin')->with('success','Sub Admin Deleted Successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error','Something went wrong.');
        }
    }
    public function update_sub_admin_status($id){
        try{
            $user_details = User::where(["id"=>$id])->first();

            $status = ($user_details->status==0) ? "1" : "0";

            $user_details->status = $status;
            $user_details->save();
            return redirect()->route('admin.list_sub_admin')->with('success','Sub Admin Status Updated Successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error','Something went wrong.');
        }
    }
}
?>