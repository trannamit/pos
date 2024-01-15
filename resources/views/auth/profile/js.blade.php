<script>
    $(document).ready(function() {
        $("title").text('{{ $title }}');

        $('#password_change').click(function() {
            if (this.checked) {
                $('.password_change').show(500);
            } else {
                $('.password_change').hide(500);
            }
        })

        $('#name_edit').click(function() {
            if (this.checked) {
                $('#name_edit_input').prop('disabled', false);
                $('.name_edit').show(500);
            } else {
                $('#name_edit_input').prop('disabled', true);
                $('.name_edit').hide(500);
            }
        })

        $('#update_name').click(function() {
            $.ajax({
                url: "{{ asset('') }}update_name",
                data: {
                    name: $('#name_edit_input').val(),
                },
                success: function(result) {
                    if (result.code == 'SUCCESS') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Đã cập nhật',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 1200);
                        return;
                    }
                    if (result.code == 'ERROR') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: result.message,
                        })
                        return;
                    }
                }
            })
        })

        $('#change_password').click(function() {
            let password_new = $('#password_new').val();
            let password_confirm = $('#password_confirm').val();
            if(password_new != password_confirm) {
                alert('Mật khẩu xác nhận không khớp!');
                return;
            }
            $.ajax({
                url: "{{ asset('') }}change_password",
                data: {
                    password: $('#password').val(),
                    password_new: password_new,
                },
                success: function(result) {
                    if (result.code == 'SUCCESS') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Đã cập nhật mật khẩu',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 1200);
                        return;
                    }
                    if (result.code == 'ERROR') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: result.message,
                        })
                        return;
                    }
                }
            })
        })

    })
</script>
