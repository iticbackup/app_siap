<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\FileManagerCategory;
use App\Models\FileManagerPerubahanData;
use App\Models\FileManagerPerubahanDataDetail;
use App\Models\FileManagerList;
use App\Models\Departemen;
use App\Models\DepartemenUser;
use App\Models\VerifikasiDokumen;

use FilippoToso\PdfWatermarker\Support\Pdf;
use FilippoToso\PdfWatermarker\Facades\ImageWatermarker;
use FilippoToso\PdfWatermarker\Watermarks\ImageWatermark;
use FilippoToso\PdfWatermarker\PdfWatermarker;
use FilippoToso\PdfWatermarker\Facades\TextWatermarker;
use FilippoToso\PdfWatermarker\Support\Position;

use \Carbon\Carbon;
use Validator;
use DataTables;
use File;
use Session;
use Storage;
// use PDF;

class PerubahanDataFileManagerController extends Controller
{
    function __construct(
        FileManagerCategory $file_manager_category,
        FileManagerPerubahanData $file_manager_perubahan_data,
        FileManagerPerubahanDataDetail $file_manager_perubahan_data_detail,
        FileManagerList $file_manager_list,
        Departemen $departemen,
        DepartemenUser $departemen_user,
        VerifikasiDokumen $verifikasi_dokumen
    )
    {
        $this->file_manager_category = $file_manager_category;
        $this->file_manager_perubahan_data = $file_manager_perubahan_data;
        $this->file_manager_perubahan_data_detail = $file_manager_perubahan_data_detail;
        $this->file_manager_list = $file_manager_list;
        $this->departemen = $departemen;
        $this->departemen_user = $departemen_user;
        $this->verifikasi_dokumen = $verifikasi_dokumen;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->nik == '0000000' || auth()->user()->nik == '1207514' || auth()->user()->nik == '1711952' || auth()->user()->nik == '2007275'){
                $data = $this->file_manager_perubahan_data->all();
            }else{
                $departemen_user = $this->departemen_user->where('nik',auth()->user()->nik)->first();
                $data = $this->file_manager_perubahan_data->where('departemen_id',$departemen_user->departemen_id)->get();
            }
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('kode_formulir', function($row){
                                return '<span class="badge badge-outline-primary">'.$row->kode_formulir.'</span>';
                            })
                            ->addColumn('departemen_id', function($row){
                                return $row->departemen->departemen;
                            })
                            ->addColumn('tanggal_formulir', function($row){
                                if ($row->tanggal_formulir == null) {
                                    return '-';
                                }else{
                                    return Carbon::create($row->tanggal_formulir)->isoFormat('dddd, LL');
                                }
                            })
                            ->addColumn('status', function($row){
                                if (empty($row->status)) {
                                    // return '<span class="badge bg-warning">ON PROCESS</span>';
                                    if ($row->is_open == 'y') {
                                        return '<span class="badge bg-primary">OPEN</span>';
                                    }else{
                                        return '<span class="badge bg-warning">WAITING VERIFICATION</span>';
                                    }
                                }else{
                                    $explode_validasi = explode('|',$row->status);
                                    if ($explode_validasi[0] == 'n' && $explode_validasi[2] == null) {
                                        return '<span class="badge bg-danger">REJECTED DOCUMENT CONTROL</span>';
                                    }elseif ($explode_validasi[0] == 'y' && $explode_validasi[2] == null) {
                                        return '<span class="badge bg-success">APPROVED DOCUMENT CONTROL</span>'.' - '.'<span class="badge bg-warning">WAITING MANAGEMENT REPRESENTATIVE</span>';
                                    }
                                    elseif($explode_validasi[0] == 'y' && $explode_validasi[2] == 'n'){
                                        return '<span class="badge bg-danger">REJECTED MANAGEMENT REPRESENTATIVE</span>';
                                    }elseif($explode_validasi[0] == 'n' && $explode_validasi[2] == 'n'){
                                        return '<span class="badge bg-danger">ALL REJECTED</span>';
                                    }elseif($explode_validasi[0] == 'y' && $explode_validasi[2] == 'y'){
                                        return '<span class="badge bg-success">APPROVED DOCUMENT CONTROL & MANAGEMENT REPRESENTATIVE</span>';
                                    }
                                }
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                if ($row->is_open == 'y') {
                                    $btn.= '<a href='.route('perubahan_data.create',['id' => $row->id]).' class="btn btn-success btn-icon">
                                                <i class="fa fa-plus"></i> Input Data Perubahan
                                            </a>';
                                }else{
                                    $btn.= '<a href='.route('perubahan_data.detail',['id' => $row->id]).' class="btn btn-primary btn-icon">
                                                <i class="fa fa-eye"></i> Detail Perubahan
                                            </a>';
                                }
                                if (empty($row->status)) {
                                    // $btn.= '<a href='.route('perubahan_data.detail.edit',['id' => $row->id]).' class="btn btn-warning btn-icon">
                                    //             <i class="fa fa-edit"></i> Edit
                                    //         </a>';
                                }else{
                                    $explode_validasi = explode('|',$row->status);
                                    if ($explode_validasi[0] == 'y' && $explode_validasi[2] == 'y') {
                                        $btn.= '<a href='.route('perubahan_data.cetak_dokumen',['id' => $row->id]).' class="btn btn-info btn-icon" target="_blank">
                                                    <i class="fa fa-print"></i> Print Dokumen
                                                </a>';
                                    }
                                }
                                // $btn.= '<button type="button" onclick="hapus(`'.$row->id.'`)" class="btn btn-danger btn-icon">
                                //             <i class="fa fa-trash"></i>
                                //         </button>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action','kode_formulir','status'])
                            ->make(true);
        }
        return view('file_manager.perubahan_data.index');
    }

