<?php

namespace App\Http\Controllers;

use App\UserRoom;
use Illuminate\Http\Request;

use App\phong;
use App\khuktx;
use App\sinhvien;
use App\phieudangky;
use App\canboquanly;
use App\users;
use Illuminate\Support\Facades\Validator;

use DB;

use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CanboController extends Controller
{

    public function ql_phong(){
        $ttphong = phong::paginate(7);
        return view('pages.cbql_phong', ['ttphong' => $ttphong]);
    }
    public function addPhong(){
        $khu = khuktx::all();
        return view('pages.create-phong',compact('khu'));
    }
    public function storePhong(Request  $request){
        $validator = Validator::make($request->all(), [
            'id_khu' => 'required',
            'sophong' => 'required',
            'gioitinh' => 'required',
            'snmax' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $check = phong::where('id_khu',$request->id_khu)->where('sophong',$request->sophong)->first();
        if($check){
            return redirect()->back()->with('error', 'Phòng đã tồn tại');
        }
        $data = $request->all();
        $data['sncur'] = 0;
        phong::create($data);
        return redirect()->route('cbql_phong')->with('success', 'Tạo phòng mới thành công');
    }
    public function detailPhong($id){
        $phong = phong::with('user')->findOrFail($id);
        return view('pages.detail',compact('phong'));
    }

    public function delete_sutdent($id){
        $student =UserRoom::where('user_id',$id)->first();
        $phong = phong::find($student->phong_id);
        $phong->update([
            'sncur'=> $phong->sncur -1,
        ]);

        $student->update([
            'status'=> '0'
        ]);
      
        return redirect()->back()->with('success', 'Xóa thành công');
    }

    public function cbql_ttsv(){
        return view('pages.cbql_ttsv');
    }
    public function cbql_cpsv(){
        return view('pages.cbql_cpsv');
    }

    public function cbql_duyetdk(){
        $phieu = phieudangky::with('student','room')->where('status','wait')->get();
        return view('pages.cbql_duyetdk',compact('phieu'));
    }

    public function update(Request $request){
        $phieu = phieudangky::findOrFail($request->id);
        if($phieu){
            if($request->status == 'success'){
                $phieu->update($request->all());
                $data = [
                    'user_id' => $phieu->student_id,
                    'phong_id' => $phieu->room_id,
                    'start_date' => $phieu->start_date,
                    'end_date' => $phieu->end_date,
                    'thanhtoan' => 0,
                ];
                UserRoom::create($data);
                $phong = phong::find($phieu->room_id);
                $phong->update([
                    'sncur'=> $phong->sncur +1,
                ]);
            }else{
                $phieu->update($request->all());
            }
            return redirect()->back();
        }
    }

    public function cbql_thongke(){
        $list_nam = phieudangky::select('nam')->groupBy('nam')->get();
        $year = Date('Y');
        $id_khu = canboquanly::where('email',Auth::user()->email)->value('id_khu');
        $list_phong = phong::where('id_khu',$id_khu)->pluck('id');
        $max = phong::where('id_khu',$id_khu)->max('id');
        $count = phong::where('id_khu',$id_khu)->count();
        $nam = phong::where([
            ['id_khu',$id_khu],
            ['gioitinh','nam']
        ])->sum('snmax');
        $nu = phong::where([
            ['id_khu',$id_khu],
            ['gioitinh','nu']
        ])->sum('snmax');
        $nam_dkcur = phong::where([
            ['id_khu',$id_khu],
            ['gioitinh','nam']
        ])->sum('sncur');
        $nu_dkcur = phong::where([
            ['id_khu',$id_khu],
            ['gioitinh','nu']
        ])->sum('sncur');
        $total_student = phieudangky::where([
            ['nam',date('Y')],
            ['trangthaidk','!=','cancelled'],
            ['trangthaidk','!=','registered']
        ])->whereIn('id_phong',$list_phong)->count();
        $total_money = phieudangky::where([
            ['nam',date('Y')],
            ['trangthaidk','!=','cancelled'],
            ['trangthaidk','!=','registered']
        ])->whereIn('id_phong',$list_phong)->sum('lephi');

        return view('pages.cbql_thongke',['nam'=>$nam,'nu'=>$nu,'nam_dkcur'=>$nam_dkcur,'nu_dkcur'=>$nu_dkcur,'total_student'=>$total_student,'total_money'=>$total_money,'list_nam'=>$list_nam,'year'=>$year]);
    }
}