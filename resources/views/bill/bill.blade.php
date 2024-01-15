<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="{{ asset('') }}js/custom.js"></script>
    <script src="{{ asset('') }}vendor/jquery/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <br>
        <br>
        <script>
            $(document).ready(function() {
                let t = '{{ $created_at }}';
                t = convertTimeStamp(t);
                $('#at').text(t)
            })
        </script>
        <h1> Hoá đơn bán hàng </h1>
        <label class=""> Mã Hoá đơn <strong>{{ $id }}</strong> </label><br>
        <label class=""> NV Thanh toán <strong>{{ $creater }}</strong> </label><br>
        <label class=""> Bàn số <strong>{{ $table_number }}</strong> <span> - Thanh toán
                <strong>{{ $total_item_inBill }}</strong>/<strong>{{ $total_item_inTable }}</strong> món </span>
        </label><br>
        <label class=""> Thời gian <strong id="at"> </strong> </label><br>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên SP</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $d->product_name }}</td>
                            <td>{{ $d->total_item }}</td>
                            <td>{{ number_format($d->price, 0, '', '.') }} đ</td>
                            <td>{{ number_format($d->total_price_bill, 0, '', '.') }} đ</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr>
        <div class="text-right">
            <label class="font-weight-bold "> Tổng cộng <span
                    class="text-danger">{{ number_format($total_price, 0, '', '.') }} đ</span> </label>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->

    <script src="{{ asset('') }}vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('') }}vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
