<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\RekapPelatihanExcel;
use App\Exports\RekapPelatihanAllDepExcel;
use App\Exports\TotalRekapPelatihanExcel;

use App\Models\Periode;

use App\Models\RekapPelatihanSeminar;
use App\Models\RekapPelatihanSeminarPeserta;
use App\Models\RekapPelatihanSeminarKategori;
use App\Models\Departemen;
use App\Models\BiodataKaryawan;
use App\Models\DepartemenUser;
use \Carbon\Carbon;
use DB;
use File;
use Validator;
use DataTables;
use Excel;

class RekapPelatihanController extends Controller
{
    protected $rekap_pelatihan;
    protected $rekap_pelatihan_peserta;
    protected $rekap_pelatihan_kategori;
    protected $biodata_karyawan;
    protected $departemen;
    protected $departemen_user;
    protected $day;

    function __construct(
        RekapPelatihanSeminar $rekap_pelatihan, 
        RekapPelatihanSeminarPeserta $rekap_pelatihan_peserta, 
        RekapPelatihanSeminarKategori $rekap_pelatihan_kategori,
        BiodataKaryawan $biodata_karyawan,
        Departemen $departemen,
        DepartemenUser $departemen_user,
        Periode $periode
    )
    {
        // $this->middleware('permission:rekap-list')->except(
        //     [
        //         'rekap_pelatihan_rekap',
        //         'rekap_pelatihan_create',
        //         'rekap_pelatihan_simpan',
        //         'rekap_pelatihan_detail'
        //     ]);
        // $this->middleware('permission:rekap-create')->except(
        //     [
        //         'rekap_pelatihan_rekap',
        //         'rekap_pelatihan_create'
        //     ]);
        $this->middleware('permission:rekap-kategori|rekap-kategori-create', ['only' => [
            'kategori_index','kategori_simpan'
            ]]);
        $this->middleware('permission:rekap-list', ['only' => [
            'rekap_pelatihan_rekap'
            ]]);
        $this->middleware('permission:rekap-create', ['only' => [
            'rekap_pelatihan_create'
            ]]);
        $this->middleware('permission:rekap-detail', ['only' => [
            'rekap_pelatihan_detail',
            ]]);
        // $this->middleware('permission:rekap-edit', ['only' => ['rekap_pelatihan_create']]);
        // $this->middleware('permission:rekap-delete', ['only' => ['rekap_pelatihan_create']]);

        // $this->middleware('permission:rekap-create', ['only' => ['rekap_pelatihan.create','rekap_pelatihan.simpan']]);
        $this->rekap_pelatihan = $rekap_pelatihan;
        $this->rekap_pelatihan_peserta = $rekap_pelatihan_peserta;
        $this->rekap_pelatihan_kategori = $rekap_pelatihan_kategori;
        $this->biodata_karyawan = $biodata_karyawan;
        $this->departemen = $departemen;
        $this->departemen_user = $departemen_user;
        $this->periode = $periode;
        $this->day = 0;
    }

