<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

#=============================================AUTH======================================================================

Route::get('','PageController@index')->name('trangchu');
Route::get('login','AuthController@getLogin')->name('login');
Route::post('login','AuthController@postLogin');
Route::get('logout','AuthController@logout')->name('logout');
Route::get('register','AuthController@getRegister')->name('register');
Route::post('register','AuthController@postRegister');
Route::get('forgot','AuthController@getForgot')->name('forgot');
Route::post('forgot','AuthController@SendMail')->name('sendMail');
Route::post('changePassword','LoadController@changePassword');


#=======================================================================================================================

Route::middleware(['auth'])->group(function () {


    Route::middleware([\App\Http\Middleware\CheckStudent::class])->group(function () {
        Route::get('student_dkphong','StudentController@student_dkphong')->name('student_dkphong');
        Route::get('get_student_dkphong/{id}','LoadController@get_student_dkphong')->name('get_student_dkphong');
        Route::post('register_room','LoadController@register_room')->name('register_room');
        Route::get('student_chonphong/{id}','StudentController@student_chonphong')->name('student_chonphong');

        Route::get('student_xemdk','StudentController@student_xemdk')->name('student_xemdk');
        Route::post('checkout/{id}','StudentController@checkout')->name('checkout');
        Route::get('checkout/success','StudentController@success')->name('success');

        Route::get('student_ttcn','StudentController@student_ttcn')->name('student_ttcn');
        Route::get('student_chinhsua','LoadController@getStudent_chinhsua')->name('student_chinhsua');
        Route::post('student_chinhsua','LoadController@postStudent_chinhsua')->name('student_chinhsua');
        Route::post('student_suatt','LoadController@student_suatt')->name('student_suatt');

        Route::get('student_bancp','StudentController@student_bancp')->name('student_bancp');

        Route::get('student_cbql','StudentController@student_cbql')->name('student_cbql');

        Route::get('student_doimk','StudentController@student_doimk')->name('student_doimk');
    });

    Route::middleware([\App\Http\Middleware\CheckAdmin::class])->group(function () {
        Route::get('list','PageController@admin_list_cb')->name('admin_list_cb');
        Route::get('khu','PageController@listKhu')->name('list-khu');
        Route::get('add-khu','PageController@addKhu')->name('add-khu');
        Route::post('add-khu','PageController@storeKhu')->name('store-khu');
        Route::delete('delete-khu/{id}','PageController@deleteKhu')->name('delete-khu');
        Route::get('khu/{id}','PageController@findKhu')->name('find-khu');
        Route::put('update-khu/{id}','PageController@updateKhu')->name('update-khu');

        Route::get('info','PageController@admin_info_cb')->name('admin_info_cb');
        Route::post('info','LoadController@post_admin_info_cb');
        Route::get('details/{id}','LoadController@admin_details_cb')->name('admin_details_cb');

        Route::get('add','PageController@admin_add_cb')->name('admin_add_cb');
        Route::post('create','AuthController@admin_create_account');
        Route::post('update/{mscb}','LoadController@admin_update_cb')->name('admin_update_cb');
        Route::get('delete/{id}','LoadController@admin_delete_cb')->name('admin_delete_cb');

        Route::get('statics','PageController@admin_statics')->name('admin_statics');
        Route::post('statics','LoadController@post_admin_statics');
        Route::get('phong','CanboController@ql_phong')->name('cbql_phong');
        Route::get('phong/create','CanboController@addPhong')->name('phong.add');
        Route::post('phong/create','CanboController@storePhong')->name('phong.create');
        Route::get('phong/detail/{id}','CanboController@detailPhong')->name('phong.detail');
        Route::post('phong/delete/student/{id}','CanboController@delete_sutdent')->name('phong.delete_sutdent');

        Route::get('cbql_ttsv','CanboController@cbql_ttsv')->name('cbql_ttsv');
        Route::get('cbql_cpsv','CanboController@cbql_cpsv')->name('cbql_cpsv');
        Route::get('get_cbql_xoasv/{mssv}','LoadController@get_cbql_xoasv')->name('get_cbql_xoasv');


        Route::get('cbql_duyetdk','CanboController@cbql_duyetdk')->name('cbql_duyetdk');
        Route::post('phieu/update','CanboController@update')->name('phieu.update');


        Route::get('get_cbql_ttsv/{mssv}','LoadController@get_cbql_ttsv')->name('get_cbql_ttsv');
        Route::post('post_cbql_ttsv','LoadController@post_cbql_ttsv')->name('post_cbql_ttsv');

        Route::get('cbql_thongke','CanboController@cbql_thongke')->name('cbql_thongke');
        Route::post('post_cbql_thongke','LoadController@post_cbql_thongke')->name('post_cbql_thongke');

    });
});
