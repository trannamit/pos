@extends($extends)
@section('header')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:ital,wght@1,900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Pacifico&family=Paytone+One&family=Roboto:ital,wght@1,900&display=swap"
        rel="stylesheet">
@endsection
@section($section)
    @include('infor.css')

    <div id="app">
        <img class="img-fluid" onerror="this.src='/public/images/banner.jpg'"
            src="{{ !empty($data['banner']['value']) ? $data['banner']['value'] : '/' }}" alt="Banner GenZ Muiltea">

        <div class="page_body col-12">
            <div class="page_body_title row">
                <H2> Menu hôm nay nhé! </H2>
            </div>
            <div class="menu_list" >
                
            </div>
        </div>
        <div class="infor">
            <p>
                {!! !empty($data['infor']['value']) ? $data['infor']['value'] : '' !!}
            </p>
        </div>
        @if (empty(auth()->user()))
            <div class="btn_login">
                <a href="/login" class="btn btn-outline-secondary"><i class="fas fa-sign-in-alt"></i></a>
            </div>
        @endif

        <div class="button_infor">
            <a class='btn facebook'target="_blank" href="{{ !empty($data['fb_link']) ? $data['fb_link']['value'] : '' }}">
                <i class="fab fa-facebook"></i> </a>
            <a class='btn call' target="_blank" href="{{ !empty($data['call_link']) ? $data['call_link']['value'] : '' }}">
                <i class="fas fa-phone-alt"></i> </a>
            <a class='btn address' target="_blank" href="{{ !empty($data['add_link']) ? $data['add_link']['value'] : '' }}">
                <i class="fas fa-map-marker-alt"></i> </a>
        </div>
    </div>
    @include('infor.js')
@endsection
