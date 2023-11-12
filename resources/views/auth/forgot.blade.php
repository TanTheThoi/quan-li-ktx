@extends('dangnhap_master')
@section('content')
   <div class="form-control-lg">
       <form action="{{route('sendMail')}}" method="post">
           @csrf
           <label>Nhập Email</label>
           <input type="email" name="email" class="form-control">
           <br>
           <button class="btn btn-info">Gửi</button>
           <a class="btn-success btn" href="/login">Đăng Nhập</a>
       </form>
       @if(session('flag') && session('message'))
           <div class="alert alert-{{ session('flag') }}">
               {{ session('message') }}
           </div>
       @endif
   </div>
@endsection