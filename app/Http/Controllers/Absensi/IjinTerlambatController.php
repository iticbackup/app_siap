<?php

namespace App\Http\Controllers\Absensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PresensiInfo;
use App\Models\BiodataKaryawan;

use \Carbon\Carbon;
use DB;
use Validator;

class IjinTerlambatController extends Controller
{
    function __construct(
        PresensiInfo $presensi_info,
        BiodataKaryawan $biodata_karyawan
        )
    {
        $this->presensi_info = $presensi_info;
        $this->biodata_karyawan = $biodata_karyawan;
    }

    public function index(){
        $date_live = Carbon::now()->format('Y');
        $data['ijin_terlambats'] = $this->presensi_info->with('biodata_karyawan','presensi_status')
                                            ->whereYear('scan_date',$date_live)
                                            ->orderBy('scan_date','desc')
                                            ->paginate(20);
                                            // dd($data);
        $data['status_absensis'] = DB::connection('absensi')->table('att_status')->get();
        return view('absensi.ijin_terlambat.index',$data);
    }

    public function simpan(Request $request)
    {
        $rules = [
            'nik' => 'required',
            'tanggal' => 'required',
            // 'waktu_datang_menit' => 'required',
            // 'jam_masuk_jam' => 'required',
            // 'jam_masuk_menit' => 'required',
            // 'jam_istirahat_jam' => 'required',
            // 'jam_istirahat_menit' => 'required',
            // 'jam_pulang_jam' => 'required',
            // 'jam_pulang_menit' => 'required',
            'keterangan' => 'required',
        ];

        $messages = [
            'nik.required'  => 'NIK Karyawan wajib diisi.',
            // 'tanggal.required'  => 'Tanggal Ijin wajib diisi.',
            // 'waktu_datang_menit.required'  => 'Jam Datang wajib diisi.',
            // 'jam_masuk_jam.required'  => 'Jam Keluar Waktu Jam wajib diisi.',
            // 'jam_masuk_menit.required'  => 'Jam Keluar Waktu Menit wajib diisi.',
            // 'jam_istirahat_jam.required'  => 'Jam Istirahat Waktu Jam wajib diisi.',
            // 'jam_istirahat_menit.required'  => 'Jam Istirahat Waktu Menit wajib diisi.',
            // 'jam_pulang_jam.required'  => 'Jam Datang Waktu Jam wajib diisi.',
            // 'jam_pulang_menit.required'  => 'Jam Datang Waktu Menit wajib diisi.',
            'keterangan.required'  => 'Keterangan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $biodata_karyawan = $this->biodata_karyawan->select('pin')->where('nik',$request->nik)->first();
            $norut = $this->presensi_info->max('att_rec');
            $input['att_id'] = Carbon::now()->format('Y').$norut+1;
            $input['scan_date'] = $request->tanggal.' '.$request->waktu_datang_jam.':'.$request->waktu_datang_menit.':00';
            $input['pin'] = $biodata_karyawan->pin;
            $input['inoutmode'] = 1;
            $input['status'] = $request->status;
            
            if (!empty($request->jam_masuk_jam) && !empty($request->jam_masuk_menit)) {
                $penyesuaian_jam_masuk_jam = $request->jam_masuk_jam.':'.$request->jam_masuk_menit;
            }else{
                $penyesuaian_jam_masuk_jam = null;
            }
            
            if (!empty($request->jam_istirahat_jam) && !empty($request->jam_istirahat_menit)) {
                $penyesuaian_jam_istirahat_jam = $request->jam_istirahat_jam.':'.$request->jam_istirahat_menit;
            }else{
                $penyesuaian_jam_istirahat_jam = null;
            }
    
            if (!empty($request->jam_pulang_jam) && !empty($request->jam_pulang_menit)) {
                $penyesuaian_jam_pulang_jam = $request->jam_pulang_jam.':'.$request->jam_pulang_menit;
            }else{
                $penyesuaian_jam_pulang_jam = null;
            }

            $input['keterangan'] = $request->keterangan.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;

            $presensi_info = $this->presensi_info->create($input);
            if ($presensi_info) {
                $message_title="Berhasil !";
                $message_content="Presensi Ijin / Terlambat Berhasil Dibuat";
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

    public function detail($att_rec){
        $ijin_terlambat = $this->presensi_info->with('biodata_karyawan')->where('att_rec',$att_rec)->first();
        if (empty($ijin_terlambat)) {
            return response()->json([
                'success' => false,
                'message_content' => 'Data ijin terlambat tidak ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $ijin_terlambat
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'edit_nik' => 'required',
            'edit_tanggal' => 'required',
            // 'edit_waktu_datang_menit' => 'required',
            // 'edit_jam_masuk_jam' => 'required',
            // 'edit_jam_masuk_menit' => 'required',
            // 'edit_jam_istirahat_jam' => 'required',
            // 'edit_jam_istirahat_menit' => 'required',
            // 'edit_jam_pulang_jam' => 'required',
            // 'edit_jam_pulang_menit' => 'required',
            'edit_keterangan' => 'required',
        ];

        $messages = [
            'edit_nik.required'  => 'NIK Karyawan wajib diisi.',
            'edit_tanggal.required'  => 'Tanggal Ijin wajib diisi.',
            // 'edit_waktu_datang_menit.required'  => 'Jam Datang wajib diisi.',
            // 'edit_jam_masuk_jam.required'  => 'Jam Keluar Waktu Jam wajib diisi.',
            // 'edit_jam_masuk_menit.required'  => 'Jam Keluar Waktu Menit wajib diisi.',
            // 'edit_jam_istirahat_jam.required'  => 'Jam Istirahat Waktu Jam wajib diisi.',
            // 'edit_jam_istirahat_menit.required'  => 'Jam Istirahat Waktu Menit wajib diisi.',
            // 'edit_jam_pulang_jam.required'  => 'Jam Datang Waktu Jam wajib diisi.',
            // 'edit_jam_pulang_menit.required'  => 'Jam Datang Waktu Menit wajib diisi.',
            'edit_keterangan.required'  => 'Keterangan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $presensi_info = $this->presensi_info->where('att_rec',$request->edit_att_rec)->first();
            $input['status'] = $request->edit_status;
            if (!empty($request->edit_jam_masuk_jam) && !empty($request->edit_jam_masuk_menit)) {
                $penyesuaian_jam_masuk_jam = $request->edit_jam_masuk_jam.':'.$request->edit_jam_masuk_menit;
            }else{
                $penyesuaian_jam_masuk_jam = null;
            }
            
            if (!empty($request->edit_jam_istirahat_jam) && !empty($request->edit_jam_istirahat_menit)) {
                $penyesuaian_jam_istirahat_jam = $request->edit_jam_istirahat_jam.':'.$request->edit_jam_istirahat_menit;
            }else{
                $penyesuaian_jam_istirahat_jam = null;
            }
    
            if (!empty($request->edit_jam_pulang_jam) && !empty($request->edit_jam_pulang_menit)) {
                $penyesuaian_jam_pulang_jam = $request->edit_jam_pulang_jam.':'.$request->edit_jam_pulang_menit;
            }else{
                $penyesuaian_jam_pulang_jam = null;
            }
            $input['keterangan'] = $request->edit_keterangan.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;
            $presensi_info->update($input);
            if ($presensi_info) {
                $message_title="Berhasil !";
                $message_content="Presensi Ijin / Terlambat Berhasil Diupdate";
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

    public function delete($att_rec)
    {
        $presensi_info = $this->presensi_info->where('att_rec',$att_rec)->delete();
        return response()->json([
            'success' => true,
            'message_content' => 'Presensi Ijin / Terlambat Berhasil Dihapus'
        ]);
    }

    public function search(Request $request)
    {
        $biodata_karyawan = BiodataKaryawan::select('nik','pin')
                                            ->where('nik','LIKE','%'.$request->cari.'%')
                                            ->orWhere('nama','LIKE','%'.$request->cari.'%')
                                            ->first();
        $data['ijin_terlambats'] = $this->presensi_info->where('pin',$biodata_karyawan->pin)
                                            ->orWhereBetween('scan_date',[$request->cari_tanggal_awal, $request->cari_tanggal_akhir])
                                            ->paginate(20);
        $data['status_absensis'] = DB::connection('absensi')->table('att_status')->get();
        return view('absensi.ijin_terlambat.index',$data);
    }
}