    public function kategori_index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->rekap_pelatihan_kategori->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<button type="button" onclick="edit(`'.$row->id.'`)" class="btn btn-warning btn-icon">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>';
                                $btn.= '<button type="button" onclick="hapus(`'.$row->id.'`)" class="btn btn-danger btn-icon">
                                            <i class="fa fa-trash"></i>
                                        </button>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }
        $data['periode'] = $this->periode->select('periode','status')->where('status','y')->first();
        if (empty($data['periode'])) {
            return redirect()->back()->with('error','Periode Tahunan Belum Dibuat. Silahkah hubungi team IT');
        }
        return view('rekap_pelatihan.kategori.index');
    }

    public function kategori_simpan(Request $request)
    {
        $rules = [
            'kategori' => 'required',
        ];

        $messages = [
            'kategori.required'  => 'Kategori wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $input['kategori'] = $request->kategori;
            $rekap_pelatihan_kategori = $this->rekap_pelatihan_kategori->create($input);
            if($rekap_pelatihan_kategori){
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

    public function kategori_detail($id)
    {
        $rekap_pelatihan_kategori = $this->rekap_pelatihan_kategori->find($id);
        if (empty($rekap_pelatihan_kategori)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data tidak ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $rekap_pelatihan_kategori
        ]);
    }

    public function kategori_update(Request $request)
    {
        $rules = [
            'edit_kategori' => 'required',
        ];

        $messages = [
            'edit_kategori.required'  => 'Kategori wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $input['kategori'] = $request->edit_kategori;
            $rekap_pelatihan_kategori = $this->rekap_pelatihan_kategori->find($request->edit_id)->update($input);
            if($rekap_pelatihan_kategori){
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

    public function kategori_delete($id)
    {
        $rekap_pelatihan_kategori = $this->rekap_pelatihan_kategori->find($id);
        if (empty($rekap_pelatihan_kategori)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data tidak ditemukan'
            ]);
        }
        $rekap_pelatihan_kategori->delete();
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Data berhasil dihapus'
        ]);
    }

    public function rekap_pelatihan_periode()
    {
        return view('rekap_pelatihan.index');
    }

    public function rekap_pelatihan_rekap(Request $request)
    {
        if ($request->ajax()) {
            $periode = $this->periode->select('periode','status')->where('status','y')->first();
            if ($periode->periode == Carbon::now()->format('Y')) {
                $data = $this->rekap_pelatihan->where('periode',Carbon::now()->format('Y'))->get();
            }else{
                $data = $this->rekap_pelatihan->where('periode',$periode->periode)->get();
            }
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('tema', function($row){
                                // if ($row->status != 'Done') {
                                //     return $row->tema.'<a href="javascript:void()" onclick="update_canvas(`'.$row->id.'`)" class="btn btn-link"><i class="dripicons-warning"></i> Perbarui Total Jam Pelatihan</a>';
                                // }else{
                                //     return $row->tema;
                                // }
                                $datelive = Carbon::now()->addDay($this->day)->format('Y-m-d H:i');
                                $explode_tanggal = explode(',',$row->tanggal);
                                // $explode_tanggal_2 = explode('#',$row->tanggal);
                                if (strtotime($datelive) < strtotime($explode_tanggal[0])) {
                                    return substr($row->tema,0,50);
                                }
                                elseif (strtotime($datelive) >= strtotime($explode_tanggal[0]) && strtotime($datelive) <= strtotime($explode_tanggal[1])) {
                                    // return '<span class="badge bg-warning"><i class="mdi mdi-file-table-outline"></i> '.'ON PROCESS'.'</span>';
                                    return substr($row->tema,0,50);
                                }else{
                                    if ($row->status != 'Done') {
                                        return substr($row->tema,0,50).'<a href="javascript:void()" onclick="update_canvas(`'.$row->id.'`)" class="btn btn-link"><i class="dripicons-warning"></i> Perbarui Total Jam Pelatihan</a>';
                                    }else{
                                        return substr($row->tema,0,50);
                                    }
                                }
                            })
                            ->addColumn('tanggal', function($row){
                                $explode_tanggal = explode(',',$row->tanggal);
                                if ($row->check_date == 'yes') {
                                    return Carbon::create($explode_tanggal[0])->isoFormat('DD MMMM').' , '.Carbon::create($explode_tanggal[1])->isoFormat('DD MMMM YYYY').'<br><span class="badge bg-info">'.Carbon::create($explode_tanggal[0])->format('H:i').' - '.Carbon::create($explode_tanggal[1])->format('H:i').'</span>';
                                }else{
                                    if (Carbon::create($explode_tanggal[0])->format('Y-m-d') == Carbon::create($explode_tanggal[1])->format('Y-m-d')) {
                                        return Carbon::create($explode_tanggal[1])->isoFormat('DD MMMM YYYY').'<br><span class="badge bg-info">'.Carbon::create($explode_tanggal[0])->format('H:i').' - '.Carbon::create($explode_tanggal[1])->format('H:i').'</span>';
                                    }else{
                                        return Carbon::create($explode_tanggal[0])->isoFormat('DD MMMM').' - '.Carbon::create($explode_tanggal[1])->isoFormat('DD MMMM YYYY').'<br><span class="badge bg-info">'.Carbon::create($explode_tanggal[0])->format('H:i').' - '.Carbon::create($explode_tanggal[1])->format('H:i').'</span>';
                                    }
                                }
                            })
                            ->addColumn('created_at', function($row){
                                return Carbon::create($row->created_at)->format('d-m-Y H:i:s');
                            })
                            ->addColumn('status', function($row){
                                $datelive = Carbon::now()->addDay($this->day)->format('Y-m-d H:i');
                                // $datelive = Carbon::now()->subDays($this->day)->format('Y-m-d');
                                $explode_tanggal = explode(',',$row->tanggal);
                                // return $datelive;

                                // return strtotime($datelive).' '.strtotime($explode_tanggal[0]);

                                // if (strtotime($datelive) < strtotime($explode_tanggal[0])) {
                                if (strtotime($datelive) < strtotime($explode_tanggal[0])) {
                                    return '<span class="badge bg-primary"><i class="mdi mdi-file-table-outline"></i> '.'PLAN'.'</span>';
                                }
                                elseif (strtotime($datelive) >= strtotime($explode_tanggal[0]) && strtotime($datelive) <= strtotime($explode_tanggal[1])) {
                                    return '<span class="badge bg-warning"><i class="mdi mdi-file-table-outline"></i> '.'ON PROCESS'.'</span>';
                                }else{
                                    return '<span class="badge bg-success"><i class="mdi mdi-check-box-outline"></i> '.'SELESAI'.'</span>';
                                }
                                // elseif ($datelive > $explode_tanggal[0] && $datelive < $explode_tanggal[1]) {
                                //     return '<span class="badge bg-warning"><i class="mdi mdi-file-table-outline"></i> '.'ON PROCESS '.$datelive.'</span>';
                                // }
                                // else{
                                //     return '<span class="badge bg-success"><i class="mdi mdi-check-box-outline"></i> '.'SELESAI'.'</span>';
                                // }
                                
                                // if ($row->status == 'Plan') {
                                //     return '<span class="badge bg-primary"><i class="mdi mdi-file-table-outline"></i> '.strtoupper($row->status).'</span>';
                                // }elseif($row->status == 'Done'){
                                //     return '<span class="badge bg-success"><i class="mdi mdi-check-all"></i> '.strtoupper($row->status).'</span>';
                                // }
                            })
                            ->addColumn('action', function($row){
                                $datelive = Carbon::now()->addDay($this->day)->format('Y-m-d H:i');
                                // $datelive = Carbon::now()->subDays($this->day)->format('Y-m-d');
                                $explode_tanggal = explode(',',$row->tanggal);

                                $btn = '<div class="btn-group">';
                                // $btn.= '<button type="button" onclick="edit(`'.$row->id.'`)" class="btn btn-success btn-icon" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
                                //             <i class="fa fa-eye"></i> Detail
                                //         </button>';
                                if (!empty($row->link)) {
                                    if ($datelive <= $explode_tanggal[0]) {
                                        $btn.= '<a href="'.$row->link.'" class="btn btn-icon" style="background-color: #003C43; color: #fff" target="_blank">
                                                    <i class="fas fa-play"></i> Join
                                                </a>';
                                    }
                                }
                                $btn.= '<button type="button" onclick="show_canvas(`'.$row->id.'`)" class="btn btn-success btn-icon">
                                            <i class="fa fa-eye"></i> Detail
                                        </button>';
                                if (auth()->user()->can('rekap-edit')) {
                                    if (strtotime($datelive) < strtotime($explode_tanggal[0])) {
                                    }
                                    elseif (strtotime($datelive) >= strtotime($explode_tanggal[0]) && strtotime($datelive) <= strtotime($explode_tanggal[1])) {
                                    
                                    }else{
                                        if (empty($row->file_sertifikat) || empty($row->file_absensi)) {
                                            $btn.= '<button type="button" onclick="upload_file(`'.$row->id.'`)" class="btn btn-primary btn-icon">
                                                    <i class="fa fa-upload"></i> Upload File
                                                </button>';
                                        }
                                    }
                                }

                                if (strtotime($datelive) >= strtotime($explode_tanggal[0]) && strtotime($datelive) <= strtotime($explode_tanggal[1])) {
                                    $btn.= '<a href='.route('rekap_pelatihan.rekap_pelatihan_tambah_peserta',['id' => $row->id]).' class="btn btn-info btn-icon">
                                                <i class="fa fa-plus"></i> Tambah Peserta
                                            </a>';
                                }

                                if (strtotime($datelive) < strtotime($explode_tanggal[0])) {
                                    if (auth()->user()->can('rekap-edit')) {
                                    $btn.= '<a href='.route('rekap_pelatihan.rekap_pelatihan_edit',$row->id).' class="btn btn-warning btn-icon">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>';
                                    }
                                    if (auth()->user()->can('rekap-delete')) {
                                    $btn.= '<button type="button" onclick="hapus(`'.$row->id.'`)" class="btn btn-danger btn-icon">
                                                <i class="fa fa-trash"></i>
                                            </button>';
                                    }
                                }
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action','tema','status','tanggal'])
                            ->make(true);
        }
        // $data['periode'] = $periode;
        $data['periode'] = $this->periode->select('periode','status')->where('status','y')->first();
        if (empty($data['periode'])) {
            return redirect()->back()->with('error','Periode Tahunan Belum Dibuat. Silahkah hubungi team IT');
        }
        $date_now = Carbon::create($data['periode']['periode']);
        // $date_now = Carbon::now();
        $data['start_month'] = Carbon::now()->startOfYear()->format('m');
        $data['end_month'] = Carbon::now()->endOfYear()->format('m');
        for ($i=$data['start_month']; $i <= $data['end_month'] ; $i++) { 
            $total_hasil_rekap_plan = $this->rekap_pelatihan->where('status','Plan')->whereMonth('created_at',$i)->whereYear('created_at',$date_now)->count();
            $total_hasil_rekap_done = $this->rekap_pelatihan->where('status','Done')->whereMonth('created_at',$i)->whereYear('created_at',$date_now)->count();
            $data['total_hasil_rekap_plan'][] = $total_hasil_rekap_plan;
            $data['total_hasil_rekap_done'][] = $total_hasil_rekap_done;
        }
        // dd($data);
        return view('rekap_pelatihan.rekap',$data);
    }

    public function search_karyawan_departemen(Request $request)
    {
        $departemen_user = $this->departemen_user->where('departemen_id',$request->departemen)->get();
        if (empty($departemen_user)) {
            return response()->json([
                'success' => false,
                'data' => 'Data Karyawan Tidak Ditemukan'
            ]);
        }
        // dd($get_nik);
        return response()->json([
            'success' => true,
            'data' => $departemen_user
        ]);
    }

    public function rekap_pelatihan_create()
    {
        $data['periode'] = $this->periode->select('periode','status')->where('status','y')->first();
        if (empty($data['periode'])) {
            return redirect()->back()->with('error','Periode Tahunan Belum Dibuat. Silahkah hubungi team IT');
        }
        $data['rekap_kategoris'] = $this->rekap_pelatihan_kategori->all();
        $data['departemens'] = $this->departemen->all();
        $data['biodata_karyawans'] = $this->biodata_karyawan->all();
        return view('rekap_pelatihan.create',$data);
    }

    public function rekap_pelatihan_simpan(Request $request)
    {
        $rules = [
            'start_date' => 'required',
            'end_date' => 'required',
            'tema' => 'required',
            'kategori_pelatihan' => 'required',
            'penyelenggara' => 'required',
            'jenis' => 'required',
            'jml_hari' => 'required',
            'total_peserta' => 'required',
            'peserta' => 'required',
        ];

        $messages = [
            'start_date.required'  => 'Tanggal Mulai wajib diisi.',
            'end_date.required'  => 'Tanggal Selesai wajib diisi.',
            'tema.required'  => 'Tema wajib diisi.',
            'kategori_pelatihan.required'  => 'Kategori Pelatihan wajib diisi.',
            'penyelenggara.required'  => 'Penyelenggara wajib diisi.',
            'jenis.required'  => 'Jenis Pelatihan wajib diisi.',
            'jml_hari.required'  => 'Jumlah Hari wajib diisi.',
            'total_peserta.required'  => 'Total Peserta wajib diisi.',
            'peserta.required'  => 'Peserta wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $norut = $this->rekap_pelatihan->max('id');
            if(empty($norut)){
                $id = 1;
            }else{
                $id = $norut+1;
            }
            $input['id'] = $id;
            $input['check_date'] = $request->check_date;
            $input['tanggal'] = $request->start_date.','.$request->end_date;
            $input['periode'] = Carbon::create($request->end_date)->format('Y');
            $input['tema'] = $request->tema;
            $input['kategori_pelatihan'] = $request->kategori_pelatihan;
            $input['penyelenggara'] = $request->penyelenggara;
            $input['jenis'] = $request->jenis;
            $input['jml_hari'] = $request->jml_hari;
            if ($request->status == 'Plan') {
                $input['jml_jam_dlm_hari'] = 0;
            }else{
                $input['jml_jam_dlm_hari'] = $request->jml_jam_dlm_hari;
            }
            $input['total_peserta'] = $request->total_peserta;
            foreach ($request->peserta as $key => $peserta) {
                // $pesertas[] = '#'.$peserta;
                $departemen_user = $this->departemen_user->where('team',$peserta)->first();
                if (empty($departemen_user)) {
                    $departemen_user_id = 0;
                }else{
                    $departemen_user_id = $departemen_user['departemen_id'];
                }
                // dd($departemen_user['id']);
                $this->rekap_pelatihan_peserta->create([
                    'departemen_id' => $departemen_user_id,
                    'rekap_pelatihan_seminar_id' => $input['id'],
                    'peserta' => $peserta
                ]);
            }
            // dd($departemen_user);
            // foreach ($request->peserta as $key => $peserta) {
            //     $peserta = [
            //         [
            //             'nama' => $peserta
            //         ]
            //     ];
            // }
            // $input['peserta'] = json_encode($peserta);
            // $input['peserta'] = json_encode($request->peserta);
            // $input['peserta'] = implode($pesertas);
            $input['status'] = $request->status;
            $input['link'] = $request->link;
            // dd($input);
            $rekap_pelatihan = $this->rekap_pelatihan->create($input);
            if($rekap_pelatihan){
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

    public function rekap_pelatihan_detail($id)
    {
        $rekap_pelatihan = $this->rekap_pelatihan->find($id);
        // dd($rekap_pelatihan);
        if (empty($rekap_pelatihan)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data tidak ditemukan'
            ]);
        }
        $explode_tanggal = explode(',',$rekap_pelatihan->tanggal);
        if (Carbon::create($explode_tanggal[0])->format('Y-m-d') == Carbon::create($explode_tanggal[1])->format('Y-m-d')) {
            $tanggal = Carbon::create($explode_tanggal[1])->isoFormat('LL');
            $waktu = Carbon::create($explode_tanggal[0])->format('H:i').' - '.Carbon::create($explode_tanggal[1])->format('H:i');
        }else{
            $tanggal = Carbon::create($explode_tanggal[0])->format('d').' - '.Carbon::create($explode_tanggal[1])->isoFormat('LL');
            $waktu = Carbon::create($explode_tanggal[0])->format('H:i').' - '.Carbon::create($explode_tanggal[1])->format('H:i');
        }

        $rekap_pelatihan_pesertas = $this->rekap_pelatihan_peserta->where('rekap_pelatihan_seminar_id',$id)->get();
        $datelive = Carbon::now()->addDay($this->day)->format('Y-m-d H:i');
        $explode_tanggal = explode(',',$rekap_pelatihan->tanggal);
        if (strtotime($datelive) < strtotime($explode_tanggal[0])) {
            $status = '<span class="badge bg-primary"><i class="mdi mdi-file-table-outline"></i> '.'PLAN '.$datelive.'</span>';
        }elseif (strtotime($datelive) >= strtotime($explode_tanggal[0]) && strtotime($datelive) <= strtotime($explode_tanggal[1])) {
            $status = '<span class="badge bg-warning"><i class="mdi mdi-file-table-outline"></i> '.'ON PROCESS'.'</span>';
        }else{
            $status = '<span class="badge bg-success"><i class="mdi mdi-check-box-outline"></i> '.'SELESAI'.'</span>';
        }
        // if ($rekap_pelatihan->status == 'Plan') {
        //     $status = '<span class="badge bg-primary"><i class="mdi mdi-file-table-outline"></i> '.strtoupper($rekap_pelatihan->status).'</span>';
        // }elseif($rekap_pelatihan->status == 'Done'){
        //     $status = '<span class="badge bg-success"><i class="mdi mdi-check-all"></i> '.strtoupper($rekap_pelatihan->status).'</span>';
        // }

        // $explode_peserta = explode('#',$rekap_pelatihan->peserta);
        // foreach (json_decode($rekap_pelatihan->peserta) as $key => $peserta) {
        //     // if ($key != 0) {
        //     //     $pesertas[] = '<span class="badge bg-primary">'.$peserta.'</span>';
        //     // }
        //     $pesertas[] = '<span class="badge bg-primary">'.$peserta.'</span>';
        //     // $pesertas[] = '<span class="badge bg-primary">'.$peserta->peserta.'</span>';
        // }
        foreach ($rekap_pelatihan_pesertas as $key => $peserta) {
            // if ($key != 0) {
            //     $pesertas[] = '<span class="badge bg-primary">'.$peserta.'</span>';
            // }
            $pesertas[] = '<span class="badge bg-primary">'.$peserta->peserta.'</span>';
            // $pesertas[] = '<span class="badge bg-primary">'.$peserta->peserta.'</span>';
        }

        if (empty($rekap_pelatihan->file_sertifikat)) {
            $link_file_sertifikat = $rekap_pelatihan->file_sertifikat;
        }else{
            $link_file_sertifikat = asset('public/file_sertifikat/'.$rekap_pelatihan->file_sertifikat);
        }

        if (empty($rekap_pelatihan->file_absensi)) {
            $link_file_absensi = $rekap_pelatihan->file_absensi;
        }else{
            $link_file_absensi = asset('public/file_absensi/'.$rekap_pelatihan->file_absensi);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $rekap_pelatihan->id,
                'tanggal' => $tanggal,
                'time' => $waktu,
                'tema' => $rekap_pelatihan->tema,
                'penyelenggara' => $rekap_pelatihan->penyelenggara,
                'jenis' => $rekap_pelatihan->jenis,
                'jml_hari' => $rekap_pelatihan->jml_hari,
                'jml_jam_dlm_hari' => $rekap_pelatihan->jml_jam_dlm_hari,
                'total_peserta' => $rekap_pelatihan->total_peserta,
                'peserta' => $pesertas,
                'keterangan' => $rekap_pelatihan->keterangan,
                'status' => $status,
                'file_sertifikat' => $link_file_sertifikat,
                'file_absensi' => $link_file_absensi,
            ]
        ]);
    }

    public function rekap_pelatihan_edit(Request $request, $id)
    {
        $data['rekap_pelatihan'] = $this->rekap_pelatihan->find($id);
        if (empty($data['rekap_pelatihan'])) {
            return redirect()->back();
        }

        // $rekap_pelatihan_pesertas = $this->rekap_pelatihan_peserta->where('rekap_pelatihan_seminar_id',$id)->get();
        // dd($rekap_pelatihan_pesertas);
        if ($request->ajax()) {
            $rekap_pelatihan_pesertas = $this->rekap_pelatihan_peserta->where('rekap_pelatihan_seminar_id',$id)->get();
            return DataTables::of($rekap_pelatihan_pesertas)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<button type="button" onclick="hapus_peserta(`'.$row->id.'`)" class="btn btn-danger btn-icon">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }
        // dd($data['rekap_pelatihan_peserta']);
        $explode_tanggal = explode(',',$data['rekap_pelatihan']['tanggal']);
        $data['start_date'] = $explode_tanggal[0];
        $data['end_date'] = $explode_tanggal[1];
        $data['rekap_kategoris'] = $this->rekap_pelatihan_kategori->all();
        $data['departemens'] = $this->departemen->all();
        // dd($data['rekap_pelatihan']['peserta']);
        // $data['pesertas'] = $this->rekap_pelatihan_peserta->where('rekap_pelatihan_seminar_id',$id)->get();
        return view('rekap_pelatihan.edit',$data);
    }

    public function rekap_pelatihan_update(Request $request, $id)
    {
        $rules = [
            'jml_hari' => 'required',
        ];
        $messages = [
            'jml_hari.required'  => 'Jumlah Hari Pelatihan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $input['jml_hari'] = $request->jml_hari;
            $rekap_pelatihan = $this->rekap_pelatihan->find($id)->update($input);
            if($rekap_pelatihan){
                // foreach ($request->peserta as $key => $peserta) {
                //     if ($peserta) {
                //         $this->rekap_pelatihan_peserta->where('rekap_pelatihan_seminar_id',$id)->updateOrCreate([
                //             'rekap_pelatihan_seminar_id' => $id,
                //             'peserta' => $peserta
                //         ]);
                //     }else{
                //         $this->rekap_pelatihan_peserta->where('rekap_pelatihan_seminar_id',$id)
                //                                     ->where('peserta','!=',$peserta)
                //                                     ->delete();
                //     }
                // }
                if (!empty($request->peserta)) {
                    foreach ($request->peserta as $key => $peserta) {
                        $departemen_user = $this->departemen_user->where('team',$peserta)->first();
                        if (empty($departemen_user)) {
                            $departemen_user_id = 0;
                        }else{
                            $departemen_user_id = $departemen_user['departemen_id'];
                        }
                        $this->rekap_pelatihan_peserta->where('rekap_pelatihan_seminar_id',$id)->updateOrCreate([
                            'departemen_id' => $departemen_user_id,
                            'rekap_pelatihan_seminar_id' => $id,
                            'peserta' => $peserta
                        ]);
                    }
                }
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

    public function rekap_pelatihan_canvas_right_update(Request $request)
    {
        $rules = [
            'update_jml_jam_dlm_hari' => 'required',
        ];

        $messages = [
            'update_jml_jam_dlm_hari.required'  => 'Jumlah Jam Pelatihan belum diinput.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $input['jml_jam_dlm_hari'] = $request->update_jml_jam_dlm_hari;
            $input['status'] = 'Done';
            $rekap_pelatihan = $this->rekap_pelatihan->find($request->update_id)->update($input);
            if($rekap_pelatihan){
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

    public function rekap_pelatihan_delete($id)
    {
        $rekap_pelatihan = $this->rekap_pelatihan->find($id);
        if (empty($rekap_pelatihan)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data tidak ditemukan'
            ]);
        }
        $rekap_pelatihan->delete();
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Data Berhasil Dihapus'
        ]);
    }

    public function download_excel_rekap($periode)
    {
        $data['rekap_pelatihans'] = $this->rekap_pelatihan->where('periode',$periode)->get();
        $data['periode'] = $periode;
        // dd($data);
        // return view('rekap_pelatihan.excel_rekapan',$data);
        return Excel::download(new RekapPelatihanExcel($periode), 'Rekap Pelatihan & Seminar PT Indonesian Tobacco Tbk Periode '.$periode.'.xlsx');
    }

    public function download_excel_rekap_all_dep($periode)
    {
        // $data['rekap_pelatihans'] = $this->rekap_pelatihan->with('rekap_pelatihan_seminar_peserta')->where('periode',$periode)->get();
        $data['periode'] = $periode;
        $departemen = array(
            'Top Managemen',
            'Audit Internal',
            'IT & Corsec',
            'HRGA',
            'Finance & Accounting',
            'Marketing',
            'Purchasing',
            'PPIC',
            'Produksi',
            'QC',
            'Rnd',
            'Klaten',
            'QHSE',
        );
        $data['departemens'] = $this->departemen->whereIn('departemen',$departemen)->get();
        // dd($data);
        // return view('rekap_pelatihan.excel_rekapan_all_dep',$data);
        return Excel::download(new RekapPelatihanAllDepExcel($periode), 'Rekap Pelatihan & Seminar PT Indonesian Tobacco Tbk All Departemen Periode '.$periode.'.xlsx');
    }

    public function download_excel_rekap_all_pelatihan($periode)
    {
        // $data['rekap_pelatihans'] = $this->rekap_pelatihan->with('rekap_pelatihan_seminar_peserta')->where('periode',$periode)->get();
        $data['periode'] = $periode;
        $data['departemens'] = $this->departemen->all();
        // dd($data);
        // return view('rekap_pelatihan.excel_rekapan_all_pelatihan',$data);
        return Excel::download(new RekapPelatihanExcel($periode), 'Rekap Pelatihan & Seminar PT Indonesian Tobacco Tbk All Departemen Periode '.$periode.'.xlsx');
    }

    public function download_excel_rekap_periode($periode)
    {
        $data['start_month'] = Carbon::createFromDate(date($periode),date('m'))->startOfYear()->format('m');
        $data['end_month'] = Carbon::createFromDate(date($periode),date('m'))->endOfYear()->format('m');
        $data['periode'] = $periode;
        // dd($data);
        // $data['rekap_pelatihans'] = $this->rekap_pelatihan->where('periode',$periode)->get();
        // return view('rekap_pelatihan.excel_rekap_periode',$data);
        return Excel::download(new TotalRekapPelatihanExcel($periode), 'Total Rekap Pelatihan & Seminar PT Indonesian Tobacco Tbk Periode '.$periode.'.xlsx');

    }

    public function search_rekapan_pelatihan(Request $request)
    {
        // $explode_tanggal = explode(',',$)
        // $data['rekap_pelatihans'] = $this->rekap_pelatihan->where('periode',$request->periode)->get();
        $data['periode'] = $request->periode;
        // if (empty($data['rekap_pelatihans'])) {
        //     return response()->json([
        //         'success' => false,
        //         'message_title' => 'Gagal',
        //         'message_content' => 'Data tidak ditemukan'
        //     ]);
        // }

        // dd($data);

        return response()->json([
            'success' => true,
            'title' => 'Rekap Pelatihan Seminar PT Indonesian Tobacco Tbk Periode '.$data['periode'],
            'link_rekap' => route('rekap_pelatihan.download_excel_rekap',$data['periode']),
            'link_rekap_all_dep' => route('rekap_pelatihan.download_excel_rekap_all_dep',$data['periode']),
            'link_rekap_all_pelatihan' => route('rekap_pelatihan.download_excel_rekap_all_pelatihan',$data['periode']),
            'link_rekap_periode' => route('rekap_pelatihan.download_excel_rekap_periode',$data['periode']),
        ]);

        // return view('rekap_pelatihan.excel_rekapan',$data);
        // return Excel::download(new RekapPelatihanExcel($request->periode), 'testing.xlsx');
    }

    public function rekap_pelatihan_upload_file(Request $request)
    {
        $rekap_pelatihan = $this->rekap_pelatihan->find($request->upload_id);
        
        // File Sertifikat
        if ($request->file('upload_file_sertifikat')) {
            $sertifikat = $request->file('upload_file_sertifikat');
            $nama_sertifikat = Carbon::now()->format('d-m-Y-H-i-s')."_".Str::slug($sertifikat->getClientOriginalName()).'.'.$sertifikat->getClientOriginalExtension();
            $tujuan_upload_sertifikat = 'public/file_sertifikat';
            $sertifikat->move($tujuan_upload_sertifikat,$nama_sertifikat);
            $input['file_sertifikat'] = $nama_sertifikat;
        }
        // else{
        //     // $array_message = array(
        //     //     'success' => false,
        //     //     'message_title' => 'Gagal',
        //     //     'message_content' => 'Upload File Sertifikat belum diinput',
        //     //     'message_type' => 'error',
        //     // );
        //     // return response()->json($array_message);
        //     $nama_sertifikat = null;
        // }

        // File Sertifikat
        if ($request->file('upload_file_absensi')) {
            $absensi = $request->file('upload_file_absensi');
            $nama_absensi = Carbon::now()->format('d-m-Y-H-i-s')."_".Str::slug($absensi->getClientOriginalName()).'.'.$absensi->getClientOriginalExtension();
            $tujuan_upload_absensi = 'public/file_absensi';
            $absensi->move($tujuan_upload_absensi,$nama_absensi);
            $input['file_absensi'] = $nama_absensi;
        }
        // else{
        //     // $array_message = array(
        //     //     'success' => false,
        //     //     'message_title' => 'Gagal',
        //     //     'message_content' => 'Upload File Absensi belum diinput',
        //     //     'message_type' => 'error',
        //     // );
        //     // return response()->json($array_message);
        //     $nama_absensi = null;
        // }

        $rekap_pelatihan->update($input);

        if ($rekap_pelatihan) {
            $id=$rekap_pelatihan->id;
            $message_title="Berhasil !";
            $message_content="Berkas Berhasil Diupload";
            $message_type="success";
            $message_succes = true;
        }

        // $message_title="Gagal !";
        // $message_content="Berkas Gagal Diupload";
        // $message_type="error";
        // $message_succes = false;

        $array_message = array(
            'id' => $id,
            'success' => $message_succes,
            'message_title' => $message_title,
            'message_content' => $message_content,
            'message_type' => $message_type,
        );
        return response()->json($array_message);

    }

    public function rekap_pelatihan_tambah_peserta(Request $request, $id)
    {
        $data['rekap_pelatihan'] = $this->rekap_pelatihan->where('id',$id)
                                                        // ->where('status','Plan')
                                                        ->first();
        // dd($rekap_pelatihan);
        if (empty($data['rekap_pelatihan'])) {
            return redirect()->back();
        }

        if ($request->ajax()) {
            $rekap_pelatihan_seminar_pesertas = $this->rekap_pelatihan_peserta->where('rekap_pelatihan_seminar_id',$data['rekap_pelatihan']['id'])->get();
            return DataTables::of($rekap_pelatihan_seminar_pesertas)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<button type="button" onclick="hapus_peserta(`'.$row->id.'`)" class="btn btn-danger btn-icon">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }
        // dd($data);
        $data['departemens'] = $this->departemen->all();
        $explode_tanggal = explode(',',$data['rekap_pelatihan']['tanggal']);
        $data['start_date'] = $explode_tanggal[0];
        $data['end_date'] = $explode_tanggal[1];

        return view('rekap_pelatihan.tambah_peserta',$data);
    }

    public function rekap_pelatihan_tambah_peserta_update(Request $request, $id)
    {
        $rekap_pelatihan = $this->rekap_pelatihan->where('id',$id)
                                                        ->where('status','Plan')
                                                        ->first();
        if (empty($rekap_pelatihan)) {
            return redirect()->back();
        }

        if (!empty($request->peserta)) {
            foreach ($request->peserta as $key => $peserta) {
                $departemen_user = $this->departemen_user->where('team',$peserta)->first();
                if (empty($departemen_user)) {
                    $departemen_user_id = 0;
                }else{
                    $departemen_user_id = $departemen_user['departemen_id'];
                }
                $this->rekap_pelatihan_peserta->where('rekap_pelatihan_seminar_id',$id)->updateOrCreate([
                    'departemen_id' => $departemen_user_id,
                    'rekap_pelatihan_seminar_id' => $id,
                    'peserta' => $peserta
                ]);
            }
        }

        $input['total_peserta'] = $request->total_peserta;
        $rekap_pelatihan->update($input);
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Tambah Peserta Berhasil Dihapus'
        ]);
    }

    public function rekap_pelatihan_hapus_peserta($id, $id_peserta)
    {
        $rekap_pelatihan_seminar_peserta = $this->rekap_pelatihan_peserta->where('id', $id_peserta)->where('rekap_pelatihan_seminar_id',$id)->first();
        // dd($rekap_pelatihan_seminar_peserta);
        if(empty($rekap_pelatihan_seminar_peserta)){
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Tersedia'
            ]);
        }
        $rekap_pelatihan_seminar_peserta->delete();
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Peserta Berhasil Dihapus'
        ]);
    }
}
