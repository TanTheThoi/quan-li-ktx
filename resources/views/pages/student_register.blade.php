@extends('master')
@section('content')
    <style>
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

    </style>
    <div class="container-content" style="padding: 30px;">
        <a class="btn-success btn" style="font-size: 18px" href="javascript:history.back()">Quay lại</a>
        @if (session('success'))
            <div class="alert alert-success">
                {{ __(session('success')) }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ __(session('error')) }}
            </div>
        @endif
        <div class="card" style="margin-top: 20px">
            <h2>Thông tin phòng</h2>
            <form action="{{route('register_room')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="roomName">Tên phòng:</label>
                    <input type="hidden" value="{{$room->id}}" name="room_id">
                    <input type="text" id="roomName"  value="{{$room->khuktx->tenkhu}} - {{$room->sophong}}" readonly>
                </div>
                <div class="form-group">
                    <label for="buildingName">Tên tòa:</label>
                    <input type="text" id="buildingName"    value=" {{$room->khuktx->tenkhu}}" readonly>
                </div>
                <div class="form-group">
                    <label for="monthlyPrice">Giá tiền mỗi tháng:</label>
                    <input type="number" id="monthlyPrice"  value="{{$room->khuktx->giaphong}}"readonly>
                </div>
                <div class="form-group">
                    <label for="startDate">Ngày bắt đầu:</label>
                    <input type="date" id="startDate" name="start_date" required value="{{ old('startDate') }}">
                    @error('startDate')
                    <div style="color: red" class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="endDate">Ngày kết thúc:</label>
                    <input type="date" id="endDate" name="end_date" value="{{old('endDate')}}" required>
                    @error('endDate')
                    <div style="color: red;" class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <div id="#total">Tổng tiền là: <span id="total"></span></div>
                </div>
                <button type="submit">Đăng ký phòng</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $( document ).ready(function() {
        var startDateInput = $("#startDate");
        var endDateInput = $("#endDate");

        startDateInput.on("change", updateTotal);
        endDateInput.on("change", updateTotal);

        function updateTotal() {
            var startDate = new Date(startDateInput.val());
            var endDate = new Date(endDateInput.val());
            var pricePerMonth = {{$room->khuktx->giaphong}};
            var now = new Date(); // Thời gian hiện tại
            if (!isNaN(startDate) && !isNaN(endDate) && startDate <= endDate && startDate >= now) {
                var timeDiff = endDate - startDate;
                var days = Math.ceil(timeDiff / (1000 * 3600 * 24));
                var months = Math.floor(days / 30);
                if(months == 0){
                    $('#total').text(pricePerMonth+ " VNĐ");
                }else{
                    var total = months * pricePerMonth;
                    $('#total').text(total+ " VNĐ");
                }
            } else {
            }
        }
        });

    </script>

@endsection
