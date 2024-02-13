<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiodataKaryawan;
use App\Models\Departemen;
use App\Models\DepartemenUser;
use \Carbon\Carbon;
use DB;
use Validator;
use DataTables;
class DepartemenController extends Controller
{
    protected $departemen;
    protected $departemen_user;
    protected $biodata_karyawan;

    function __construct(
        Departemen $departemen, 
        DepartemenUser $departemen_user,
        BiodataKaryawan $biodata_karyawan
    )
    {
        $this->departemen = $departemen;
        $this->departemen_user = $departemen_user;
        $this->biodata_karyawan = $biodata_karyawan;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->departemen->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('team', function($row){
                                // if (!empty($row->departemen_user)) {
                                //     $ul = '<ol>';
                                //     foreach ($row->departemen_user as $key => $departemen_user) {
                                //         $ul .= '<li>'.$departemen_user->team.'</li>';
                                //     }
                                //     $ul .= '</ol>';
                                // }else{
                                //     $ul = '-';
                                // }
                                // return $ul;
                                $departemen_users = $this->departemen_user->where('departemen_id',$row->id)->get();
                                $ol = '<ul>';
                                foreach ($departemen_users as $key => $value) {
                                    if ($value->staff == 'y') {
                                        $ol .= '<li>'.$value->nik.' - '.$value->team.' - '.'<span class="text-primary">Staff</span>'.'</li>';
                                    }else{
                                        $ol .= '<li>'.$value->nik.' - '.$value->team.' - '.'<span class="text-success">Non Staff</span>'.'</li>';
                                    }
                                    // $ol .= '<li>'.$value->team.'</li>';
                                }
                                $ol .= '<ul>';
                                return $ol;
                                // return Carbon::parse($row->created_at)->isoFormat('LLLL');
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<a href='.route('departemen.detail_team',$row->id).' class="btn btn-primary btn-icon">
                                            <i class="fas fa-cube"></i> Input Team
                                        </a>';
                                $btn.= '<button type="button" onclick="edit(`'.$row->id.'`)" class="btn btn-warning btn-icon">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>';
                                $btn.= '<button type="button" onclick="hapus(`'.$row->id.'`)" class="btn btn-danger btn-icon">
                                            <i class="fa fa-trash"></i>
                                        </button>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action','team'])
                            ->make(true);
        }
        return view('departemen.index');
    }
    
    public function simpan(Request $request)
    {
        $rules = [
            'departemen' => 'required',
        ];

        $messages = [
            'departemen.required'  => 'Nama Departemen wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $norut = $this->departemen->max('id');
            if(empty($norut)){
                $id = 1;
            }else{
                $id = $norut+1;
            }
            $input['id'] = $id;
            $input['departemen'] = $request->departemen;
            $departemen = $this->departemen->create($input);
            if($departemen){
                $message_title="Berhasil !";
                $message_content="Data Berhasil Dibuat";
                $message_type="success";
                $message_succes = true;
            }
            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
            );
            return response()->json($array_message);
        }
        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

    public function detail($id)
    {
        $departemen = $this->departemen->find($id);
        if (empty($departemen)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data tidak ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $departemen
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'edit_departemen' => 'required',
        ];

        $messages = [
            'edit_departemen.required'  => 'Nama Permission wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $departemen = $this->departemen->find($request->edit_id);
            $departemen->departemen = $request->edit_departemen;
            $departemen->update();
            if($departemen){
                $message_title="Berhasil !";
                $message_content="Data Berhasil Diupdate";
                $message_type="success";
                $message_succes = true;
            }
            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
            );
            return response()->json($array_message);
        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

    public function delete($id)
    {
        $departemen = $this->departemen->find($id);
        if (empty($departemen)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data tidak ditemukan'
            ]);
        }
        $departemen->delete();
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Data berhasil dihapus'
        ]);
    }

    // public function input_user($ids)
    // {
    //     $rules = [
    //         'departemen_id' => 'required',
    //         'user_id' => 'required',
    //     ];

    //     $messages = [
    //         'departemen_id.required'  => 'Departemen wajib diisi.',
    //         'user_id.required'  => 'User wajib diisi.',
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $messages);

    //     if ($validator->passes()) {
    //         $norut = $this->departemen_user->max('id');
    //         if(empty($norut)){
    //             $id = 1;
    //         }else{
    //             $id = $norut+1;
    //         }
    //         $input['id'] = $id;
    //         $input['departemen_id'] = $ids;
    //         $input['user_id'] = $request->user_id;
    //         $departemen_user = $this->departemen_user->create($input);
    //         if($departemen_user){
    //             $message_title="Berhasil !";
    //             $message_content="Data User Berhasil Dibuat";
    //             $message_type="success";
    //             $message_succes = true;
    //         }
    //         $array_message = array(
    //             'success' => $message_succes,
    //             'message_title' => $message_title,
    //             'message_content' => $message_content,
    //             'message_type' => $message_type,
    //         );
    //         return response()->json($array_message);
    //     }
    //     return response()->json(
    //         [
    //             'success' => false,
    //             'error' => $validator->errors()->all()
    //         ]
    //     );
    // }

    public function detail_team(Request $request, $id)
    {
        $data['departemen'] = $this->departemen->find($id);
        if (empty($data['departemen'])) {
            return redirect()->back();
        }

        if ($request->ajax()) {
            $data = $this->departemen_user->where('departemen_id',$id)->where('status','Y')->get();
            return DataTables::of($data)
                            ->addIndexColumn()
                            // ->addColumn('user_id', function($row){
                            //     if (!empty($row->departemen_user)) {
                            //         $ul = '<ol>';
                            //         foreach ($row->departemen_user as $key => $departemen_user) {
                            //             $ul .= '<li>'.$departemen_user->user_id.'</li>';
                            //         }
                            //         $ul .= '</ol>';
                            //     }else{
                            //         $ul = '-';
                            //     }
                            //     return $ul;
                            //     // return Carbon::parse($row->created_at)->isoFormat('LLLL');
                            // })
                            ->addColumn('departemen_id', function($row){
                                return $row->departemen->departemen;
                            })
                            ->addColumn('staff', function($row){
                                if ($row->staff == 'y') {
                                    return '<span>Staff</span>';
                                }else{
                                    return '<span>Non Staff</span>';
                                }
                                // return $row->departemen->departemen;
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<button class="btn btn-primary btn-icon" onClick="detail_team(`'.$row->departemen_id.'`,`'.$row->id.'`)">
                                            <i class="far fa-id-badge"></i> Pindah Departemen
                                        </button>';
                                $btn.= '<button class="btn btn-warning btn-icon" onClick="edit_team(`'.$row->departemen_id.'`,`'.$row->id.'`)">
                                            <i class="far fa-edit"></i> Edit Team
                                        </button>';
                                // $btn.= '<a href='.route('departemen.detail_team',$row->id).' class="btn btn-primary btn-icon">
                                //             <i class="fas fa-cube"></i> Input Team
                                //         </a>';
                                // $btn.= '<button type="button" onclick="edit(`'.$row->id.'`)" class="btn btn-warning btn-icon">
                                //             <i class="fa fa-edit"></i> Edit
                                //         </button>';
                                // $btn.= '<button type="button" onclick="hapus(`'.$row->id.'`)" class="btn btn-danger btn-icon">
                                //             <i class="fa fa-trash"></i>
                                //         </button>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action','staff'])
                            ->make(true);
        }
        $data['biodata_karyawans'] = BiodataKaryawan::all();
        $data['departemens'] = $this->departemen->all();
        return view('departemen.team.index',$data);
    }

    public function detail_team_group($id,$team_id)
    {
        $data['departemen'] = $this->departemen->find($id);
        if (empty($data['departemen'])) {
            return response()->json([
                'success' => false,
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }
        $data['departemen_user'] = $this->departemen_user->find($team_id);
        return response()->json([
            'success' => true,
            'data' => $data['departemen'],
            'departemen_user' => $data['departemen_user']
        ]);
    }

    public function detail_pindah_team_update(Request $request, $id){
        $rules = [
            'detail_pindah_departemen' => 'required',
        ];

        $messages = [
            'detail_pindah_departemen.required'  => 'Departemen wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->passes()) {
            $departemen_user = $this->departemen_user->where('departemen_id',$id)
                                            ->where('id',$request->detail_team_id)
                                            ->first();
            if (empty($departemen_user)) {
                return [
                    'success' => false,
                    'message_content' => 'Data Tidak Ditemukan',
                ];
            }
            $departemen_user->update([
                'departemen_id' => $request->detail_pindah_departemen,
                'status' => $request->detail_status
            ]);
            return [
                'success' => true,
                'message_title' => 'Berhasil!',
                'message_content' => 'Nama '.$departemen_user->team. ' berhasil pindah departemen'
            ];
        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
        
    }

    public function detail_team_update(Request $request, $id){
        $rules = [
            'edit_jenis_kelamin' => 'required',
            'edit_status' => 'required',
        ];

        $messages = [
            'edit_jenis_kelamin.required'  => 'Jenis Kelamin wajib diisi.',
            'edit_status.required'  => 'Status Karyawan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->passes()) {
            $departemen_user = $this->departemen_user->where('departemen_id',$id)
                                            ->where('id',$request->edit_team_id)
                                            ->first();
            if (empty($departemen_user)) {
                return [
                    'success' => false,
                    'message_content' => 'Data Tidak Ditemukan',
                ];
            }
            $departemen_user->update([
                'jenis_kelamin' => $request->edit_jenis_kelamin,
                'status' => $request->edit_status,
            ]);
            return [
                'success' => true,
                'message_title' => 'Berhasil!',
                'message_content' => 'Nama '.$departemen_user->team. ' berhasil pindah departemen'
            ];
        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
        
    }

    public function team_simpan(Request $request, $ids)
    {
        $rules = [
            'nik' => 'unique:departemen_user',
            'team' => 'required',
            'staff' => 'required',
        ];

        $messages = [
            'nik.unique'  => 'NIK Karyawan sudah ada.',
            'team.required'  => 'Input Team wajib diisi.',
            'staff.required'  => 'Status Jabatan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $norut = $this->departemen_user->max('id');
            if(empty($norut)){
                $id = 1;
            }else{
                $id = $norut+1;
            }
            foreach ($request->team as $key => $value) {
                $input['id'] = $id+$key;
                $input['departemen_id'] = $ids;
                $input['nik'] = $request->nik;
                $input['team'] = $value;
                $input['staff'] = $request->staff;
                $input['jenis_kelamin'] = $request->jenis_kelamin;
                $input['status'] = 'Y';
                $departemen_team = $this->departemen_user->create($input);
                // $input = [
                //     'id' => $id+$key,
                //     'departemen_id' => $ids,
                //     'team' => $value
                // ];
                if($departemen_team){
                    $message_title="Berhasil !";
                    $message_content="Team Berhasil Dibuat";
                    $message_type="success";
                    $message_succes = true;
                }
            }
            // dd($input);
            // $departemen_team = $this->departemen_user->create($input);
            // if($departemen_team){
            //     $message_title="Berhasil !";
            //     $message_content="Team ".$request->team." Berhasil Dibuat";
            //     $message_type="success";
            //     $message_succes = true;
            // }
            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
            );
            return response()->json($array_message);
        }
        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

    public function search_nik(Request $request)
    {
        // dd($request->all());
        $biodata_karyawan = $this->biodata_karyawan->where('nik',$request->nik)->first();
        if (empty($biodata_karyawan)) {
            return response()->json([
                'success' => false,
                'message' => 'NIK Tidak Ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $biodata_karyawan
        ]);
    }
}
