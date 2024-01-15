@extends('main')
@section('header')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('') }}js/ag-grid-enterprise.min.noStyle.js"></script>
    <link rel="stylesheet" href="{{ asset('') }}css/ag-grid.min.css">
    <link rel="stylesheet" href="{{ asset('') }}css/ag-theme-balham.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"
        integrity="sha512-3z5bMAV+N1OaSH+65z+E0YCCEzU8fycphTBaOWkvunH9EtfahAlcJqAVN2evyg0m7ipaACKoVk6S9H2mEewJWA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')
    @include('menu.css')
    <div class="text-center">
        <H2>Menu</H2>
    </div>
    <div class="input row">
        <div class=" col-md-6">
            <input type="text" id="product_name" maxlength="50" class="form-control" placeholder="Tên món ">
        </div>
        <div class=" col-md-3">
            <input type="text" id="price" maxlength="10" class="form-control" placeholder="Giá tiền vnđ">

        </div>
        <div class=" col-md-3">
            <button class="btn btn-primary col-12" id="add_item"> Thêm vào Menu</button>

        </div>

    </div>
    <br>

    <div id="myGrid" class="ag-theme-balham" style="height: 70%;"></div>
    <div class="bottom_bar">
        <button class="btn btn-danger" id="btn_delete_row"> Xoá Món </button>
        <div class="pay_infor">
            <label class="text-dark"> Đã chọn <span class="font-weight-bold" id="total_selected">0</span>/<span
                    class="font-weight-bold" id="total_rows">0</span> Món </label>
        </div>
        <button id="btn_save" class="btn btn-success" style="display:none"> Lưu Lại </button>
    </div>

    @include('menu.js')
@endsection
