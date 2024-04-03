<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\BiodataKaryawan;
use App\Models\LogActivity;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Cache;
use DataTables;
use \Carbon\Carbon;

use Notification;
use Kutia\Larafirebase\Facades\Larafirebase;
use App\Notifications\SendPushNotification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = User::orderBy('id','DESC')->get();
        // return view('users.index',compact('data'))
        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        if ($request->ajax()) {
            $data = User::get();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                                // $btn = '<div class="btn-group">';
                                // $btn.= '<button onclick="buat_team('.$row->id.')" class="btn btn-success btn-icon">
                                //             <i class="fa fa-plus"></i> Input Team
                                //         </button>';
                                // $btn.= '</div>';
                                // return $btn;
                                $btn = '<div class="button-items">';
                                $btn.= '<a href='.route('users.show', $row->id).' class="btn btn-outline-info">'.'<i class="far fa-eye"></i> Detail'.'</a>';
                                $btn.= '<a href='.route('users.edit', $row->id).' class="btn btn-outline-warning">'.'<i class="far fa-edit"></i> Edit'.'</a>';
                                $btn.= '<form action='.route('users.destroy', $row->id).' method="DELETE">';
                                $btn.= '<button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i> Delete</button>';
                                $btn.= '</form>';
                                $btn .= '</div>';

                                return $btn;
                            })
                            ->addColumn('last_seen', function($row){
                                if (Cache::has('user-is-online-'.$row->id)) {
                                    return '<span class="badge badge-outline-success">Online</span>'.'<span class="badge badge-outline-dark">Last Seen: '.Carbon::parse($row->last_seen)->diffForHumans().'</span>';
                                    // return $row->name.' is Online. Last Seen: '. Carbon::parse($row->last_seen)->diffForHumans();
                                }else{
                                    if ($row->last_seen != null) {
                                        return '<span class="badge badge-outline-danger">Offline</span>'.'<span class="badge badge-outline-dark">Last Seen: '.Carbon::parse($row->last_seen)->diffForHumans().'</span>';
                                        // return $row->name.' is Offline. Last Seen: '. Carbon::parse($row->last_seen)->diffForHumans();
                                    }else{
                                        return '<span class="badge badge-outline-danger">Offline</span>';
                                        // return $row->name.' is Offline. Last Seen: No Data';
                                    }
                                }
                            })
                            ->rawColumns(['action','last_seen'])
                            ->make(true);
        }
        return view('users.index');

        // $data = User::orderBy('id','DESC')->get(5);
        // return view('users.index',compact('data'))
        //     ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $biodata_karyawans = BiodataKaryawan::all();
        return view('users.create',compact('roles','biodata_karyawans'));
    }

    public function search_nik($nama)
    {
        $biodata_karyawans = BiodataKaryawan::where('nama',$nama)->first();
        return response()->json([
            'success' => true,
            'nik' => $biodata_karyawans->nik
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['username'] = $request->username;
        $input['id_generate'] = Str::uuid()->toString();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function activity_log(Request $request)
    {
        // $data = User::orderBy('id','DESC')->paginate(5);
        // return view('users.index',compact('data'))
        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        if ($request->ajax()) {
            $data = LogActivity::all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('method', function($row){
                                if ($row->method == 'POST') {
                                    return '<span class="badge bg-success">POST<span>';
                                }
                            })
                            ->addColumn('user_id', function($row){
                                return $row->user->name;
                            })
                            ->addColumn('created_at', function($row){
                                return Carbon::create($row->created_at)->format('d-m-Y H:i:s');
                            })
                            ->rawColumns(['method'])
                            ->make(true);
        }
        return view('users.activity_log');
    }

    public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    public function notification(Request $request){
        // $request->validate([
        //     'title'=>'required',
        //     'message'=>'required'
        // ]);
    
        // try{
        //     $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
    
        //     // Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));
    
        //     /* or */
    
        //     //auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));
    
        //     /* or */
    
        //     \Larafirebase::withTitle($request->title)
        //         ->withBody($request->message)
        //         ->sendMessage($fcmTokens);
    
        //     return redirect()->back()->with('success','Notification Sent Successfully!!');
    
        // }catch(\Exception $e){
        //     report($e);
        //     return redirect()->back()->with('error','Something goes wrong while sending notification.');
        // }

        try{
            $request->user()->update(['fcm_token'=>request()->token]);
            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
    
            // Notification::send(null,new SendPushNotification('Success','OKE',$fcmTokens));
    
            /* or */
    
            auth()->user()->notify(new SendPushNotification('Success','OKE',$fcmTokens));
    
            /* or */
    
            Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);
    
            return redirect()->back()->with('success','Notification Sent Successfully!!');
    
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error','Something goes wrong while sending notification.');
        }
    }
}
