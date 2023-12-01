<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;
use App\Models\Departemen;
use App\Models\DepartemenUser;
use App\Models\FileManagerCategory;
use App\Models\FileManagerList;

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

class FileManagerController extends Controller
{
    protected $departemen;
    protected $file_manager_kategori;

    function __construct(
        Departemen $departemen,
        DepartemenUser $departemen_user,
        FileManagerCategory $file_manager_kategori,
        FileManagerList $file_manager_list
    )
    {
        $this->middleware('permission:filemanager-list', ['only' => ['index']]);
        $this->departemen = $departemen;
        $this->departemen_user = $departemen_user;
        $this->file_manager_kategori = $file_manager_kategori;
        $this->file_manager_list = $file_manager_list;
    }

    public function index(){
        $departemen = array(
            'IT & Corsec',
            'HRGA',
            'Finance & Accounting',
            'Marketing',
            'Purchasing',
            'PPIC',
            'Produksi',
            'QC',
            'QHSE',
        );
        // dd(auth()->user()->nik);
        if (auth()->user()->nik == '0000000') {
            $data['departemens'] = $this->departemen->whereIn('departemen',$departemen)->get();
        }else{
            // $data['departemen_user'] = $this->departemen_user->where('nik',auth()->user()->nik)->first();
            $data['departemen_users'] = $this->departemen_user->where('nik',auth()->user()->nik)->get();
            foreach ($data['departemen_users'] as $key => $departemen_user) {
                $data['departemen_id'][] = $departemen_user->departemen->id;
            }
            // dd($data['departemen_id']);
            // $data['departemens'] = $this->departemen->whereIn('departemen',$departemen)->where('id',$data['departemen_user']['departemen_id'])->get();
            $data['departemens'] = $this->departemen->whereIn('departemen',$departemen)
                                                    ->whereIn('id',$data['departemen_id'])
                                                    ->get();
            // dd($data['departemens']);
        }
        return view('file_manager.index',$data);
    }

    public function detail_departemen($id)
    {
        $data['departemen'] = $this->departemen->find($id);
        $data['file_manager_kategoris'] = $this->file_manager_kategori->where('departemen_id',$id)->get();

        return view('file_manager.departemen',$data);
    }

    public function file_manager_kategori($id)
    {
        $file_manager_kategori = $this->file_manager_kategori->where('departemen_id',$id)->get();
        
        return response()->json([
            'status' => true,
            'data' => $file_manager_kategori,
        ]);
    }

