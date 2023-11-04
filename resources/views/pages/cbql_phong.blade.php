@extends('master')
@section('content')
<div class="list_phong">
	<a href="{{route('phong.add')}}" class="btn-success btn">Thêm phòng</a>
	<br>
	<br>
	<table class="table table-bordered table-striped datatable" id="table_export">
		<tr>
			<th>STT</th>
			<th>Số phòng</th>
			<th>Số người đk hiện tại</th>
			<th>Số người tối đa</th>
			<th>Giới tính</th>
			<th>Khu KTX</th>
			 <th>Xem</th>
		</tr>
		@foreach($ttphong as $key => $p)
		<tr>
			<td>{{$key + 1}}</td>
			<td>{{$p->sophong}}</td>
			<td>{{$p->sncur}}</td>
			<td>{{$p->snmax}}</td>
			<td>@if($p->gioitinh=="nam")
					{{"Nam"}}
				@else {{"Nữ"}}
				@endif
			</td>
			<td>{{$p->khuktx->tenkhu}}</td>
			<td>
				<a class="btn-success btn" href="{{route('phong.detail',$p->id)}}">Xem chi tiết</a>
				<form action="">
					<button class="btn btn-danger">Xóa</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
</div>
<div class="row">
	<div class="col-xs-6 col-left"></div>
	<div class="col-xs-6 col-right">
		<div class="dataTables_paginate paging_bootstrap">
			{!! $ttphong->links() !!}
		</div>
	</div>
</div>
@endsection
