@extends('master')
@section('content')
    <style>
        /* Định dạng cơ bản cho biểu mẫu */
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background: #f4f4f4;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Định dạng cho nhãn */
        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Định dạng cho trường select */
        select, input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Định dạng cho nút gửi */
        input[type="submit"] {
            background: #333;
            color: #fff;
            border: 0;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Định dạng cho nút gửi khi rê chuột */
        input[type="submit"]:hover {
            background: #555;
        }

    </style>
    <form action="{{route('phong.create')}}" method="POST">
        @csrf
        <label for="khu">Tên Khu (Tòa):</label>
        <select name="id_khu" id="khu">
            @foreach($khu as $item)
                <option value="{{$item->id}}">{{$item->tenkhu}}</option>
            @endforeach
        </select>
        <br>

        <label for="phong">Tên Phòng:</label>
        <input type="text" name="sophong" id="phong">

        <br>

        <label for="so_luong_toi_da">Giới tính:</label>
        <select name="gioitinh" id="khu">
            <option value="nam">Nam</option>
            <option value="nu">Nữ</option>
        </select>
        <br>
        <label for="so_luong_toi_da">Số Lượng Tối Đa:</label>
        <input type="number" name="snmax" id="so_luong_toi_da">
        <br>
        <input type="submit" value="Gửi">
    </form>

@endsection
