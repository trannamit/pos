<script>
    $(document).ready(function() {
        class DateRenderer {
            init(params) {
                this.eGui = document.createElement('span');
                var icon =
                    " <span > " + convertTimeStamp(params.value) + " </span> ";
                this.eGui.innerHTML =
                    `<span> ${icon} </span>`;
            }
            getGui() {
                return this.eGui;
            }
            refresh(params) {
                return false;
            }
        }
        class PriceRenderer {
            init(params) {
                this.eGui = document.createElement('span');
                var icon =
                    " <span > " + params.value.toLocaleString() + "đ </span> ";
                this.eGui.innerHTML =
                    `<span> ${icon} </span>`;
            }
            getGui() {
                return this.eGui;
            }
            refresh(params) {
                return false;
            }
        }
        $('title').text('{{ $title }}')
        const columnDefs = [{
                field: "id",
                headerName: 'Bill',
                autoHeight: true,
                pinned: 'left',
                maxWidth: 75,
                filter: 'agMultiColumnFilter',
                floatingFilter: true,
            },
            {
                field: "table_name",
                headerName: 'Tên bàn',
                minWidth: 190,

                filter: 'agMultiColumnFilter',
                floatingFilter: true,
            },
            {
                field: "table_number",
                headerName: 'Số bàn',
                minWidth: 90,
            },
            {
                field: "creater",
                headerName: 'NV Thanh Toán',
                minWidth: 120,

                filter: 'agMultiColumnFilter',
                floatingFilter: true,
            },
            {
                field: "created_at",
                headerName: 'Thời gian',
                minWidth: 190,
                cellRenderer: DateRenderer,
            },
            {
                field: "total_price",
                headerName: 'Tổng tiền',
                maxWidth: 110,
                cellRenderer: PriceRenderer,
                pinned: 'right',
                filter: 'agMultiColumnFilter',
                floatingFilter: true,
            },
        ];

        // specify the data


        // let the grid know which columns and what data to use
        const gridOptions = {
            columnDefs: columnDefs,
            defaultColDef: {
                flex: 1,
                sortable: true,
            },
            rowSelection: 'single',
            singleClickEdit: true,
            onRowSelected: onRowSelected,
        };

        // lookup the container we want the Grid to use
        const eGridDiv = document.querySelector('#myGrid');

        // create the grid passing in the div to use together with the columns & data we want to use
        var myGrid = new agGrid.Grid(eGridDiv, gridOptions).gridOptions;

        function onRowSelected(event) {
            if (event.node.selected == true) {
                $('#btn_view_bill').hide();
                $('#btn_view_bill_number').text(event.data.id);
                $('#btn_view_bill').show(200);
            }

        }

        function setDateToday() {
            var now = new Date();

            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);

            var today = now.getFullYear() + "-" + (month) + "-" + (day);

            $('#day_start').val(today);
            $('#day_end').val(today);
            showTable();
        }
        setDateToday()


        var day_start;
        var day_end;

        function getData() {
            $.ajax({
                url: '{{ asset('') }}get_data_bills',
                data: {
                    day_start: day_start,
                    day_end: day_end,
                },
                success: function(data) {
                    console.log(data);
                    myGrid.api.applyTransaction({
                        add: data
                    });

                    let total_price = 0;
                    data.forEach(function(bill) {
                        total_price += bill.total_price;
                    })
                    $('#total_rows').text(gridOptions.api.getDisplayedRowCount());
                    $('#total_price').text(total_price.toLocaleString() + 'đ');

                }

            })
        }

        function showTable() {
            gridOptions.api.setRowData([]);
            day_start = $('#day_start').val();
            day_end = $('#day_end').val();
            console.log(day_start, day_end);
            getData()
        }

        $('#btn_view').click(function() {
            showTable();
        })

        $('#btn_view_bill').click(function() {
            let billId = $('#btn_view_bill_number').text();
            window.open('{{ asset('') }}bill-' + billId, '_blank');
        })
    })
</script>
