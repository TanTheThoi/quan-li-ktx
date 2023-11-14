@extends('master')
@section('content')
	<h3 style="">
         	<i class="fa fa-arrow-circle-o-right"></i>
                Danh sách thành viên trong phòng           
    </h3>

	<div class="lsdk">
		<table class="table table-bordered table-striped datatable" id="table_export">
			<tr>
				<th>Tên</th>
				<th>Phòng</th>
				<th>Thời gian hợp đồng</th>
			</tr>
			@if(count($data))
			@foreach($data as $item)
			<tr>
				<td>{{$item->user[0]->name}}</td>
				<td>{{$item->room[0]->sophong}}</td>
				<td>Từ {{$item->start_date}} đến {{$item->end_date}}</td>
			</tr>
			@endforeach
			@else
			<tr><td colspan="3" style="text-align: center">Bạn chưa đăng ký phòng</td></tr>
			@endif
		</table>
	</div>
@endsection