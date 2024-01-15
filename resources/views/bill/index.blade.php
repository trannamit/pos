@extends('main')
@section('header')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('') }}css/ag-grid.min.css">
    <link rel="stylesheet" href="{{ asset('') }}css/ag-theme-balham.min.css">
    <script src="{{ asset('') }}js/ag-grid-enterprise.min.noStyle.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"
        integrity="sha512-3z5bMAV+N1OaSH+65z+E0YCCEzU8fycphTBaOWkvunH9EtfahAlcJqAVN2evyg0m7ipaACKoVk6S9H2mEewJWA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')
    @include('bill.css')
    <div class="text-center">
        <H2> {{ $title }} </H2>
    </div>
    <div class="input row">
        <div class="col-md-4">
            <label class="form-label text-dark font-weight-bold"> Từ ngày </label>
            <input type='date' id="day_start" class="form-control" placeholder="dd-mm-yyyy">
        </div>
        <div class="col-md-4">
            <label class="form-label text-dark font-weight-bold"> Tới ngày </label>
            <input type='date' id="day_end" class="form-control" placeholder="dd-mm-yyyy">
        </div>
        <div class="col-md-4">
            <label class="form-label"> <br> </label>
            <button class="btn btn-success" id="btn_view" style="width: 100%;"> Xem danh sách </button>
        </div>



    </div>
    <br>

    <div id="myGrid" class="ag-theme-balham" style="height: 65%;"></div>
    <div class="bottom_bar">
        <div class="pay_infor">
            <label class="text-dark"> Tổng cộng <span class="font-weight-bold" id="total_rows"> 0 </span> bill
            </label>
            <label class="font-weight-bold"> Doanh thu <span class="text-danger" id="total_price"> 0đ</span></label>
        </div>
        <button id="btn_view_bill" class="btn btn-success" style="display:none"> Xem hoá đơn số <span id="btn_view_bill_number"></span> </button>
    </div>

    @include('bill.js')
@endsection
