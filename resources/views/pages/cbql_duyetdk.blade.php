@extends('master')
@section('content')
    <h3 style="">
         <i class="fa fa-arrow-circle-o-right"></i>
            Danh sách sinh viên đăng ký phòng        
    </h3>
    <table class="table table-bordered table-striped datatable" id="table_export">
        <tr>
            <th>ID sinh viên</th>
            <th>Họ tên</th>
            <th>Phòng</th>
            <th>Trạng thái đăng ký</th>
            <th>Thời gian bắt đầu ở</th>
            <th>Thời gian kết thúc</th>
            <th>Ngày đăng ký</th>
            <th>Thao tác</th>
        </tr>
        @if(count($phieu) > 0)
            @foreach($phieu as $p)
                <tr>
                    <td>{{$p->student->id}}</td>
                    <td>{{$p->student->name}}</td>
                    <td>{{$p->room->khuktx->tenkhu}} - {{$p->room->sophong}}</td>
                    <td>{{$p->status}}</td>
                    <td>{{$p->start_date}}</td>
                    <td>{{$p->end_date}}</td>
                    <td>{{$p->created_at}}</td>
                    <td style="display: flex">
                        <form action="{{route('phieu.update')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$p->id}}" name="id">
                            <input type="hidden" value="success" name="status">
                            <button class="btn-success btn">Chấp nhận</button>
                        </form>
                        <form action="{{route('phieu.update')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$p->id}}" name="id">
                            <input type="hidden" value="refuse" name="status">
                            <button class="btn-danger btn">Từ chối</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td style="text-align: center" colspan="8">Không có dữ liệu</td>
            </tr>
        @endif
    </table>
@endsection