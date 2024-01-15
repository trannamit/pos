@extends('main')
@section('header')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('content')
    @include('auth.profile.css')
    @include('auth.profile.js')
    <div class="container">
        <h2> Thông tin cá nhân </h2>
        <p> ID user: <strong>{{ auth()->user()->user_id }}</strong></p>
        <div class=" row">
            <div class="col-12">
                <div class="row d-flex justify-content-end">
                    <div class="d-flex justify-content-end align-items-center col-6">
                        <span class="form-label"> Đổi tên &nbsp;</span>
                        <input type="checkbox" id="name_edit" style="height:20px; width: 20px;" >
                    </div>
                </div>
                <label class="form-label"> Tên nhân viên </label>
                <input type="text" class="form-control" id='name_edit_input' value="{{ auth()->user()->name }}" placeholder="Tên NV" disabled>
                <br>
                <button class="btn btn-primary name_edit" style="display: none" id='update_name'> Cập nhật tên </button>
            </div>
        </div>
        <br><br><br><br>
        <div class=" row">
            <div class="col-12">
                <div class=" d-flex justify-content-end">
                    <div class="d-flex justify-content-end align-items-center col-6">
                        <span class="form-label"> Đổi mật khẩu &nbsp;</span>
                        <input type="checkbox" id="password_change" style="height:20px; width: 20px;">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div style="display: none" class="password_change">
                    <label class="form-label"> Đổi mật khẩu </label>
                    <input type="password" id="password" class="form-control" placeholder="Mật khẩu cũ">
                    <input type="password" id="password_new" class="form-control" placeholder="Mật khẩu mới">
                    <input type="password" id="password_confirm" class="form-control" placeholder="Nhập lại mật khẩu">
                    <br>
                    <button class="btn btn-primary" id="change_password"> Cập nhật mật khẩu </button>
                </div>

            </div>
        </div>

    </div>
@endsection
