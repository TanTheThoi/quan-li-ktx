<?php

namespace App\Http\Controllers;

use App\UserRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\phong;
use App\khuktx;
use App\sinhvien;
use App\phieudangky;
use App\canboquanly;
use App\users;
use DB;

use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    #----------Đăng_kí_phòng_ở------------------------------------------------------------------------------------------
    public function student_dkphong(){
        $ttkhu = khuktx::ALL();
        return view('pages.Student_dkphong', ['ttkhu' => $ttkhu]);
    }

    public function student_chonphong($id){
        $ttphong = phong::where('id_khu', '=', $id)->where('gioitinh',Auth::user()->gender)->paginate(7);
        return view('pages.Student_dkphong', ['ttphong' => $ttphong]);
    }

    #----------Xem_trạng thái đăng_kí-----------------------------------------------------------------------------------
    public function student_xemdk(){
        $data = phieudangky::with('room','student','getStatus')->where('student_id',Auth::user()->id)->get();
        foreach ($data as $item) {
            $item->monthsDifference = Carbon::parse($item->end_date)->diffInMonths(Carbon::parse($item->start_date));
            if($item->monthsDifference == 0){
                $item->monthsDifference =  $item->room->khuktx->giaphong;
            }else{
                $item->monthsDifference =  $item->monthsDifference *  $item->room->khuktx->giaphong;
            }
        }
        return view('pages.test',compact('data'));
    }

    public function checkout($id){
        $item = phieudangky::with('room','student','getStatus')->where('end_date','>=',date('Y-m-d'))->find($id);

        if(!$item->getStatus->thanhtoan) {
            $item->monthsDifference = Carbon::parse($item->end_date)->diffInMonths(Carbon::parse($item->start_date));
            if ($item->monthsDifference == 0) {
                $item->monthsDifference = $item->room->khuktx->giaphong;
            } else {
                $item->monthsDifference = $item->monthsDifference * $item->room->khuktx->giaphong;
            }
            $code_card = rand(00,9999);
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_TmnCode = "X4M8QF2P";
            $vnp_HashSecret = "NOUXBHBHJWHLIAKTJRARLMQTDNOGWADH";
            $vnp_TxnRef = $code_card;
            $vnp_OrderInfo = 'Thanh toan don hang test';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $item->monthsDifference * 100;
            $vnp_Locale = 'VN';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => 'http://127.0.0.1:8000/checkout/success',
                "vnp_TxnRef" => $item->id,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';

            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }

        }
    }
    public function success(Request $request){
        $data = phieudangky::with('room','student','getStatus')->find($request->vnp_TxnRef);
        $data->getStatus->update(['thanhtoan'=>1]);
        return redirect()->route('student_xemdk');
    }

    #----------Thông_tin_cá_nhân----------------------------------------------------------------------------------------
    public function student_ttcn(){
                $student = Auth::user();
        return view('pages.Student_ttcn',compact('student'));
    }

    public function student_bancp(){
        $id = Auth::user()->id;
        $info =  UserRoom::where('thanhtoan',1)->where('user_id',$id)->where('end_date','>=',date('Y-m-d'))->first();
        if($info){
             $data =  UserRoom::with('user','room')->where('thanhtoan',1)->where('phong_id',$info->phong_id)->where('end_date','>=',date('Y-m-d'))->get();
        }else{
            $data = null;
        }
        return view('pages.Student_bancp',compact('data'));
    }
    #----------Đổi mật khẩu---------------------------------------------------------------------------------------------
    public function student_doimk(){
        return view('pages.Student_doimk');
    }

    #----------Cán_bộ_quản_lý-------------------------------------------------------------------------------------------
    public function student_cbql(){
        $cbql = users::where('ltk', 'quanly')->get();
        return view('pages.Student_cbql', ['cbql' => $cbql]);
    }
}