@extends('master')
@section('content')
    <h3 style="">
        <i class="fa fa-arrow-circle-o-right"></i>
        Lịch sử đăng ký
    </h3>
        <div class="lsdk">
            <table class="table table-bordered table-striped datatable" id="table_export">
                <thead>
                <tr>
                    <th>Phòng đã đăng ký</th>
                    <th>Ngày bắt đầu ở</th>
                    <th>Ngày kết thúc</th>
                    <th>Trạng thái đăng ký</th>
                    <th>Hợp đồng( nếu có)</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{$item->room->khuktx->tenkhu}} - {{$item->room->sophong}}</td>
                            <td>{{$item->start_date}}</td>
                            <td>{{$item->end_date}}</td>
                            <td>{{$item->status}}</td>
                            <td>{{$item->monthsDifference}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
@endsection
