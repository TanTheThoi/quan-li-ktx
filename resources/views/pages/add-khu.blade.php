@extends('master')
@section('content')
    <style>
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

    </style>
    <div class="form-container">
        <a href="{{ url()->previous() }}" class="btn btn-info">Quay lại</a>
        <h2>Thêm khu</h2>
        <form method="post" action="{{route('store-khu')}}">
            @csrf
            <div class="form-group">
                <label for="khu">Tên Khu:</label>
                <input type="text" id="khu" name="tenkhu" required>
            </div>
            <div class="form-group">
                <label for="giaTien">Giá Tiền:</label>
                <input type="number" id="giaTien" name="giaphong" required>
            </div>
            <div class="form-group">
                <button type="submit">Thêm</button>
            </div>
        </form>
    </div>
@endsection
