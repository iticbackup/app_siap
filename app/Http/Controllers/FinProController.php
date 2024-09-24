<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinPro;
use App\Models\FinProDevice;

use DB;
use Validator;

class FinProController extends Controller
{
    function __construct(
        FinPro $fin_pro,
        FinProDevice $fin_pro_device
    )
    {
        $this->middleware('permission:fingerprint-list', ['only' => ['device']]);
        $this->middleware('permission:fingerprint-create', ['only' => ['device_simpan']]);
        $this->middleware('permission:fingerprint-update', ['only' => ['device_update']]);

        $this->fin_pro = $fin_pro;
        $this->fin_pro_device = $fin_pro_device;
    }

    public function device()
    {
        $data['device_fin_pros'] = DB::connection('fin_pro')->table('device')->get();
        $data['dev_ids'] = DB::connection('fin_pro')->table('dev_type')->get();
        // $data['device_fin_pros'] = DB::connection('fin_pro')->table('device')->get();
        // $data['dev_ids'] = DB::connection('fin_pro')->table('dev_type')->get();

        return view('fin_pro.device.index',$data);
    }

    public function device_simpan(Request $request)
    {
        $rules = [
            'sn' => 'required|unique:fin_pro.device,sn',
            'activation_code' => 'required|unique:fin_pro.device,activation_code',
            'device_name' => 'required',
            'dev_id' => 'required',
            'ip_address' => 'required|unique:fin_pro.device,ip_address',
            'ethernet_port' => 'required',
            'layar' => 'required',
        ];

        $messages = [
            'sn.required'  => 'Serial Number wajib diisi.',
            'sn.unique'  => 'Serial Number tidak boleh sama.',
            'activation_code.required'  => 'Kode Aktivasi wajib diisi.',
            'activation_code.unique'  => 'Kode Aktivasi tidak boleh sama.',
            'device_name.required'  => 'Nama Device wajib diisi.',
            'dev_id.required'  => 'Dev ID wajib diisi.',
            'ip_address.required'  => 'IP Address wajib diisi.',
            'ip_address.unique'  => 'IP Address tidak boleh sama.',
            'ethernet_port.required'  => 'Port wajib diisi.',
            'layar.required'  => 'Layar wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            
            $input['sn'] = $request->sn;
            $input['activation_code'] = $request->activation_code;
            $input['device_name'] = $request->device_name;
            $input['dev_id'] = $this->fin_pro_device->max('dev_id')+1;
            $input['comm_type'] = $request->comm_type;
            $input['ip_address'] = $request->ip_address;
            $input['id_type'] = explode('|',$request->dev_id)[0];
            $input['dev_type'] = explode('|',$request->dev_id)[1];
            $input['comm_key'] = 0;
            $input['ethernet_port'] = $request->ethernet_port;
            $input['layar'] = $request->layar;
            $input['alg_ver'] = 10;
            $input['use_realtime'] = 0;
            $input['group_realtime'] = 0;
            $input['ATTLOGStamp'] = 0;
            $input['OPERLOGStamp'] = 0;
            $input['ATTPHOTOStamp'] = 0;
            $input['id_server_use'] = '-1';
            
            $device = $this->fin_pro_device->create($input);
            
            if ($device) {
                $message_title="Berhasil !";
                $message_content="Device Berhasil Dibuat";
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

    public function get_device()
    {
        $IP  = "192.168.1.85";
        $Key = "0";

        $Connect = fsockopen($IP, "5005", $errno, $errstr, 1);

        if ($Connect) {
            $soap_request = "<GetAttLog>
                <ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey>
                <Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg>
            </GetAttLog>";

            $newLine = "\r\n";
            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($Connect, "Content-Type: text/xml".$newLine);
            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
            fputs($Connect, $soap_request.$newLine);
            $buffer = "";
            while($Response = fgets($Connect, 1024)) {
                $buffer = $buffer.$Response;
            }
        }else echo "Koneksi Gagal";

        $buffer = Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
        $buffer = explode("\r\n",$buffer);

        for ($a=0; $a<count($buffer); $a++) {
        $data=Parse_Data($buffer[$a],"<Row>","</Row>");

        $export[$a]['pin'] = Parse_Data($data,"<PIN>","</PIN>");
        $export[$a]['waktu'] = Parse_Data($data,"<DateTime>","</DateTime>");
        $export[$a]['status'] = Parse_Data($data,"<Status>","</Status>");
        }

        echo '<pre>';
        echo json_encode($export);
    }

    public function Parse_Data($data,$p1,$p2)
    {
        $data = " ".$data;
        $hasil = "";
        $awal = strpos($data,$p1);
        if ($awal != "") {
        $akhir = strpos(strstr($data,$p1),$p2);
        if ($akhir != ""){
            $hasil=substr($data,$awal+strlen($p1),$akhir-strlen($p1));
        }
        }
        return $hasil;
    }

    public function device_detail($dev_id)
    {
        $device = $this->fin_pro_device->with('fin_pro_device_type')->where('dev_id',$dev_id)->first();
        
        if (empty($device)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Device tidak ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $device
        ]);
    }

    public function device_update(Request $request)
    {
        $rules = [
            'edit_sn' => 'required',
            'edit_activation_code' => 'required',
            'edit_device_name' => 'required',
            'edit_dev_id' => 'required',
            'edit_ip_address' => 'required',
            'edit_ethernet_port' => 'required',
            'edit_layar' => 'required',
        ];

        $messages = [
            'edit_sn.required'  => 'Serial Number wajib diisi.',
            // 'edit_sn.unique'  => 'Serial Number tidak boleh sama.',
            'edit_activation_code.required'  => 'Kode Aktivasi wajib diisi.',
            // 'edit_activation_code.unique'  => 'Kode Aktivasi tidak boleh sama.',
            'edit_device_name.required'  => 'Nama Device wajib diisi.',
            'edit_dev_id.required'  => 'Dev ID wajib diisi.',
            'edit_ip_address.required'  => 'IP Address wajib diisi.',
            // 'edit_ip_address.unique'  => 'IP Address tidak boleh sama.',
            'edit_ethernet_port.required'  => 'Port wajib diisi.',
            'edit_layar.required'  => 'Layar wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            
            $input['sn'] = $request->edit_sn;
            $input['activation_code'] = $request->edit_activation_code;
            $input['device_name'] = $request->edit_device_name;
            $input['dev_id'] = $request->edit_dev_id;
            $input['comm_type'] = $request->edit_comm_type;
            $input['ip_address'] = $request->edit_ip_address;
            $input['id_type'] = explode('|',$request->edit_device_id)[0];
            $input['dev_type'] = explode('|',$request->edit_device_id)[1];
            $input['comm_key'] = 0;
            $input['ethernet_port'] = $request->edit_ethernet_port;
            $input['layar'] = $request->edit_layar;
            $input['alg_ver'] = 10;
            $input['use_realtime'] = 0;
            $input['group_realtime'] = 0;
            $input['ATTLOGStamp'] = 0;
            $input['OPERLOGStamp'] = 0;
            $input['ATTPHOTOStamp'] = 0;
            $input['id_server_use'] = '-1';
            
            $device = $this->fin_pro_device->where('dev_id',$request->edit_dev_id)->update($input);
            
            if ($device) {
                $message_title="Berhasil !";
                $message_content="Device SN ".$input['sn']." Berhasil Update";
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

}