    public function buat_nomor_formulir()
    {
        $departemen = array(
            'IT & Corsec',
            'HRGA',
            'Finance & Accounting',
            'Marketing',
            'Purchasing',
            'Produksi',
            'QC'
        );
        $data['departemens'] = $this->departemen->whereIn('departemen',$departemen)->get();
        return view('file_manager.perubahan_data.create_no_formulir',$data);
    }

    public function buat_nomor_formulir_simpan(Request $request)
    {
        $norut = \DB::table('file_manager_perubahan_data')->max('id');
        // $norut = $this->file_manager_perubahan_data->max('id');
        $input['id'] = $norut+1;
        $input['kode_formulir'] = 'FPD-'.Carbon::now()->format('dmY').$norut++;
        // dd('TRX-'.Carbon::now()->format('dmY').$norut++);
        $input['is_open'] = 'y';

        if (auth()->user()->nik == '0000000') {
            $input['departemen_id'] = $request->departemen_id;
            $input['pengajuan_signature'] = auth()->user()->name;
        }else{
            $departemen_user = $this->departemen_user->where('nik',auth()->user()->nik)->first();
            $departemen = $this->departemen->find($departemen_user->departemen_id);
            $input['departemen_id'] = $departemen_user->departemen_id;
            $input['pengajuan_signature'] = $departemen_user->team.' - '.$departemen->departemen;
        }
        
        $file_manager_perubahan_data = $this->file_manager_perubahan_data->create($input);
        \LogActivity::addToLog('Kode Formulir '.$input['kode_formulir'].' Berhasil Dibuat');
        VerifikasiDokumen::create([
            'id' => Str::uuid()->toString(),
            'kode_barcode' => $input['kode_formulir'],
            'link' => route('perubahan_data.create',['id' => $input['id']]),
            'status' => 'WAITING'
        ]);
        return redirect()->route('perubahan_data.create',['id' => $input['id']]);
    }

