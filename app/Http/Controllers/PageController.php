<?php

namespace App\Http\Controllers;

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
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        if(Auth::check()){
            view()->share('user',Auth::user());
            return view('pages.trangchu');
        }
    }
    public function listKhu(){
        $khu = khuktx::all();
        return view('pages.list-khu',compact('khu'));
    }
    public function addKhu(){
        return view('pages.add-khu');
    }
    public function storeKhu(Request $request){
        $validator = Validator::make($request->all(), [
            'tenkhu' => [
                'required',
                Rule::unique('khuktx'),
            ],
            'giaphong' => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $maxId = khuktx::max('id');
        $data = $request->all();
        $data['id'] = $maxId +1;
        khuktx::create($data);
        return redirect()->route('list-khu');
    }
    public function deleteKhu($id){
        $khu = khuktx::find($id);
        if($khu){
            $khu->delete();
            return redirect()->route('list-khu');
        }
        return redirect()->route('list-khu');
    }
    public function findKhu($id){
        $khu = khuktx::find($id);
        if($khu){
            return view('pages.edit-khu',compact('khu'));
        }
        return redirect()->route('list-khu');
    }
    public function updateKhu($id,Request $request){
        $validator = Validator::make($request->all(), [
            'tenkhu' => [
                'required',
                Rule::unique('khuktx')->ignore($request->id),
            ],
            'giaphong' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $khu = khuktx::find($id);


        if ($khu) {
            $khu->update($request->all());
            return redirect()->route('list-khu');
        }
    }
    public function admin_list_cb(){
        $manager = users::where('ltk','quanly')->get();
        return view('pages.admin_list_cb',['manager'=>$manager]);
    }
    public function admin_info_cb(){
        return view('pages.admin_info_cb');
    }
    public function admin_statics(){
        $list_nam = phieudangky::select('nam')->groupBy('nam')->get();
        $list_khu = khuktx::all();
        return view('pages.admin_statics',['list_nam'=>$list_nam,'list_khu'=>$list_khu]);
    }
    public function admin_add_cb(){
        $mscb = canboquanly::max('mscb');
        $mscb = $mscb + 1;
        return view('pages.admin_create_account',['mscb'=>$mscb]);
    }
}