@extends('master')
@section('content')
    <a href="{{route('cbql_phong')}}">Back</a>
<h2>Danh sách chi tiết phòng</h2>
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Tên</th>
        <th scope="col">Thời hạn thuê</th>
        <th scope="col">Thanh toán</th>
        <th scope="col">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(count($phong->user) <=0)
            <tr>
                <th colspan="4" style="text-align: center">Chưa có sinh viên đăng ký</th>
            </tr>
        @endif
        @foreach($phong->user as $user)
            <tr>
                <th scope="row">{{$user->user_id}}</th>
                <td>{{$user->user[0]->name}}</td>
                <td>Từ {{$user->start_date}} đến {{$user->end_date}} </td>
                <td>
                    @if($user->thanhtoan)
                        Đã thanh toán
                    @else
                        Chưa thanh toán
                        <button class="btn-danger btn">Gửi mail thanh toán</button>
                    @endif
                </td>
                <td>
                    <form action="{{route('phong.delete_sutdent',$user->user_id)}}" method="post">
                        @csrf
                        <button>Xóa khỏi phòng</button>
                    </form>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
@endsection
