@extends('master')
@section('content')
    <h3 style="">
        <i class="fa fa-arrow-circle-o-right"></i>
        Lịch sử đăng ký
    </h3>
        <div class="lsdk">
            <table class="table table-bordered table-striped datatable" id="table_export">
                <thead>
                <tr>
                    <th>Phòng đã đăng ký</th>
                    <th>Ngày bắt đầu ở</th>
                    <th>Ngày kết thúc</th>
                    <th>Trạng thái đăng ký</th>
                    <th>Hợp đồng( nếu có)</th>
                    <th>Thanh toán</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{$item->room->khuktx->tenkhu}} - {{$item->room->sophong}}</td>
                            <td>{{$item->start_date}}</td>
                            <td>{{$item->end_date}}</td>
                            @if($item->end_date < date('Y-m-d'))
                                <td>Quá thời hạn</td>
                            @else
                                <td>{{$item->status}}</td>
                            @endif
                            <td>{{$item->monthsDifference}}</td>
                            @if($item->end_date < date('Y-m-d'))
                                <td>Quá thời hạn</td>
                            @else
                                @if(isset($item->getStatus->thanhtoan) && $item->getStatus->thanhtoan && $item->getStatus->status == 1)
                                    <td>
                                        Đã thanh toán
                                    </td>
                                @else
                                   @if($item->status == 'wait')
                                       <td>Chưa được xác nhận</td>
                                    @elseif($item->getStatus->status == 0)
                                        <td>Ban da bi duoi khoi phong</td>
                                    @else
                                        <td>
                                            <form action="{{route('checkout',$item->id)}}" method="post">
                                                @csrf
                                                <input type="hidden" name="redirect">
                                                <button>Thanh toán</button>
                                            </form>
                                        </td>
                                   @endif
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
@endsection
