@extends('main')
@section('header')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('content')
    @include('home.css')
    @include('home.js')
    <div class="container-fluid">
        <div class="cont_item row">
        </div>
        <br><br><br><br>
        <div class="bottom_bar">
            <div class="bar_infor">
                <label class="text-dark"> <span class="font-weight-bold" id="count_table"> -1 </span> Bàn chưa t.toán
                </label> <br>
                <label class="font-weight-bold"> Tổng <span class="text-danger" id="total_price"> 0đ</span></label>
            </div>
            <button id="btn_add" class="btn btn-lg text-right btn-success">
                Thêm bàn +
            </button>
        </div>
    </div>
@endsection
