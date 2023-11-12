@extends('master')
@section('content')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        th:nth-child(1),
        td:nth-child(1) {
            width: 10%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 40%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 30%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 20%;
        }
    </style>
    <a href="{{route('add-khu')}}" class="btn btn-success">Thêm Khu</a>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Tên Khu</th>
            <th>Giá Tiền (1 tháng)</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
            @foreach($khu as $item)
                <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->tenkhu}}</td>
                <td>{{$item->giaphong}}</td>
                <td style="display: flex">
                    <form action="{{route('delete-khu',$item->id)}}" method="post">
                        @method('delete')
                        @csrf
                        <button class="btn-danger btn">Xóa</button>
                    </form>
                    <a href="{{route('find-khu',$item->id)}}" class="btn-info btn">Sửa</a>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
