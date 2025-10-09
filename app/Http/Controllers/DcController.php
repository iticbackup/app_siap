<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use App\Models\DcCategory;
use App\Models\DcCategoryDepartemen;
use App\Models\DocumentControl;
use App\Models\Departemen;
use App\Models\DepartemenUser;
use App\Models\ListValidasiDibuat;
use App\Models\ListValidasiDiperiksa;
use App\Models\ListValidasiDisetujui;
use App\Models\User;
use \Carbon\Carbon;

use FilippoToso\PdfWatermarker\Support\Pdf;
use FilippoToso\PdfWatermarker\Facades\ImageWatermarker;
use FilippoToso\PdfWatermarker\Watermarks\ImageWatermark;
use FilippoToso\PdfWatermarker\PdfWatermarker;
use FilippoToso\PdfWatermarker\Facades\TextWatermarker;
use FilippoToso\PdfWatermarker\Support\Position;

use Telegram\Bot\Laravel\Facades\Telegram;

use setasign\Fpdi\Fpdi;

use DB;
use Validator;
use DataTables;
use File;
use DNS2D;

class DcController extends Controller
{
    function __construct(
        DocumentControl $document_control,
        DcCategory $dc_category,
        DcCategoryDepartemen $dc_category_departemen,
        Departemen $departemen,
        DepartemenUser $departemen_user,
        ListValidasiDibuat $listValidasiDibuat,
        ListValidasiDiperiksa $listValidasiDiperiksa,
        ListValidasiDisetujui $listValidasiDisetujui,
        User $user
    ){
        $this->document_control = $document_control;
        $this->dc_category = $dc_category;
        $this->dc_category_departemen = $dc_category_departemen;
        $this->departemen = $departemen;
        $this->departemen_user = $departemen_user;
        $this->listValidasiDibuat = $listValidasiDibuat;
        $this->listValidasiDiperiksa = $listValidasiDiperiksa;
        $this->listValidasiDisetujui = $listValidasiDisetujui;
        $this->user = $user;
    }

    public function index()
    {
        
    }

