<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\RekapPelatihanSeminar;
use App\Models\FileManagerPerubahanData;
use App\Models\Departemen;
use App\Models\DepartemenUser;
use \Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $rekap_pelatihan;

    public function __construct(
        FileManagerPerubahanData $file_manager_perubahan_data,
        Departemen $departemen,
        DepartemenUser $departemen_user,
        RekapPelatihanSeminar $rekap_pelatihan
    )
    {
        $this->rekap_pelatihan = $rekap_pelatihan;
        $this->file_manager_perubahan_data = $file_manager_perubahan_data;
        $this->departemen = $departemen;
        $this->departemen_user = $departemen_user;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $date = Carbon::now();
        // $reminders = Cache::remember('rekap_pelatihan', 60 * 12, function () {
        //     // return User::all();
        //     $date = Carbon::now();
        //     return $this->rekap_pelatihan->with('rekap_pelatihan_seminar_peserta')
        //                                 ->whereHas('rekap_pelatihan_seminar_peserta',function($query){
        //                                     $query->where('peserta',auth()->user()->name);
        //                                 })
        //                                 ->where('periode',$date->format('Y'))
        //                                 ->where('status','Plan')
        //                                 ->get();
        // });

        // dd($reminders);

        // $data['reminders'] = $this->rekap_pelatihan->with('rekap_pelatihan_seminar_peserta')
        //                                             ->whereHas('rekap_pelatihan_seminar_peserta',function($query){
        //                                                 $query->where('peserta',auth()->user()->name);
        //                                             })
        //                                             ->where('periode',$date->format('Y'))
        //                                             ->where('status','Plan')
        //                                             ->get();

        $data['reminders'] = Cache::remember('rekap_pelatihan', 1 * 12, function () {
            $date = Carbon::now();
            return $this->rekap_pelatihan->with('rekap_pelatihan_seminar_peserta')
                                        ->whereHas('rekap_pelatihan_seminar_peserta',function($query){
                                            $query->where('peserta',auth()->user()->name);
                                        })
                                        ->where('periode',$date->format('Y'))
                                        ->where('status','Plan')
                                        ->get();
        });
        // dd($data['reminders']);
        $data['event_rekaps'] = $this->rekap_pelatihan->where('periode',$date->format('Y'))->get();

        foreach ($data['event_rekaps'] as $key => $event_rekap) {
            $explode_tanggal = explode(',',$event_rekap->tanggal);
            $datelive = Carbon::now()->format('Y-m-d H:i');
            if (strtotime($datelive) < strtotime($explode_tanggal[0])) {
                $className = 'bg-primary';
            }elseif(strtotime($datelive) >= strtotime($explode_tanggal[0]) && strtotime($datelive) <= strtotime($explode_tanggal[1])){
                $className = 'bg-warning';
            }else{
                $className = 'bg-success';
            }
            $data['calendars'][] = [
                'title' => $event_rekap->tema,
                'start' => $explode_tanggal[0],
                'end' => $explode_tanggal[1],
                'className' => $className
            ];
        }
        
        if (auth()->user()->nik == 1207514 || auth()->user()->nik == 1711952 || auth()->user()->nik == 0000000) {
            $data['start_month'] = Carbon::now()->startOfYear()->format('m');
            $data['end_month'] = Carbon::now()->endOfYear()->format('m');
            for ($i=$data['start_month']; $i <= $data['end_month'] ; $i++) {
                $total_hasil_rekap_done = $this->rekap_pelatihan->where('status','Done')->whereMonth('created_at',$i)->whereYear('created_at',$date)->count();
                $data['total_hasil_rekap_done'][] = $total_hasil_rekap_done;
            }
        }

        // if (auth()->user()->nik == '0000000') {
        //     $data['file_manager_perubahan_datas'] = $this->file_manager_perubahan_data->get();
        // }else{
        //     $departemen_user = $this->departemen_user->select('id','departemen_id')->where('nik',auth()->user()->nik)->first();
        //     $data['file_manager_perubahan_datas'] = $this->file_manager_perubahan_data->where('departemen_id',$departemen_user->departemen_id)->get();
        // }
        // dd($data['file_manager_perubahan_datas']);

        if (auth()->user()->nik == '0000000') {
            $departemen = array(
                'IT & Corsec',
                'HRGA',
                'Finance & Accounting',
                'Marketing',
                'Purchasing',
                'PPIC',
                'Produksi',
                'QC'
            );
            $data['departemens'] = $this->departemen->whereIn('departemen',$departemen)->get();
        }else{
            $departemen_user = $this->departemen_user->select('id','departemen_id')->where('nik',auth()->user()->nik)->first();
            $data['departemens'] = $this->departemen->where('id',$departemen_user->departemen_id)->get();
        }
        
        $data['year'] = Carbon::now()->format('Y');
        $data['month'] = Carbon::now()->format('m');

        return view('home',$data);
    }
}
