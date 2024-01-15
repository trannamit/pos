@extends('main')
@section('header')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('') }}js/ag-grid-enterprise.min.noStyle.js"></script>
    <link rel="stylesheet" href="{{ asset('') }}css/ag-grid.min.css">
    <link rel="stylesheet" href="{{ asset('') }}css/ag-theme-balham.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endsection

@section('content')
    @include('table.css')
    <div class="container-fluid ">
        <div class="row text-center d-flex align-items-center">
            <input type="text" id="table_name" maxlength="20" class="text-dark form-control col-md-6 col-12" style="font-size: 25px">
            <label class=" form-label col-md-5 col-11 text-dark" style="font-size: 30px"> Số bàn: <span id="table_number" class="font-weight-bold">0</span></label>
            <button class=" col 1 form-control btn-danger" id="btn_delete_table" >
                <i class="fas fa-trash" ></i>
            </button>
            
        </div>
        <br>
    </div>
    <div class="input">
        <select id="select_product" style="width: 70%;">
            <option></option>
        </select>
        <button class="btn btn-primary btn-sm" id="add_item" style="width: 25%"> Thêm </button>
    </div>
    <br>

    <div id="myGrid" class="ag-theme-balham" style="height: 80%;"></div>
    <div class="bottom_bar">
        <button class="btn btn-danger" id="btn_delete_row"> Xoá Món </button>
        <div class="pay_infor">
            <label class="text-dark"> Đã chọn <span class="font-weight-bold" id="total_selected">0</span>/<span class="font-weight-bold"id="total_rows">0</span> Món </label>
            <label class="text-danger font-weight-bold" id="total_price"> 0 đ </label>
        </div>
        <button id="btn_pay" class="btn btn-success"> Tính Tiền </button>
        <button id="btn_save" class="btn btn-success" style="display: none;"> Lưu Lại </button>
    </div>
    
    @include('table.js')
    
@endsection


