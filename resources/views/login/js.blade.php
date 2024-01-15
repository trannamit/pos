<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            dataType: 'json',
        });
        $('#btnLogin').click(function() {
            login()
        })

        function login() {
            $.ajax({
                url: '{{ asset('') }}' + 'login',
                data: {
                    username: $('#username').val(),
                    password: $('#password').val(),
                },
                success: function(res) {
                    console.log(res);
                    if (res.code == "SUCCESS") {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Xin chào ' + res.userName,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            location.href = '{{ asset('') }}';
                        }, 1500);
                    } else if (res.code == "ERROR") {
                        let mes = res.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: mes
                        })
                    }
                }
            })
        }
    })
</script>
