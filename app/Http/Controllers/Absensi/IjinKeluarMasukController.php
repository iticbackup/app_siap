<?php

namespace App\Http\Controllers\Absensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BiodataKaryawan;
use App\Models\IjinKeluarMasuk;
use App\Models\IticDepartemen;
use App\Models\EmpPosisi;

use \Carbon\Carbon;
use Validator;
use DataTables;

class IjinKeluarMasukController extends Controller
{
    function __construct(IjinKeluarMasuk $ijin_keluar_masuk)
    {
        $this->ijin_keluar_masuk = $ijin_keluar_masuk;
    }

    public function index(){
        // if ($request->ajax()) {
        //     // $date_live = Carbon::now()->format('Y');
        //     $date_live = 2023;
        //     $data = $this->ijin_keluar_masuk->whereYear('tanggal_ijin',$date_live)
        //                                     ->get();
        //     return DataTables::of($data)
        //                     ->addIndexColumn()
        //                     ->addColumn('nama', function($row){
        //                         $cek_status_kerja = IticDepartemen::where('id_departemen',$row->biodata_karyawan->satuan_kerja)->first();
        //                         if (empty($cek_status_kerja)) {
        //                             $satuan_kerja = '-';
        //                         }else{
        //                             if ($cek_status_kerja->nama_departemen >= 1) {
        //                                 $satuan_kerja = $cek_status_kerja->nama_unit;
        //                             }else{
        //                                 $satuan_kerja = $cek_status_kerja->nama_departemen;
        //                             }
        //                         }

        //                         $cek_posisi = EmpPosisi::where('id_posisi',$row->biodata_karyawan->id_posisi)->first();
        //                         if (empty($cek_posisi)) {
        //                             $posisi = '-';
        //                         }else{
        //                             $posisi = $cek_posisi->nama_posisi;
        //                         }

        //                         $card = "<div class='card'>";
        //                         $card .=     "<div class='card-body'>";
        //                         $card .=        "<h6>".$row->biodata_karyawan->nik.' - '.$row->biodata_karyawan->nama."</h6>";
        //                         $card .=        "<hr>";
        //                         $card .=        "<div>"."<b>Departemen : <b>".$satuan_kerja."</div>";
        //                         $card .=        "<div>"."<b>Posisi : <b>".$posisi."</div>";
        //                         $card .=    "</div>";
        //                         $card .= "</div>";
        //                         return $card;
        //                     })
        //                     ->addColumn('tanggal_ijin', function($row){
        //                         return $row->tanggal_ijin;
        //                     })
        //                     ->addColumn('durasi', function($row){
        //                         // return $row->tanggal_ijin;
        //                         $awal = strtotime($row->jam_keluar);
        //                         $akhir = strtotime($row->jam_datang);
        //                         $total_jam = ($akhir-$awal)/60;
        //                         return $total_jam.' Menit';
        //                     })
        //                     ->addColumn('action', function($row){
        //                         $btn = "<div class='btn-group'>";
        //                         $btn .= "<button onclick='edit(`".$row->id_ijin."`)' class='btn btn-warning'>".'<i class="bx bx-edit"></i> Edit'."</button>";
        //                         $btn .= "<button onclick='hapus(`".$row->id_ijin."`)' class='btn btn-danger'>".'<i class="bx bx-trash"></i> Delete'."</button>";
        //                         $btn .= "</div>";
        //                         return $btn;
        //                     })
        //                     ->rawColumns(['nama','action'])
        //                     ->make(true);
        // }
        $date_live = Carbon::now()->format('Y');
        // $date_live = 2023;
        $data['ijin_keluar_masuks'] = $this->ijin_keluar_masuk->with('biodata_karyawan')
                                            ->whereYear('tanggal_ijin',$date_live)
                                            ->orderBy('tanggal_ijin','desc')
                                            ->paginate(20);
        
        return view('absensi.ijin_keluar_masuk.index',$data);
        // return view('absensi.ijin_keluar_masuk.index');
    }

