@extends('master')
@section('content')
    <h3 style="">
        <i class="fa fa-arrow-circle-o-right"></i>
        Quản lý hồ sơ
    </h3>
    ﻿<div class="row">
        <div class="col-md-12">
            <!------CONTROL TABS START------>
            <ul class="nav nav-tabs bordered">
                <li class="active">
                    <a href="#list" data-toggle="tab"><i class="entypo-user"></i>
                        Quản lý hồ sơ
                    </a>
                </li>
            </ul>
            <!------CONTROL TABS END------>
            @if(Session::has('flag2'))
                <div class="error"><p>{{Session::get('message')}}</p></div>
            @endif
            <div class="tab-content">
                <!----EDITING FORM STARTS-->
                <div class="tab-pane box active" id="list" style="padding: 5px">
                    <div class="box-content">
                        <form method="get" class="form-horizontal form-groups-bordered validate" target="_top" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }} ">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tên</label>
                                <div class="col-sm-5">
                                    <label class=" control-label">{{Auth::user()->name}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">E-mail</label>
                                <div class="col-sm-5">
                                    <label class=" control-label">{{Auth::user()->email}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <button type="submit" class="btn btn-info">Cập nhật thông tin</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