    public function category(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->dc_category->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('status', function($row){
                                switch ($row->status) {
                                    case 'Active':
                                        return '<span class="badge bg-success">Aktif</span>';
                                        break;
                                    case 'InActive':
                                        return '<span class="badge bg-danger">Non Aktif</span>';
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="button-items">';
                                $btn.= '<button type="button" onclick="edit(`'.$row->id.'`)" class="btn btn-warning btn-icon">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>';
                                $btn.= \Form::open(['method' => 'DELETE', 'route' => ['dc.category.destroy', $row->id], 'style' => 'display:inline']);
                                $btn.= '<button type="submit" class="btn btn-danger btn-icon">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>';
                                $btn.= \Form::close();
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action','status'])
                            ->make(true);
        }
        return view('dc.category.index');
    }

    public function category_store(Request $request)
    {
        $rules = [
            'dc_category' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'dc_category.required'  => 'Kategori wajib diisi.',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $input['id'] = Str::uuid()->toString();
            $input['dc_category'] = $request->dc_category;
            $input['status'] = $request->status;

            $simpan = $this->dc_category->create($input);
            if($simpan){
                $message_title="Berhasil !";
                $message_content="Dokumen Kontrol Kategori Berhasil Dibuat";
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

    public function category_detail($id)
    {
        $data = $this->dc_category->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Kategori dokumen kontrol tidak ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function category_update(Request $request)
    {
        $rules = [
            'dc_category' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'dc_category.required'  => 'Kategori wajib diisi.',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $data = $this->dc_category->find($request->edit_id);
            $data->dc_category = $request->dc_category;
            $data->status = $request->status;
            $data->update();
            if($data){
                $message_title="Berhasil !";
                $message_content="Kategori Dokumen Kontrol ".$data->dc_category." Berhasil Diupdate";
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

    public function category_destroy($id)
    {
        $data = $this->dc_category->find($id);

        if (empty($data)) {
            return redirect()->back()->with('error','Kategori dokumen kontrol tidak ditemukan');
        }
        $data->delete();

        return redirect()->back()->with('success','Kategori dokumen kontrol berhasil dihapus');
    }

    public function category_departemen($id, $category_id, $departemen_id)
    {

    }

    public function departemen()
    {
        $departemen = [
            'IT & Corsec',
            'HRGA',
            'Finance & Accounting',
            'Marketing',
            'Purchasing',
            'PPIC',
            'Produksi',
            'QC',
            'QHSE',
        ];

        $data['departemens'] = $this->departemen->whereIn('departemen',$departemen)->get();
        return view('dc.departemen.index',$data);
    }

    public function departemen_detail(Request $request,$id)
    {
        if ($request->ajax()) {
            $dataList = [];
            $datas = $this->dc_category_departemen->where('departemen_id',$id)->get();
            foreach ($datas as $key => $data) {
                $dataList[] = [
                    'id' => $data->id,
                    'dc_category_id' => $data->dc_category_id,
                    'departemen_id' => $data->departemen_id,
                    'dc_category_name' => $data->dc_category->dc_category,
                ];
            }
            return response()->json([
                'success' => true,
                'data' => $dataList
            ]);
        }

        $data['departemen'] = $this->departemen->find($id);
        
        if (empty($data['departemen'])) {
            return redirect()->back()->with('error','Dokumen Kontrol Departemen Tidak Ditemukan');
        }

        $data['dc_categories'] = $this->dc_category->where('status','Active')->orderBy('created_at','asc')->get();
        $data['listValidasiDisetujuis'] = $this->listValidasiDisetujui->where('status','Active')->get();
        $data['listValidasiDiperiksas'] = $this->listValidasiDiperiksa->where('status','Active')->get();
        $data['listValidasiDibuats'] = $this->listValidasiDibuat->where('departemen_id',$id)->where('status','Active')->get();
        // $data['dc_categories'] = $this->dc_category_departemen->where('departemen_id',$id)->get();
        // $data['dc_categories'] = $this->dc_category->where('status','Active')->orderBy('created_at','asc')->get();

        return view('dc.departemen.detail',$data);
    }

    public function departemen_detail_store(Request $request, $id)
    {
        $rules = [
            'dc_category_id' => 'required',
        ];

        $messages = [
            'dc_category_id.required'  => 'Kategori wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $input['id'] = Str::uuid()->toString();
            $input['dc_category_id'] = $request->dc_category_id;
            $input['departemen_id'] = $id;

            $simpan = $this->dc_category_departemen->create($input);
            
            if($simpan){
                $message_title="Berhasil !";
                $message_content="Kategori Berhasil Dibuat";
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

    public function departemen_category_document_control_simpan(Request $request, $id)
    {
        // $cekValidasiDisetujui = $this->listValidasiDisetujui->find($request->validasi_disetujui);
        // if (empty($cekValidasiDisetujui)) {
        //     return response()->json([
        //         'success' => false,
        //         'message_title' => 'Gagal',
        //         'message_content' => 'Validator Disetujui Tidak Ditemukan'
        //     ]);
        // }

        // $cekValidasiDiperiksa = $this->listValidasiDiperiksa->find($request->validasi_diperiksa);
        // if (empty($cekValidasiDiperiksa)) {
        //     return response()->json([
        //         'success' => false,
        //         'message_title' => 'Gagal',
        //         'message_content' => 'Validator Diperiksa Tidak Ditemukan'
        //     ]);
        // }

        // $cekValidasiDibuat = $this->listValidasiDibuat->find($request->validasi_dibuat);
        // if (empty($cekValidasiDibuat)) {
        //     return response()->json([
        //         'success' => false,
        //         'message_title' => 'Gagal',
        //         'message_content' => 'Validator Dibuat Tidak Ditemukan'
        //     ]);
        // }

        // $validasiDisetujui = 'Kode Validasi : '.$cekValidasiDisetujui->code."\n".
        //                     'Validasi Oleh : '.$cekValidasiDisetujui->name."\n".
        //                     'Nama Dokumen : '.$cekValidasiDisetujui->name."\n".
        //                     'Tanggal Validasi : '.Carbon::now()->isoFormat('dddd, D MMMM YYYY');

                            // dd($request->all());
                            // return DNS2D::getBarcodeHTML($validasiDisetujui,"QRCODE",6,6);

        $dc_category_departemen = $this->dc_category_departemen->find($request->modaldc_category_id);
        // dd($dc_category_departemen);
        // dd($dc_category_departemen->dc_category->dc_category, $dc_category_departemen->departemen->departemen);

        $listValidasiDibuat = $this->listValidasiDibuat->where('nik',auth()->user()->nik)->first();
        
        if (empty($listValidasiDibuat)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Nama Validator Dibuat Tidak Ditemukan'
            ]);
        }
        
        foreach ($request->documents as $key => $value) {
            $path_file_asli = public_path('berkas/'.$dc_category_departemen->departemen->departemen.'/'.$dc_category_departemen->dc_category->dc_category);
            
            if(!File::isDirectory($path_file_asli)){
                File::makeDirectory($path_file_asli, 0777, true, true);
            }

            if ($value['files']) {
                // Copy
                $fileDocument = $value['files'];
                $fileNameDocument = $value['no_dokumen'].' - '.$value['nama_dokumen'].' Rev '.$value['no_revisi'].'.'.$fileDocument->getClientOriginalExtension();
                $fileDocument->move(public_path('berkas/'.$dc_category_departemen->departemen->departemen.'/'.$dc_category_departemen->dc_category->dc_category.'/'.'Asli'), $fileNameDocument);
                // Asli
                // $fileDocumentAsli = $value['files'];
                // $fileNameDocumentAsli = $value['no_dokumen'].' - '.$value['nama_dokumen'].' Rev '.$value['no_revisi'].'.'.$fileDocumentAsli->getClientOriginalExtension();
                // $fileDocumentAsli->move(public_path('berkas/'.$dc_category_departemen->departemen->departemen.'/'.$dc_category_departemen->dc_category->dc_category.'/'.'Asli'), $fileNameDocument);
                // dd(public_path('berkas/'.$dc_category_departemen->departemen->departemen.'/'.$dc_category_departemen->dc_category->dc_category.'/'.'Asli'));
                // $fileDocument->move(public_path('berkas/validasi'), $fileNameDocument);
            }

            // $validasiDisetujui = 'Kode Validasi : '.$cekValidasiDisetujui->code."\n".
            //                     'Validasi Oleh : '.$cekValidasiDisetujui->name."\n".
            //                     'Nama Dokumen : '.$value['no_dokumen'].' - '.$value['nama_dokumen'].' - '.$value['no_revisi']."\n".
            //                     'Departemen : '.$cekValidasiDisetujui->departemen->departemen."\n".
            //                     'Tanggal Validasi : '.Carbon::now()->isoFormat('dddd, D MMMM YYYY');

            // $validasiDiperiksa = 'Kode Validasi : '.$cekValidasiDiperiksa->code."\n".
            //                     'Validasi Oleh : '.$cekValidasiDiperiksa->name."\n".
            //                     'Nama Dokumen : '.$value['no_dokumen'].' - '.$value['nama_dokumen'].' - '.$value['no_revisi']."\n".
            //                     'Departemen : Manajemen Representative'."\n".
            //                     'Tanggal Validasi : '.Carbon::now()->isoFormat('dddd, D MMMM YYYY');
            
            // $validasiDibuat = 'Kode Validasi : '.$cekValidasiDibuat->code."\n".
            //                     'Validasi Oleh : '.$cekValidasiDibuat->name."\n".
            //                     'Nama Dokumen : '.$value['no_dokumen'].' - '.$value['nama_dokumen'].' - '.$value['no_revisi']."\n".
            //                     'Departemen : '.$cekValidasiDibuat->departemen->departemen."\n".
            //                     'Tanggal Validasi : '.Carbon::now()->isoFormat('dddd, D MMMM YYYY');
            
            $validasiDibuat = 'Kode Validasi : '.$listValidasiDibuat->code."\n".
                                'Validasi Oleh : '.$listValidasiDibuat->name."\n".
                                'Nama Dokumen : '.$value['no_dokumen'].' - '.$value['nama_dokumen'].' - Rev '.$value['no_revisi']."\n".
                                'Departemen : '.$listValidasiDibuat->departemen->departemen."\n".
                                'Tanggal Validasi : '.Carbon::now()->isoFormat('dddd, D MMMM YYYY');

            // cover disetujui
            // $barcodeValidasiDisetujui = \Storage::disk('barcode')->put('barcode_validasi_disetujui.png',base64_decode(DNS2D::getBarcodePNG($validasiDisetujui, "QRCODE", 6,6)));
            // cover diperiksa
            // $barcodeValidasiDiperiksa = \Storage::disk('barcode')->put('barcode_validasi_diperiksa.png',base64_decode(DNS2D::getBarcodePNG($validasiDiperiksa, "QRCODE", 6,6)));
            // cover dibuat
            $barcodeValidasiDibuat = \Storage::disk('barcode')->put('barcode-validasi-dibuat-'.Str::slug($listValidasiDibuat->name).'.png',base64_decode(DNS2D::getBarcodePNG($validasiDibuat, "QRCODE", 6,6)));

            $pdf = new Fpdi();
            $page_count = $pdf->setSourceFile(public_path('berkas/'.$dc_category_departemen->departemen->departemen.'/'.$dc_category_departemen->dc_category->dc_category.'/'.'Asli'.'/'.$fileNameDocument));
            // $page_count = $pdf->setSourceFile(public_path('berkas/validasi'.'/'.$fileNameDocument));

            for ($i = 1; $i <= $page_count; $i++) {
                // Impor halaman saat ini
                $page_id = $pdf->importPage($i);
                $size = $pdf->getTemplateSize($page_id);
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($page_id);

                // Tambahkan watermark hanya pada halaman pertama
                if ($i === 1) {
                    // Atur posisi dan style watermark
                    // $pdf->SetFont('Arial', 'B', 40);
                    // $pdf->SetTextColor(255, 0, 0); // Warna merah
                    // $pdf->SetAlpha(0.2); // Transparansi

                    // Posisi watermark di tengah halaman
                    // $pdf->SetXY(($size['width'] / 2) - 50, ($size['height'] / 2));
                    $pdf->SetXY(($size['width'] / 2), ($size['height'] / 2));
                    // $pdf->Cell(0, 0, 'Hanya Halaman Utama', 0, 0, 'C');
                    // $pdf->Image(public_path('barcode/barcode_validasi_disetujui.png'), 49, 166.5, 19);
                    // $pdf->Image(public_path('barcode/barcode_validasi_diperiksa.png'), 98, 166.5, 19);
                    $pdf->Image(public_path('barcode/barcode-validasi-dibuat-'.Str::slug($listValidasiDibuat->name).'.png'), 145, 166.5, 19);
                    // $pdf->Cell(0, 0, public_path('barcode/barcode_validasi_disetujui.png'), 0, 0, 'C');

                    // $pdf->SetAlpha(1); // Reset transparansi
                }else{
                    $pdf->Image(public_path('berkas/Terkendali-Rahasia-Edit.png'), 50, 280, 120);
                }
            }

            // $pdf->Output('F',public_path('berkas/validasi'.'/'.$fileNameDocument));
            $pdf->Output('F',public_path('berkas/'.$dc_category_departemen->departemen->departemen.'/'.$dc_category_departemen->dc_category->dc_category.'/'.$fileNameDocument));

            $this->document_control->create([
                'id' => Str::uuid()->toString(),
                'dc_category_departemen_id' => $request->modaldc_category_id,
                'dc_code' => rand(1000,9999),
                'dc_title' => $value['nama_dokumen'],
                'dc_tanggal_terbit' => Carbon::now()->format('Y-m-d'),
                'dc_nomor_dokumen' => $value['no_dokumen'],
                'dc_nomor_revisi' => $value['no_revisi'],
                // 'dc_disetujui' => $request->validasi_disetujui,
                // 'dc_diperiksa' => $request->validasi_diperiksa,
                // 'dc_dibuat' => $request->validasi_dibuat,
                'dc_dibuat' => $listValidasiDibuat->nik.'|'.$listValidasiDibuat->name,
                'dc_files' => $fileNameDocument,
            ]);

            // $user = $this->user->select('telegram_chat_id')->where('nik','0000000')->first();
            // Telegram::sendMessage([
            //     'chat_id' => env('TELEGRAM_CHAT_ID'),
            //     'text' => 'No. Dokumen : '.$value['no_dokumen']."\n".
            //               'Nama Dokumen : '.$value['nama_dokumen']."\n".
            //               'Revisi : '.$value['no_revisi']."\n".
            //               'Validasi Dibuat : '.$listValidasiDibuat->name."\n".
            //               'Departemen : '.$listValidasiDibuat->departemen->departemen."\n".
            //               'Tanggal Upload : '.Carbon::now()->format('Y-m-d H:i:s')."\n".
            //               'Status : Dokumen ISO Berhasil Diupload'
            //     // 'text' => Carbon::now()->format('Y-m-d').' : '.$value['no_dokumen'].' - '.$value['nama_dokumen'].' Berhasil Diupload'
            // ]);

            // return response($pdf->Output('F',public_path('/berkas/validasi'.'/'.$fileNameDocument)), 200, [
            //     'Content-Type' => 'application/pdf',
            //     'Content-Disposition' => 'inline; filename="dokumen_watermark.pdf"',
            // ]);
        }
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil!',
            'message_content' => 'Dokumen Kontrol Berhasil Diupload',
            'dc_category_id' => $dc_category_departemen->dc_category_id
        ]);
    }

    public function departemen_detail_category_detail($id, $dc_category_id)
    {
        $dc_category_departemen = $this->dc_category_departemen->with([
                                                                    'dc_category'
                                                                ])
                                                                ->select(
                                                                    'id','dc_category_id',
                                                                    'departemen_id'
                                                                )
                                                                ->where('dc_category_id',$dc_category_id)
                                                                ->where('departemen_id',$id)
                                                                ->first();
                                                                // dd($id,$dc_category_id);
                                                                // dd($dc_category_departemen);
        if (empty($dc_category_departemen)) {
            return response()->json([
                'success' => false,
            ]);
        }

        $listData = [];

        $datas = $this->document_control->with('dc_category_departemen')
                                        ->whereHas('dc_category_departemen', function($query) use($id,$dc_category_id){
                                            return $query->where('departemen_id',$id)
                                                        ->where('dc_category_id',$dc_category_id);
                                        })
                                        ->get();
        
        foreach ($datas as $key => $data) {
            // $dataFile = public_path('berkas/validasi/'.$data->dc_files);
            $dataFile = public_path('berkas/'.$data->dc_category_departemen->departemen->departemen.'/'.$dc_category_departemen->dc_category->dc_category.'/'.$data->dc_files);
            $pathinfo = pathinfo($dataFile);
            // dd($data->dc_category_departemen->dc_category->dc_category, $data->dc_category_departemen->departemen->departemen);
            switch ($pathinfo['extension']) {
                case 'pdf':
                    $iconFile = 'far fa-file-pdf text-danger';
                    break;
                
                default:
                    $iconFile = 'far fa-file-alt text-success';
                    break;
            }
            $listData[] = [
                'id' => $data->id,
                'dc_category_departemen_id' => $data->dc_category_departemen_id,
                'dc_code' => $data->dc_code,
                'dc_title' => $data->dc_title,
                'dc_tanggal_terbit' => $data->dc_tanggal_terbit,
                'dc_nomor_dokumen' => $data->dc_nomor_dokumen,
                'dc_nomor_revisi' => $data->dc_nomor_revisi,
                'dc_disetujui' => $data->dc_disetujui,
                'dc_diperiksa' => $data->dc_diperiksa,
                'dc_dibuat' => $data->dc_dibuat,
                // 'dc_files' => asset('public/berkas/validasi/'.$data->dc_files),
                'dc_files' => asset('public/berkas/'.$data->dc_category_departemen->departemen->departemen.'/'.$dc_category_departemen->dc_category->dc_category.'/'.$data->dc_files),
                'created_at' => $data->created_at->isoFormat('LLL'),
                'updated_at' => $data->updated_at->isoFormat('LLL'),
                'icon_files' => $iconFile,
                'size_files' => number_format(filesize($dataFile)/1024/1024,2),
            ];
        }
        return response()->json([
            'success' => true,
            'data' => [
                'dc_category' => $dc_category_departemen,
                'dc_category_departemen_detail' => $listData
            ]
        ]);
    }

    public function departemen_detail_category_detail_delete($id,$dc_id)
    {
        $dc = $this->document_control->find($dc_id);
        
        if (empty($dc)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal!',
                'message_content' => 'Dokumen Kontrol Tidak Ditemukan'
            ]);
        }

        $path_file_asli = public_path('berkas/'.
                    $dc->dc_category_departemen->departemen->departemen.'/'.
                    $dc->dc_category_departemen->dc_category->dc_category.'/Asli/'.
                    $dc->dc_files);

        if(!File::isDirectory($path_file_asli)){
            File::delete($path_file_asli);
        }

        $path_file_validasi = public_path('berkas/'.
                    $dc->dc_category_departemen->departemen->departemen.'/'.
                    $dc->dc_category_departemen->dc_category->dc_category.'/'.
                    $dc->dc_files);

        if(!File::isDirectory($path_file_validasi)){
            File::delete($path_file_validasi);
        }

        // Telegram::sendMessage([
        //     'chat_id' => env('TELEGRAM_CHAT_ID'),
        //     'text' => 'No. Dokumen : '.$dc->dc_nomor_dokumen."\n".
        //                 'Nama Dokumen : '.$dc->dc_title."\n".
        //                 'Revisi : '.$dc->dc_nomor_revisi."\n".
        //                 'Tanggal Hapus : '.Carbon::now()->format('Y-m-d H:i:s')."\n".
        //                 'Status : Dokumen ISO Berhasil Dihapus'
        //     // 'text' => Carbon::now()->format('Y-m-d').' : '.$dc->dc_nomor_dokumen.' - '.$dc->dc_title.' Berhasil Dihapus.'
        // ]);

        $dc->delete();

        // $user = $this->user->select('telegram_chat_id')->where('nik','0000000')->first();

        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil!',
            'message_content' => 'Dokumen Kontrol Berhasil Dihapus',
            'dc_category_id' => $dc->dc_category_departemen->dc_category->id
        ]);
    }

    public function dataValidasi(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->document_control->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('dc_title', function($row){
                                return $row->dc_nomor_dokumen.' - '.$row->dc_title;
                            })
                            ->addColumn('departemen', function($row){
                                return $row->dc_category_departemen->departemen->departemen;
                            })
                            ->addColumn('dc_tanggal_terbit', function($row){
                                return Carbon::create($row->dc_tanggal_terbit)->isoFormat('dddd, D MMMM YYYY');
                            })
                            ->addColumn('status', function($row){
                                if (empty($row->dc_disetujui) || empty($row->dc_disetujui)) {
                                    return '<span class="badge bg-warning text-dark">Menunggu Validator Disetujui</span>'.
                                            '<span class="badge bg-warning text-dark">Menunggu Validator Diperiksa</span>'.
                                            '<span class="badge bg-success text-dark">'.explode('|',$row->dc_dibuat)[1].'</span>'
                                            ;
                                }elseif(empty($row->dc_disetujui)){
                                    return '<span class="badge bg-warning text-dark">Menunggu Validator Disetujui</span>'.
                                            '<span class="badge bg-success text-dark">'.explode('|',$row->dc_diperiksa)[1].'</span>'.
                                            '<span class="badge bg-success text-dark">'.explode('|',$row->dc_dibuat)[1].'</span>'
                                            ;
                                }elseif(empty($row->dc_diperiksa)){
                                    return '<span class="badge bg-success text-dark">'.explode('|',$row->dc_disetujui)[1].'</span>'.
                                            '<span class="badge bg-warning text-dark">Menunggu Validator Diperiksa</span>'.
                                            '<span class="badge bg-success text-dark">'.explode('|',$row->dc_dibuat)[1].'</span>'
                                            ;
                                }else{
                                    return '<span class="badge bg-success text-dark">Validasi Telah Disetujui</span>';
                                }
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="button-items">';
                                $btn .= '<button class="btn btn-success btn-sm text-dark" onclick="previewValidasi(`'.$row->id.'`)">Preview</button>';
                                $btn .= '<button class="btn btn-primary btn-sm">Validasi</button>';
                                $btn .= '</div>';

                                return $btn;
                            })
                            ->rawColumns(['action','status'])
                            ->make(true);
        }

        return view('dc.dataValidasi.index');
    }

    public function dataValidasiDetail($id)
    {
        $data = $this->document_control->find($id);

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal!',
                'message_content' => 'Validasi Dokumen Kontrol Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $data->id,
                'dc_code' => $data->dc_code,
                'dc_title' => $data->dc_title,
                'dc_tanggal_terbit' => $data->dc_tanggal_terbit,
                'dc_nomor_dokumen' => $data->dc_nomor_dokumen,
                'dc_nomor_revisi' => $data->dc_nomor_revisi,
                'dc_disetujui' => empty($data->dc_disetujui) ? '<span class="badge bg-warning text-dark">Menunggu Validator Disetujui</span>' : explode('|',$data->dc_disetujui)[1],
                'dc_diperiksa' => empty($data->dc_diperiksa) ? '<span class="badge bg-warning text-dark">Menunggu Validator Diperiksa</span>' : explode('|',$data->dc_diperiksa)[1],
                'dc_dibuat' => empty($data->dc_dibuat) ? '<span class="badge bg-warning text-dark">Menunggu Validator Dibuat</span>' : explode('|',$data->dc_dibuat)[1],
                'dc_files' => asset(
                    'public/berkas/'.
                    $data->dc_category_departemen->departemen->departemen.'/'.
                    $data->dc_category_departemen->dc_category->dc_category.'/'.
                    $data->dc_files
                ),
            ]
        ]);
    }
}