    public function create(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = $this->file_manager_perubahan_data_detail->where('file_manager_perubahan_data_id',$id)->get();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                // $btn.= '<a href='.route('perubahan_data.delete_perubahan_data_detail',['id' => $row->file_manager_perubahan_data_id, 'id_perubahan_data_detail' => $row->id]).' class="btn btn-danger btn-icon">
                                //             <i class="fa fa-trash"></i> Delete
                                //         </a>';
                                $btn.= '<button type="button" onclick="delete_formulir_perubahan(`'.$row->file_manager_perubahan_data_id.'`,`'.$row->id.'`)" class="btn btn-danger btn-icon">'.'<i class="fa fa-trash"></i> Delete'.'</button>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action','uraian_perubahan'])
                            ->make(true);
        }

        $departemen = array(
            'IT & Corsec',
            'HRGA',
            'Finance & Accounting',
            'Marketing',
            'Purchasing',
            'Produksi',
            'QC'
        );
        $data['file_manager_perubahan_data'] = $this->file_manager_perubahan_data->find($id);
        $data['departemens'] = $this->departemen->whereIn('departemen',$departemen)->get();
        
        return view('file_manager.perubahan_data.create',$data);
    }

    public function detail_form_simpan(Request $request, $id)
    {
        $file_manager_perubahan_data = $this->file_manager_perubahan_data->find($id);

        $departemen = $this->departemen->find($file_manager_perubahan_data->departemen_id);
        $file_manager_category = $this->file_manager_category->where('departemen_id',$file_manager_perubahan_data->departemen_id)->first();

        $input['halaman'] = $request->halaman;
        $input['revisi'] = $request->revisi;
        $input['kategori_file'] = $request->kategori_file;
        $input['uraian_perubahan'] = $request->uraian_perubahan;

        if (!File::isDirectory(public_path('berkas/'.$departemen->departemen.'/'.$input['kategori_file'].'/'.'Perubahan'))) {
            File::makeDirectory(public_path('berkas/'.$departemen->departemen.'/'.$input['kategori_file'].'/'.'Perubahan'),0777,true);
        }

        $file = $request->file('files');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('berkas/'.$departemen->departemen.'/'.$file_manager_category->kategori.'/'.'Perubahan'), $fileName);

        $explode_no_dokumen = explode('/',$request->no_dokumen);
        $file_manager_perubahan_data_detail = $this->file_manager_perubahan_data_detail->create([
            'id' => Str::uuid()->toString(),
            'file_manager_perubahan_data_id' => $id,
            'no_dokumen' => implode('.',$explode_no_dokumen),
            'halaman' => $request->halaman,
            'kategori_file' => $request->kategori_file,
            'revisi' => $request->revisi,
            'uraian_perubahan' => $request->uraian_perubahan,
            'files' => $fileName
        ]);

        if ($file_manager_perubahan_data_detail) {
            \LogActivity::addToLog('No. Dokumen '.implode('.',$explode_no_dokumen).' Berhasil Ditambah');
            return response()->json([
                'success' => true,
                'message_title' => 'Berhasil',
                'message_content' => 'No. Dokumen '.implode('.',$explode_no_dokumen).' Berhasil Ditambah'
            ]);
        }
    }

    public function simpan(Request $request, $id)
    {

        $file_manager_perubahan_data = $this->file_manager_perubahan_data->find($id);
        if (empty($file_manager_perubahan_data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan',
            ]);
        }

        $input['tanggal_formulir'] = $request->tanggal_formulir;

        $input['is_open'] = 'n';

        // dd($request->save_change);

        $file_manager_perubahan_data->update($input);
        if ($file_manager_perubahan_data) {
            return response()->json([
                'success' => true,
                'message_title' => 'Berhasil',
                'message_content' => 'Kode Formulir '.$file_manager_perubahan_data->kode_formulir.' Berhasil Disimpan. Silahkan tunggu akan diarahkan ke halaman selanjutnya.',
                'link' => route('perubahan_data')
            ]);
        }
    }

    // public function simpan(Request $request)
    // {
    //     $norut = $this->file_manager_perubahan_data->count();
    //     $input['id'] = Str::uuid()->toString();
    //     $input['kode_formulir'] = Carbon::now()->format('dmY').$norut+1;
    //     $input['tanggal_formulir'] = $request->tanggal_formulir;
    //     if (auth()->user()->nik == '0000000') {
    //         $input['departemen_id'] = $request->departemen_id;
    //         $input['pengajuan_signature'] = auth()->user()->name;
    //     }else{
    //         $departemen_user = $this->departemen_user->where('nik',auth()->user()->nik)->first();
    //         $departemen = $this->departemen->find($departemen_user->departemen_id);
    //         $input['departemen_id'] = $departemen_user->departemen_id;
    //         $input['pengajuan_signature'] = $departemen_user->team.' - '.$departemen->departemen;
    //     }
        
    //     foreach ($request->detail_formulir as $key => $value) {
    //         // $file = $request->file('files');
    //         // $fileName = $file->getClientOriginalName();
            
    //         if (auth()->user()->nik == '0000000') {
    //             $departemen = $this->departemen->find($request->departemen_id);
    //             $file_manager_category = $this->file_manager_category->where('departemen_id',$request->departemen_id)->first();
    //         }else{
    //             $departemen_user = $this->departemen_user->where('nik',auth()->user()->nik)->first();
    //             $departemen = $this->departemen->find($departemen_user->departemen_id);
    //             $file_manager_category = $this->file_manager_category->where('departemen_id',$departemen->id)->first();
    //         }

    //         // if (!File::isDirectory(public_path('berkas/'.$departemen->departemen.'/'.$file_manager_category->kategori.'/'.'Perubahan'))) {
    //         //     File::makeDirectory(public_path('berkas/'.$departemen->departemen.'/'.$file_manager_category->kategori.'/'.'Perubahan'),0777,true);
    //         // }
    //         if (!File::isDirectory(public_path('berkas/'.$departemen->departemen.'/'.$value['kategori_file'].'/'.'Perubahan'))) {
    //             File::makeDirectory(public_path('berkas/'.$departemen->departemen.'/'.$value['kategori_file'].'/'.'Perubahan'),0777,true);
    //         }

    //         $file = $value['files'];
    //         $fileName = $file->getClientOriginalName();
    //         $file->move(public_path('berkas/'.$departemen->departemen.'/'.$file_manager_category->kategori.'/'.'Perubahan'), $fileName);
    //         // dd($fileName);

    //         $explode_no_dokumen = explode('/',$value['no_dokumen']);
    //         // dd($explode_no_dokumen);
    //         // dd(implode('.',$explode_no_dokumen));

    //         // $input['detail_formulir'][] = $value;
    //         // $input['detail_formulir'][] = [
    //         //     'no_dokumen' => implode('.',$explode_no_dokumen),
    //         //     'halaman' => $value['halaman'],
    //         //     'revisi' => $value['revisi'],
    //         //     'uraian_perubahan' => $value['uraian_perubahan'],
    //         //     'files' => $fileName
    //         // ];

    //         $file_manager_perubahan_data_detail = $this->file_manager_perubahan_data_detail->create([
    //             'id' => Str::uuid()->toString(),
    //             'file_manager_perubahan_data_id' => $input['id'],
    //             'no_dokumen' => implode('.',$explode_no_dokumen),
    //             'halaman' => $value['halaman'],
    //             'kategori_file' => $value['kategori_file'],
    //             'revisi' => $value['revisi'],
    //             'uraian_perubahan' => $value['uraian_perubahan'],
    //             'files' => $fileName
    //         ]);
    //     }
        
    //     $file_manager_perubahan_data = $this->file_manager_perubahan_data->create($input);
    //     \LogActivity::addToLog('Kode Formulir '.$input['kode_formulir'].' Berhasil Dibuat');
    //     return redirect()->route('perubahan_data');
    // }

    public function detail($id)
    {
        $data['file_manager_perubahan_data'] = $this->file_manager_perubahan_data->find($id);
        if (empty($data['file_manager_perubahan_data'])) {
            return redirect()->back();
        }
        $data['file_manager_perubahan_data_details'] = $this->file_manager_perubahan_data_detail->where('file_manager_perubahan_data_id',$id)->get();
        return view('file_manager.perubahan_data.detail',$data);
    }

    public function cek_validasi($id)
    {
        $data['file_manager_perubahan_data'] = $this->file_manager_perubahan_data->find($id);
        if (empty($data['file_manager_perubahan_data'])) {
            return redirect()->back();
        }
        $data['file_manager_perubahan_data_details'] = $this->file_manager_perubahan_data_detail->where('file_manager_perubahan_data_id',$id)->get();
        // dd($data);
        return view('file_manager.perubahan_data.validasi',$data);
    }

    public function validasi_submit(Request $request, $id)
    {
        $file_manager_perubahan_data = $this->file_manager_perubahan_data->find($id);
        // $input['status'] = $request->validasi_document_control.'|'.Carbon::now()->format('Y-m-d');
        // dd($file_manager_perubahan_data->file_manager_perubahan_data_detail);
        
        $departemen_user = $this->departemen_user->where('nik',auth()->user()->nik)->first();
        if (empty($file_manager_perubahan_data->disetujui_signature)) {
            $input['disetujui_signature'] = $departemen_user->team.' - '.$departemen_user->nik;
            $message = 'Disetujui Document Center';
            $input['status'] = $request->validasi_document_control.'|'.Carbon::now()->format('Y-m-d').'|'.'|';
            \LogActivity::addToLog('Kode Formulir '.$file_manager_perubahan_data->kode_formulir.' '.$message.' '.$input['disetujui_signature']);
            // foreach ($file_manager_perubahan_data->file_manager_perubahan_data_detail as $key => $file_manager_perubahan_data_detail) {
            //     $from_file = public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.
            //                 '/'.$file_manager_perubahan_data_detail->kategori_file.'/'.'Perubahan'.'/'.$file_manager_perubahan_data_detail->files);
            //     $to_file = public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.
            //                 '/'.$file_manager_perubahan_data_detail->kategori_file.'/'.$file_manager_perubahan_data_detail->files);
            //     $files = rename($from_file,$to_file);
            // }
        }

        if (empty($file_manager_perubahan_data->represtative_signature)) {
            if ($departemen_user->nik == 1711952) {
                if ($request->validasi_management_repesentative == 'y') {
                    $input['represtative_signature'] = $departemen_user->team.' - '.$departemen_user->nik;
                    $message = 'Disetujui Management Repestative';
                    $explode_validasi_representative = explode('|',$file_manager_perubahan_data->status);
                    $input['status'] = $explode_validasi_representative[0].'|'.$explode_validasi_representative[1].'|'.$request->validasi_management_repesentative.'|'.Carbon::now()->format('Y-m-d');
                    VerifikasiDokumen::where('kode_barcode',$file_manager_perubahan_data->kode_formulir)->update([
                        'link' => route('rekap_pelatihan.rekap_pelatihan_detail',['id' => $file_manager_perubahan_data['id']]),
                        'status' => 'APPROVED'
                    ]);
                }else if($request->validasi_management_repesentative == 'n'){
                    $input['represtative_signature'] = null;
                    $message = 'Ditolak Management Representative';
                    $explode_validasi_representative = explode('|',$file_manager_perubahan_data->status);
                    $input['status'] = $explode_validasi_representative[0].'|'.$explode_validasi_representative[1].'|'.$request->validasi_management_repesentative.'|'.Carbon::now()->format('Y-m-d');
                    VerifikasiDokumen::where('kode_barcode',$file_manager_perubahan_data->kode_formulir)->update([
                        'link' => route('rekap_pelatihan.rekap_pelatihan_detail',['id' => $file_manager_perubahan_data['id']]),
                        'status' => 'REJECTED'
                    ]);
                }
            }
        }

        if (!empty($file_manager_perubahan_data->status)) {
            $explode_validasi = explode('|',$file_manager_perubahan_data->status);
            if ($explode_validasi[0] == 'y' || $explode_validasi[2] == 'y') {
                VerifikasiDokumen::where('kode_barcode',$file_manager_perubahan_data->kode_formulir)->update([
                    'link' => route('rekap_pelatihan.rekap_pelatihan_detail',['id' => $file_manager_perubahan_data['id']]),
                    'status' => 'APPROVED'
                ]);
                foreach ($file_manager_perubahan_data->file_manager_perubahan_data_detail as $key => $file_manager_perubahan_data_detail) {
                    // --fix coding--
                    $path_file_asli = public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.'/'.$file_manager_perubahan_data_detail->kategori_file.'/'.'Asli');
                    
                    if(!File::isDirectory($path_file_asli)){
                        File::makeDirectory($path_file_asli, 0777, true, true);
                    }

                    $from_file = public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.
                                '/'.$file_manager_perubahan_data_detail->kategori_file.'/'.'Perubahan'.'/'.$file_manager_perubahan_data_detail->files);
                    // $to_file = public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.
                    //             '/'.$file_manager_perubahan_data_detail->kategori_file.'/'.$file_manager_perubahan_data_detail->files);
                    $to_file = public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.
                                '/'.$file_manager_perubahan_data_detail->kategori_file.'/'.'Asli'.'/'.$file_manager_perubahan_data_detail->files);
                    
                    $files = rename($from_file,$to_file);

                    if ($file_manager_perubahan_data_detail->kategori_file == 'ITI') {
                        ImageWatermarker::input(public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.'/'.$file_manager_perubahan_data_detail->kategori_file.'/'.'Asli'.'/'.$file_manager_perubahan_data_detail->files))
                                        ->watermark(public_path('berkas/Terkendali-barcode.png'))
                                        ->output(public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.'/'.$file_manager_perubahan_data_detail->kategori_file.'/'.$file_manager_perubahan_data_detail->files))
                                        ->position(Position::BOTTOM_CENTER, -11.5, -2)
                                        // ->asBackground()
                                        // ->pageRange(3, 4)
                                        ->resolution(270) // 300 dpi
                                        ->save();
                    }elseif($file_manager_perubahan_data_detail->kategori_file != 'FR' && $file_manager_perubahan_data_detail->kategori_file != 'ITI'){
                        ImageWatermarker::input(public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.'/'.$file_manager_perubahan_data_detail->kategori_file.'/'.'Asli'.'/'.$file_manager_perubahan_data_detail->files))
                                        ->watermark(public_path('berkas/Terkendali-Rahasia-barcode.png'))
                                        ->output(public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.'/'.$file_manager_perubahan_data_detail->kategori_file.'/'.$file_manager_perubahan_data_detail->files))
                                        ->position(Position::BOTTOM_CENTER, -11.5, -2)
                                        // ->asBackground()
                                        // ->pageRange(3, 4)
                                        ->resolution(270) // 300 dpi
                                        ->save();
                    }


                    $file_manager_category = $this->file_manager_category->where('departemen_id',$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen_id)
                                            ->where('kategori',$file_manager_perubahan_data_detail->kategori_file)
                                            ->first();
                    $file_manager_list = $this->file_manager_list
                                                ->where('file_manager_category_id',$file_manager_category->id)
                                                ->where('no_dokumen',$file_manager_perubahan_data_detail->no_dokumen)
                                                ->update([
                                                    'files' => $file_manager_perubahan_data_detail->files
                                                ]);
                    // --end fix coding--
                    
                    // $link = public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.'/'.$file_manager_perubahan_data_detail->kategori_file.'/'.'Perubahan'.'/'.$file_manager_perubahan_data_detail->files);
                    // $load_pdf = PDF::loadFile(public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.'/'.$file_manager_perubahan_data_detail->kategori_file.'/'.'Perubahan'.'/'.$file_manager_perubahan_data_detail->files));
                    // $load_pdf->setWatermarkImage(public_path('logo/sima.png'));
                    // $load_pdf->save(public_path('file.pdf'));

                    // $file_manager_category->file_manager_list->where('no_dokumen',$file_manager_perubahan_data_detail->no_dokumen)->update([
                    //     'files' => $file_manager_perubahan_data_detail->files
                    // ]);

                    // dd($file_manager_category->file_manager_list->where('no_dokumen',$file_manager_perubahan_data_detail->no_dokumen)->first());
                }
            }else{
                VerifikasiDokumen::where('kode_barcode',$file_manager_perubahan_data->kode_formulir)->update([
                    'link' => route('rekap_pelatihan.rekap_pelatihan_detail',['id' => $file_manager_perubahan_data['id']]),
                    'status' => 'REJECTED'
                ]);
                foreach ($file_manager_perubahan_data->file_manager_perubahan_data_detail as $key => $file_manager_perubahan_data_detail) {
                    $from_file = public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.
                                '/'.$file_manager_perubahan_data_detail->kategori_file.'/'.'Perubahan'.'/'.$file_manager_perubahan_data_detail->files);
                    // dd($from_file);
                    if (File::exists($from_file)) {
                        File::delete($from_file);
                    }
                }
            }
        }

        // if (!empty($file_manager_perubahan_data->disetujui_signature) && !empty($file_manager_perubahan_data->represtative_signature)) {
        //     foreach ($file_manager_perubahan_data->file_manager_perubahan_data_detail as $key => $file_manager_perubahan_data_detail) {
        //         $from_file = public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.
        //                     '/'.$file_manager_perubahan_data_detail->kategori_file.'/'.'Perubahan'.'/'.$file_manager_perubahan_data_detail->files);
        //         $to_file = public_path('berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.
        //                     '/'.$file_manager_perubahan_data_detail->kategori_file.'/'.$file_manager_perubahan_data_detail->files);
        //         $files = rename($from_file,$to_file);
        //     }
        // }

        $file_manager_perubahan_data->update($input);
        if ($file_manager_perubahan_data) {
            return redirect()->back()->with('success', 'Dokumen Berhasil '.$message);
        }
        return redirect()->back()->with('error', 'Dokumen Tidak Berhasil Divalidasi');
    }

    public function edit($id)
    {
        $data['file_manager_perubahan_data'] = $this->file_manager_perubahan_data->find($id);
        if (empty($data['file_manager_perubahan_data'])) {
            return redirect()->back();
        }
        $departemen = array(
            'IT & Corsec',
            'HRGA',
            'Finance & Accounting',
            'Marketing',
            'Purchasing',
            'Produksi',
            'QC'
        );
        if (auth()->user()->nik == '0000000') {
            $data['departemens'] = $this->departemen->whereIn('departemen',$departemen)->get();
        }
        $data['file_manager_perubahan_data_details'] = $this->file_manager_perubahan_data_detail->where('file_manager_perubahan_data_id',$id)->get();
        return view('file_manager.perubahan_data.edit',$data);
    }

    public function update(Request $request, $id)
    {
        // $file_manager_perubahan_data = $this->file_manager_perubahan_data->find($id);
        // $file_manager_perubahan_data_details = $this->file_manager_perubahan_data_detail->where('file_manager_perubahan_data',$id)->get();
        foreach ($request->detail_formulir as $key => $value) {
            // $file = $request->file('files');
            // $fileName = $file->getClientOriginalName();
            
            if (auth()->user()->nik == '0000000') {
                $departemen = $this->departemen->find($request->departemen_id);
                $file_manager_category = $this->file_manager_category->where('departemen_id',$request->departemen_id)->first();

            }else{
                $departemen_user = $this->departemen_user->where('nik',auth()->user()->nik)->first();
                $departemen = $this->departemen->find($departemen_user->departemen_id);
                $file_manager_category = $this->file_manager_category->where('departemen_id',$departemen->id)->first();
            }

            if (!File::isDirectory(public_path('berkas/'.$departemen->departemen.'/'.$file_manager_category->kategori.'/'.'Perubahan'))) {
                File::makeDirectory(public_path('berkas/'.$departemen->departemen.'/'.$file_manager_category->kategori.'/'.'Perubahan'),0777,true);
            }

            if (!empty($value['files'])) {
                $file = $value['files'];
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('berkas/'.$departemen->departemen.'/'.$file_manager_category->kategori.'/'.'Perubahan'), $fileName);
                $explode_no_dokumen = explode('/',$value['no_dokumen']);
    
                // $file_manager_perubahan_data_detail = $this->file_manager_perubahan_data_detail->updateOrCreate([
                //     'file_manager_perubahan_data_id' => $id,
                //     'no_dokumen' => implode('.',$explode_no_dokumen),
                //     'halaman' => $value['halaman'],
                //     'revisi' => $value['revisi'],
                //     'uraian_perubahan' => $value['uraian_perubahan'],
                //     'files' => $fileName
                // ]);
                $file_manager_perubahan_data_detail = $this->file_manager_perubahan_data_detail->where('file_manager_perubahan_data_id',$id)->where('no_dokumen',implode('.',$explode_no_dokumen))->first();
                if (!empty($file_manager_perubahan_data_detail)) {
                    $file_manager_perubahan_data_detail->update([
                        'file_manager_perubahan_data_id' => $id,
                        'no_dokumen' => implode('.',$explode_no_dokumen),
                        'halaman' => $value['halaman'],
                        'revisi' => $value['revisi'],
                        'uraian_perubahan' => $value['uraian_perubahan'],
                        'files' => $fileName
                    ]);
                }else{
                    $file_manager_perubahan_data_detail = $this->file_manager_perubahan_data_detail->create([
                        'id' => Str::uuid()->toString(),
                        'file_manager_perubahan_data_id' => $id,
                        'no_dokumen' => implode('.',$explode_no_dokumen),
                        'halaman' => $value['halaman'],
                        'revisi' => $value['revisi'],
                        'uraian_perubahan' => $value['uraian_perubahan'],
                        'files' => $fileName
                    ]);
                }

            }

            $explode_no_dokumen = explode('/',$value['no_dokumen']);
            $file_manager_perubahan_data_detail = $this->file_manager_perubahan_data_detail
                                                        ->where('file_manager_perubahan_data_id',$id)
                                                        ->where('id',$value['id_file_perubahan_data_detail'])
                                                        // ->where('no_dokumen',implode('.',$explode_no_dokumen))
                                                        ->first();
            // dd($file_manager_perubahan_data_detail);
            if (!empty($file_manager_perubahan_data_detail)) {
                // dd($file_manager_perubahan_data_detail);
                $file_manager_perubahan_data_detail->delete();
                // $file_manager_perubahan_data_detail_new = $this->file_manager_perubahan_data_detail->where('id','!=',$value['id_file_perubahan_data_detail'])->delete();
                $file_manager_perubahan_data_detail->update([
                    'file_manager_perubahan_data_id' => $id,
                    'no_dokumen' => implode('.',$explode_no_dokumen),
                    'halaman' => $value['halaman'],
                    'revisi' => $value['revisi'],
                    'uraian_perubahan' => $value['uraian_perubahan'],
                ]);
            }else{
                $file_manager_perubahan_data_detail = $this->file_manager_perubahan_data_detail->create([
                    'id' => Str::uuid()->toString(),
                    'file_manager_perubahan_data_id' => $id,
                    'no_dokumen' => implode('.',$explode_no_dokumen),
                    'halaman' => $value['halaman'],
                    'revisi' => $value['revisi'],
                    'uraian_perubahan' => $value['uraian_perubahan'],
                ]);
            }

        }

        return redirect()->route('perubahan_data');
    }

    public function delete_perubahan_data_detail($id,$id_perubahan_data_detail)
    {
        // dd($id_perubahan_data_detail);
        $file_manager_perubahan_data_detail = $this->file_manager_perubahan_data_detail->where('id',$id_perubahan_data_detail)
                                                    ->where('file_manager_perubahan_data_id',$id)
                                                    ->first();
        if (empty($file_manager_perubahan_data_detail)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Data Tidak Ditemukan'
            ]);
        }
        $file_manager_perubahan_data_detail->delete();
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'No. Dokumen '.$file_manager_perubahan_data_detail->no_dokumen.' Berhasil Dihapus'
        ]);
    }

    public function cetak_dokumen($id)
    {
        $data['file_manager_perubahan_data'] = $this->file_manager_perubahan_data->find($id);
        $data['file_manager_perubahan_data_details'] = $this->file_manager_perubahan_data_detail->where('file_manager_perubahan_data_id',$id)
                                                        ->orderBy('created_at','asc')
                                                        ->get();
        
        // $pdf = PDF::loadView('file_manager.perubahan_data.cetak_dokumen',$data);
        // return $pdf->stream();
        return view('file_manager.perubahan_data.cetak_dokumen',$data);
    }

    public function download_report(Request $request)
    {
        $data['file_manager_perubahan_datas'] = $this->file_manager_perubahan_data->whereYear('created_at',$request->periode)->orderBy('tanggal_formulir','asc')->get();
        if (empty($data['file_manager_perubahan_datas'])) {
            return redirect()->back();
        }
        $data['periode'] = $request->periode;
        return view('file_manager.perubahan_data.download_rekap',$data);
    }

    public function cek_dokumen_validasi($id,$id_perubahan_data_detail)
    {
        $file_manager_perubahan_data_detail = $this->file_manager_perubahan_data_detail
                                                    ->where('file_manager_perubahan_data_id',$id)
                                                    ->where('id',$id_perubahan_data_detail)
                                                    ->first();
        // $file_manager_category = $this->file_manager_category->where('departemen_id',$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen_id)->first();
        $location_files = $file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen.'/'.
        $file_manager_perubahan_data_detail->kategori_file.'/Perubahan/'.$file_manager_perubahan_data_detail->files;
        
        // $location_files = asset('public/berkas/'.$file_manager_perubahan_data_detail->file_manager_perubahan_data->departemen->departemen);
        return response()->json([
            'files' => asset('public/berkas/'.$location_files)
        ]);
    }

    public function cek_verifikasi_dokumen(Request $request)
    {
        $cek_verifikasi_dokumen = $this->verifikasi_dokumen->where('kode_barcode',$request->no_dokumen)->first();
        if (empty($cek_verifikasi_dokumen)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_color' => 'danger',
                'message_content' => 'Data tidak ditemukan'
            ]);
        }

        if ($cek_verifikasi_dokumen->status == 'WAITING') {
            $message_title = 'Waiting';
            $message_color = 'warning';
            $status = 'sedang diverifikasi';
        }elseif($cek_verifikasi_dokumen->status == 'APPROVED') {
            $message_title = 'Success';
            $message_color = 'success';
            $status = 'sudah diverifikasi';
        }else{
            $message_title = 'Rejected';
            $message_color = 'danger';
            $status = 'ditolak';
        }
        
        return response()->json([
            'success' => true,
            'message_title' => $message_title,
            'message_color' => $message_color,
            'message_content' => 'No. Dokumen '.$cek_verifikasi_dokumen->kode_barcode.' '.$status
        ]);
    }
}
