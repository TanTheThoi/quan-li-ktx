@extends('dangnhap_master')
@section('title','Register')
@section('content')
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
	<form method="post" class="form_login"
        action="{{url('register')}}">
		<input type="hidden" name="_token" value="{{ csrf_token() }} ">
		<div class="form-group">
			<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Họ tên" maxlength="30">
			@error('name')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="form-group">
			<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" maxlength="50">
			@error('email')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="form-group">
			<select class="gender-select @error('gender') is-invalid @enderror" name="gender" style="width: 100%;">
				<option value="">Chọn giới tính</option>
				<option value="nam">Nam</option>
				<option value="nu">Nữ</option>
			</select>
			@error('gender')
				<div style="display: block" class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="form-group">
			<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Mật khẩu" required maxlength="30">
			@error('password')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="form-group">
			<input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Xác nhận mật khẩu" required maxlength="30">
			@error('password_confirmation')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="form-check">
			<button type="submit" class="btn btn-primary">Đăng ký</button>

		</div>
	</form>
	<script !src="">
		$(document).ready(function () {
			$('.gender-select').select2();
		});
	</script>
@endsection