    public function file_manager_kategori_simpan(Request $request)
    {
        $rules = [
            'kategori_file' => 'required',
        ];

        $messages = [
            'kategori_file.required'  => 'Input Folder belum dibuat.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            if (auth()->user()->nik == '0000000') {
                $departemen = $this->departemen->find($request->departemen_id);
                $input['departemen_id'] = $request->departemen_id;
                $input['kategori'] = $request->kategori_file;
                if (!File::isDirectory(public_path('berkas/'.$departemen->departemen.'/'.$request->kategori_file))) {
                    File::makeDirectory(public_path('berkas/'.$departemen->departemen.'/'.$request->kategori_file),0777,true);
                }
            }else{
                // $departemen = $this->departemen->find($request->departemen_id);
                $departemen_user = $this->departemen_user->where('nik',auth()->user()->nik)->first();
                $input['departemen_id'] = $departemen_user->departemen->id;
                $input['kategori'] = $request->kategori_file;
                if (!File::isDirectory(public_path('berkas/'.$departemen_user->departemen->departemen.'/'.$request->kategori_file))) {
                    File::makeDirectory(public_path('berkas/'.$departemen_user->departemen->departemen.'/'.$request->kategori_file),0777,true);
                }
            }
            
            $file_manager_kategori_simpan = $this->file_manager_kategori->create($input);
            if($file_manager_kategori_simpan){
                $message_title="Berhasil !";
                $message_content="Folder ".$request->kategori_file." Berhasil Dibuat";
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

    public function file_manager_list($kategori_id)
    {
        $kategori = $this->file_manager_kategori->find($kategori_id);
        $data = $this->file_manager_list->where('file_manager_category_id',$kategori_id)->get();
        $live_date = Carbon::today()->format('Y-m-d');
        $start_date = Carbon::createFromDate(2023,11,01)->format('Y-m-d');
        $end_date = Carbon::createFromDate(2023,11,30)->format('Y-m-d');
        if ($live_date >= $start_date && $live_date <= $end_date) {
            $status_aktif = true;
            $status_message = 'Mulai tanggal '.Carbon::parse($start_date)->isoFormat('LL').' - '.Carbon::parse($end_date)->isoFormat('LL').' dibuka untuk pengumpulan file sesuai dengan jadwal. 
                                Jika lebih dari tanggal tersebut, secara otomatis tombol Upload File dan Delete akan dimatikan oleh sistem.';
        }else{
            $status_aktif = false;
            $status_message = null;
        }
        return response()->json([
            'success' => true,
            'kategori_id' => $kategori_id,
            'kategori' => $kategori->kategori,
            'data' => $data,
            'status_aktif' => $status_aktif,
            'status_message' => $status_message
        ]);
    }

    public function file_manager_list_upload_simpan(Request $request)
    {
        $rules = [
            'title' => 'required',
            'no_dokumen' => 'required',
            'files' => 'required|mimes:pdf',
        ];

        $messages = [
            'title.required'  => 'Nama File belum dibuat.',
            'no_dokumen.required'  => 'Nomor Dokumen belum dibuat.',
            'files.required'  => 'Upload File belum dibuat.',
            'files.mimes' => 'Upload File hanya berformat PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $input['file_manager_category_id'] = $request->file_manager_category_id;
            $input['no_dokumen'] = $request->no_dokumen;
            $input['title'] = $request->title;
            
            $file = $request->file('files');
            $fileName = $request->no_dokumen.' - '.$request->title.'.'.$file->getClientOriginalExtension();
            // // dd($fileName);
            $file_manager_kategori = $this->file_manager_kategori->with('departemen')->find($request->file_manager_category_id);
            // // dd($file_manager_kategori);
            $path_file_asli = public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.'Asli');
            if(!File::isDirectory($path_file_asli)){
                File::makeDirectory($path_file_asli, 0777, true, true);
            }

            if ($file_manager_kategori->kategori == 'FR') {
                $file->move(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori), $fileName);
            }else{
                $file->move(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.'Asli'), $fileName);
            }

            // $file->move(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.'Asli'), $fileName);
            // $file->move(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori), $fileName);
            
            // if ($file_manager_kategori->kategori != 'FR') {
            //     ImageWatermarker::input(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.$fileName))
            //                     // ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
            //                     ->watermark(public_path('berkas/Terkendali-Rahasia-barcode.png'))
            //                     ->output(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.$fileName))
            //                     ->position(Position::BOTTOM_CENTER, -11.5, -2)
            //                     // ->asBackground()
            //                     // ->pageRange(3, 4)
            //                     ->resolution(270) // 300 dpi
            //                     ->save();
            // }elseif($file_manager_kategori->kategori == 'ITI'){
            //     ImageWatermarker::input(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.$fileName))
            //                     // ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
            //                     ->watermark(public_path('berkas/Terkendali-barcode.png'))
            //                     ->output(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.$fileName))
            //                     ->position(Position::BOTTOM_CENTER, -11.5, -2)
            //                     // ->asBackground()
            //                     // ->pageRange(3, 4)
            //                     ->resolution(270) // 300 dpi
            //                     ->save();
            // }

            // $file_asli = $request->file('files');
            // $fileNameAsli = $request->no_dokumen.' - '.$request->title.'.'.$file_asli->getClientOriginalExtension();
            // $file_asli->move(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.'Asli'), $fileNameAsli);

            if ($file_manager_kategori->kategori == 'ITI') {
                ImageWatermarker::input(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.'Asli'.'/'.$fileName))
                                // ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
                                ->watermark(public_path('berkas/Terkendali-barcode.png'))
                                ->output(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.$fileName))
                                ->position(Position::BOTTOM_CENTER, -11.5, -2)
                                // ->asBackground()
                                // ->pageRange(3, 4)
                                ->resolution(270) // 300 dpi
                                ->save();
            }elseif($file_manager_kategori->kategori != 'FR' && $file_manager_kategori->kategori != 'ITI'){
                ImageWatermarker::input(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.'Asli'.'/'.$fileName))
                                // ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
                                ->watermark(public_path('berkas/Terkendali-Rahasia-barcode.png'))
                                ->output(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.$fileName))
                                ->position(Position::BOTTOM_CENTER, -11.5, -2)
                                // ->asBackground()
                                // ->pageRange(3, 4)
                                ->resolution(270) // 300 dpi
                                ->save();
            }
            // elseif($file_manager_kategori->kategori == 'FR'){
            //     $file->move(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori), $fileName);
            // }

            $input['files'] = $fileName;
            
            $file_manager_list = $this->file_manager_list->create($input);
            if ($file_manager_list) {
                $kategori_id=$request->file_manager_category_id;
                $message_title="Berhasil !";
                $message_content="Berkas ".$request->title." Berhasil Disimpan";
                $message_type="success";
                $message_succes = true;
            }
            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
                'kategori_id' => $kategori_id,
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

    public function file_manager_list_upload_fr_simpan(Request $request)
    {
        $rules = [
            'title_fr' => 'required',
            'no_dokumen_fr' => 'required',
            'files_fr' => 'required|mimes:pdf',
        ];

        $messages = [
            'title_fr.required'  => 'Nama File belum dibuat.',
            'no_dokumen_fr.required'  => 'Nomor Dokumen belum dibuat.',
            'files_fr.required'  => 'Upload File belum dibuat.',
            'files_fr.mimes' => 'Upload File hanya berformat PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $input['file_manager_category_id'] = $request->file_manager_category_id_fr;
            $input['no_dokumen'] = $request->no_dokumen_fr;
            $input['title'] = $request->title_fr;
            
            $file = $request->file('files_fr');
            $fileName = $request->no_dokumen_fr.' - '.$request->title_fr.'.'.$file->getClientOriginalExtension();
            // // dd($fileName);
            $file_manager_kategori = $this->file_manager_kategori->with('departemen')->find($request->file_manager_category_id_fr);
            // // dd($file_manager_kategori);
            $file->move(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori), $fileName);

            // if ($file_manager_kategori->kategori == 'ITI') {
            //     ImageWatermarker::input(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.$fileName))
            //                     // ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
            //                     ->watermark(public_path('berkas/Terkendali-barcode.png'))
            //                     ->output(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.$fileName))
            //                     ->position(Position::BOTTOM_CENTER, -11.5, -2)
            //                     // ->asBackground()
            //                     // ->pageRange(3, 4)
            //                     ->resolution(270) // 300 dpi
            //                     ->save();
            // }elseif($file_manager_kategori->kategori != 'FR' && $file_manager_kategori->kategori != 'ITI'){
            //     ImageWatermarker::input(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.$fileName))
            //                     // ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
            //                     ->watermark(public_path('berkas/Terkendali-Rahasia-barcode.png'))
            //                     ->output(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori.'/'.$fileName))
            //                     ->position(Position::BOTTOM_CENTER, -11.5, -2)
            //                     // ->asBackground()
            //                     // ->pageRange(3, 4)
            //                     ->resolution(270) // 300 dpi
            //                     ->save();
            // }

            $input['files'] = $fileName;
            
            $file_manager_list = $this->file_manager_list->create($input);
            if ($file_manager_list) {
                $kategori_id=$request->file_manager_category_id_fr;
                $message_title="Berhasil !";
                $message_content="Berkas ".$request->title_fr." Berhasil Disimpan";
                $message_type="success";
                $message_succes = true;
            }
            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
                'kategori_id' => $kategori_id,
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

    public function file_manager_list_preview($id)
    {
        $file_manager_list = $this->file_manager_list->with('file_manager_category')->find($id);
        // dd($file_manager_list);
        if (empty($file_manager_list)) {
            return response()->json([
                'success' => false,
                'message_content' => 'File tidak ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            // 'url' => public_path('berkas/'.$file_manager_list->file_manager_category->departemen->departemen.'/'.$file_manager_list->file_manager_category->kategori.'/'.$file_manager_list->files)
            'url' => asset('public/berkas/'.$file_manager_list->file_manager_category->departemen->departemen.'/'.$file_manager_list->file_manager_category->kategori.'/'.$file_manager_list->files)
        ]);
    }

    public function file_manager_list_edit($id)
    {
        $file_manager_list = $this->file_manager_list->with('file_manager_category')->find($id);
        if (empty($file_manager_list)) {
            return response()->json([
                'success' => false,
                'message_content' => 'File tidak ditemukan'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $file_manager_list
        ]);
    }

    public function file_manager_list_edit_update(Request $request, $id)
    {
        $rules = [
            'edit_title' => 'required',
            'edit_no_dokumen' => 'required',
            'edit_files' => 'required|mimes:pdf',
        ];

        $messages = [
            'edit_title.required'  => 'Nama File belum dibuat.',
            'edit_no_dokumen.required'  => 'Nomor Dokumen belum dibuat.',
            'edit_files.required'  => 'Upload File belum dibuat.',
            'edit_files.mimes' => 'Upload File hanya berformat PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            // $input['id'] = $request->edit_id;
            $file_manager_list = $this->file_manager_list->find($request->edit_id);
            $input['no_dokumen'] = $request->edit_no_dokumen;
            $input['title'] = $request->edit_title;
            
            $file = $request->file('edit_files');
            $fileName = $request->edit_no_dokumen.' - '.$request->edit_title.'.'.$file->getClientOriginalExtension();
            $file_manager_kategori = $this->file_manager_kategori->with('departemen')->find($request->edit_file_manager_category_id_fr);
            $file->move(public_path('berkas/'.$file_manager_kategori->departemen->departemen.'/'.$file_manager_kategori->kategori), $fileName);
            $input['files'] = $fileName;

            $file_manager_list->update($input);

            if ($file_manager_list) {
                $kategori_id=$request->edit_file_manager_category_id_fr;
                $message_title="Berhasil !";
                $message_content="Berkas ".$request->edit_title." Berhasil Diupdate";
                $message_type="success";
                $message_succes = true;
            }
            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
                'kategori_id' => $kategori_id,
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

    public function file_manager_list_download($id)
    {
        $file_manager_list = $this->file_manager_list->with('file_manager_category')->find($id);
        // dd($file_manager_list);
        if (empty($file_manager_list)) {
            return response()->json([
                'success' => false,
                'message_content' => 'File tidak ditemukan'
            ]);
        }
        return Response::download(public_path('berkas/'.$file_manager_list->file_manager_category->departemen->departemen.'/'.$file_manager_list->file_manager_category->kategori.'/'.$file_manager_list->files));
        // return response()->download(asset('public/berkas/'.$file_manager_list->file_manager_category->departemen->departemen.'/'.$file_manager_list->file_manager_category->kategori.'/'.$file_manager_list->files));
    }

    public function file_manager_list_delete($id)
    {
        $file_manager_list = $this->file_manager_list->with('file_manager_category')->find($id);
        if (empty($file_manager_list)) {
            return response()->json([
                'success' => false,
                'message_content' => 'File tidak ditemukan'
            ]);
        }

        // dd($file_manager_list);

        $file_manager_list->delete();
        File::delete(public_path('berkas/'.$file_manager_list->file_manager_category->departemen->departemen.'/'.$file_manager_list->file_manager_category->kategori.'/'.$file_manager_list->files));

        $message_title="Berhasil !";
        $message_content="No. Dokumen ".$file_manager_list->no_dokumen." ".$file_manager_list->title." Berhasil dihapus.";
        $message_type="success";
        $message_succes = true;
        $file_manager_category_id = $file_manager_list->file_manager_category_id;

        $array_message = array(
            'success' => $message_succes,
            'message_title' => $message_title,
            'message_content' => $message_content,
            'message_type' => $message_type,
            'file_manager_category_id' => $file_manager_category_id,
        );
        
        return response()->json($array_message);

        // File::delete(public_path('berkas/'.$file_manager_list->file_manager_category->departemen->departemen.'/'.$file_manager_list->file_manager_category->kategori.'/'.$file_manager_list->files));
        // dd(public_path('berkas/'.$file_manager_list->file_manager_category->departemen->departemen.'/'.$file_manager_list->file_manager_category->kategori.'/'.$file_manager_list->files));
    }
    
}
