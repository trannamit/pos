<script>
    function action(response) {
        if (response.code == 'success') {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 1000
            })
            app.getRowSetting()
        } else {
            alert(response.message);
        }
    }
    var app = new Vue({
        el: "#app",
        data: {
            data: 'no data',
        },
        mounted() {
            this.getRowSetting();

        },
        methods: {
            getRowSetting() {
                axios
                    .post('{{ asset('get_settings') }}')
                    .then(response => (this.data = response))
            },
            saveSetting() {
                axios
                    .post('{{ asset('post_settings') }}', this.data.data)
                    .then(response => (action(response.data)), )
            },

        },
        computed: {


        }
    });
</script>