    public function simpan(Request $request)
    {
        $rules = [
            'nik' => 'required',
            'tanggal_ijin' => 'required',
            'jam_keluar_jam' => 'required',
            'jam_keluar_menit' => 'required',
            'jam_datang_jam' => 'required',
            'jam_datang_menit' => 'required',
            'jam_istirahat_jam' => 'required',
            'jam_istirahat_menit' => 'required',
            'keperluan' => 'required',
        ];

        $messages = [
            'nik.required'  => 'NIK Karyawan wajib diisi.',
            'tanggal_ijin.required'  => 'Tanggal Ijin wajib diisi.',
            'jam_keluar_jam.required'  => 'Jam Keluar Waktu Jam wajib diisi.',
            'jam_keluar_menit.required'  => 'Jam Keluar Waktu Menit wajib diisi.',
            'jam_datang_jam.required'  => 'Jam Datang Waktu Jam wajib diisi.',
            'jam_datang_menit.required'  => 'Jam Datang Waktu Menit wajib diisi.',
            'jam_istirahat_jam.required'  => 'Jam Istirahat Waktu Jam wajib diisi.',
            'jam_istirahat_menit.required'  => 'Jam Istirahat Waktu Menit wajib diisi.',
            'keperluan.required'  => 'Keperluan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $input['nik'] = $request->nik;
            $input['tanggal_ijin'] = $request->tanggal_ijin;
            $input['jam_keluar'] = $request->jam_keluar_jam.':'.$request->jam_keluar_menit.':00';
            $input['jam_datang'] = $request->jam_datang_jam.':'.$request->jam_datang_menit.':00';
            $input['jam_istirahat'] = $request->jam_istirahat_jam.':'.$request->jam_istirahat_menit.':00';
            $input['keperluan'] = $request->keperluan;
            $input['nik_op'] = auth()->user()->nik;
            $input['tanggal_input'] = Carbon::now();

            $ijin_keluar_masuk = $this->ijin_keluar_masuk->create($input);
            if ($ijin_keluar_masuk) {
                $message_title="Berhasil !";
                $message_content="NIK Karyawan ".$input['nik']." Ijin Keluar Masuk Berhasil Ditambah";
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

    public function detail($id_ijin){
        $ijin_keluar_masuk = $this->ijin_keluar_masuk->where('id_ijin',$id_ijin)->first();
        if (empty($ijin_keluar_masuk)) {
            return response()->json([
                'success' => false,
                'message_content' => 'Data ijin keluar masuk tidak ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $ijin_keluar_masuk
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'edit_nik' => 'required',
            'edit_tanggal_ijin' => 'required',
            'edit_jam_keluar_jam' => 'required',
            'edit_jam_keluar_menit' => 'required',
            'edit_jam_datang_jam' => 'required',
            'edit_jam_datang_menit' => 'required',
            'edit_jam_istirahat_jam' => 'required',
            'edit_jam_istirahat_menit' => 'required',
            'edit_keperluan' => 'required',
        ];

        $messages = [
            'edit_nik.required'  => 'NIK Karyawan wajib diisi.',
            'edit_tanggal_ijin.required'  => 'Tanggal Ijin wajib diisi.',
            'edit_jam_keluar_jam.required'  => 'Jam Keluar Waktu Jam wajib diisi.',
            'edit_jam_keluar_menit.required'  => 'Jam Keluar Waktu Menit wajib diisi.',
            'edit_jam_datang_jam.required'  => 'Jam Datang Waktu Jam wajib diisi.',
            'edit_jam_datang_menit.required'  => 'Jam Datang Waktu Menit wajib diisi.',
            'edit_jam_istirahat_jam.required'  => 'Jam Istirahat Waktu Jam wajib diisi.',
            'edit_jam_istirahat_menit.required'  => 'Jam Istirahat Waktu Menit wajib diisi.',
            'edit_keperluan.required'  => 'Keperluan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $ijin_keluar_masuk = $this->ijin_keluar_masuk->where('id_ijin',$request->edit_id_ijin)->first();
            $input['nik'] = $request->edit_nik;
            $input['tanggal_ijin'] = $request->edit_tanggal_ijin;
            $input['jam_keluar'] = $request->edit_jam_keluar_jam.':'.$request->edit_jam_keluar_menit.':00';
            $input['jam_datang'] = $request->edit_jam_datang_jam.':'.$request->edit_jam_datang_menit.':00';
            $input['jam_istirahat'] = $request->edit_jam_istirahat_jam.':'.$request->edit_jam_istirahat_menit.':00';
            $input['keperluan'] = $request->edit_keperluan;
            $input['nik_op'] = auth()->user()->nik;
            $input['tanggal_input'] = Carbon::now();
            $ijin_keluar_masuk->update($input);
            if ($ijin_keluar_masuk) {
                $message_title="Berhasil !";
                $message_content="NIK Karyawan ".$input['nik']." Ijin Keluar Masuk Berhasil Diupdate";
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

    public function delete($id_ijin){
        $ijin_keluar_masuk = $this->ijin_keluar_masuk::where('id_ijin',$id_ijin)->delete();
        return response()->json([
            'success' => true,
            'message_content' => 'NIK Karyawan Berhasil Dihapus'
        ]);
    }

    public function search(Request $request)
    {
        // $nik = $request->cari;
        // $nama = $request->cari;
        // $posisi = $request->cari_posisi;
        // dd($request->all());
        $biodata_karyawan = BiodataKaryawan::select('nik','pin')
                                            ->where('nik','LIKE','%'.$request->cari.'%')
                                            ->orWhere('nama','LIKE','%'.$request->cari.'%')
                                            ->first();
                                            // dd($biodata_karyawan);
        $data['ijin_keluar_masuks'] = $this->ijin_keluar_masuk->with('biodata_karyawan')
                                            ->where('nik',$biodata_karyawan->nik)
                                            ->whereBetween('tanggal_ijin',[$request->cari_tanggal_awal,$request->cari_tanggal_akhir])
                                            // ->whereRelation('biodata_karyawan','nik',$request->cari)
                                            ->paginate(20)->withQueryString();
                                            // dd($data['ijin_keluar_masuks']);
        return view('absensi.ijin_keluar_masuk.index',$data);              
    }
}
