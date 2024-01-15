<script>
    $(document).ready(function() {

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

        const columnDefs = [{
                field: "product_name",
                headerName: 'Tên Món',
                autoHeight: true,
                wrapText: true,
                headerCheckboxSelection: true,
                checkboxSelection: true,
                minWidth: 190,
                pinned: 'left',
            },
            {
                field: "note",
                headerName: 'Ghi chú',
                autoHeight: true,
                wrapText: true,
                minWidth: 190,
                editable: true,
            },
            {
                field: "price",
                headerName: 'Giá',
                maxWidth: 100,
                pinned: 'right',
                cellRenderer: PriceRenderer,
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
            rowSelection: 'multiple',
            rowClassRules: {
                'green-row': 'data.newItem == 1',
            },
            singleClickEdit: true,
            onCellValueChanged: cellValueChanged,
            onRowSelected: onRowSelected,
        };

        // lookup the container we want the Grid to use
        const eGridDiv = document.querySelector('#myGrid');

        // create the grid passing in the div to use together with the columns & data we want to use
        var myGrid = new agGrid.Grid(eGridDiv, gridOptions).gridOptions;;
        $('#select_product').select2({
            width: 'resolve'
        })

        function onRowSelected(event) {
            gridOptions.api.stopEditing();
        }
        var newItems = [];
        var updateItems = [];

        function cellValueChanged(event) {
            updateItems.push({
                item_id: event.data.item_id,
                product_id: event.data.product_id,
                note: event.newValue
            });
            activeSaveBtn();
        }

        function getMenuData() {
            $.ajax({
                url: '{{ asset('') }}' + 'menu_list',
                success: function(data) {
                    console.log(data);
                    $('#select_product').select2({
                        data: data,
                    })
                }

            })
        }
        getMenuData();

        function getTableData() {
            $.ajax({
                url: '{{ asset('') }}' + 'table_infor',
                data: {
                    id: '{{ $id }}',
                },
                success: function(data) {
                    console.log(data);
                    let tableData = [];
                    data.forEach(function(d) {
                        if (d.product_name != null && d.cashier_id == null) {
                            tableData.push(d);
                        }
                    })
                    $("#table_name").val(data[0].name_table);
                    $("#table_number").text(data[0].table_number);
                    $("title").text('Bàn số ' + data[0].table_number);
                    myGrid.api.applyTransaction({
                        add: tableData
                    });
                    if (gridOptions.api.getDisplayedRowCount() == 0) {
                        $('#btn_delete_table').show();
                    } else {
                        $('#btn_delete_table').hide();
                    }
                    $('#total_rows').text(gridOptions.api.getDisplayedRowCount());
                }

            })
        }
        getTableData();


        $('#select_product').on('select2:select', function(e) {
            newItems = [];
            let items = {
                price: e.params.data.value,
                product_name: e.params.data.text,
                note: 'Bình Thường ',
                newItem: 1,
                product_id: e.params.data.id
            };
            newItems.push(items);

        });

        function addNewItems() {
            myGrid.api.applyTransaction({
                add: newItems,
            });
        }

        function activeSaveBtn() {
            $('#btn_pay').hide();
            $('#btn_save').show();
        }

        $('#add_item').click(function() {
            addNewItems()
            activeSaveBtn()
        })
        var reason_delete;
        var itemSave = [];
        $('#btn_delete_row').click(function() {
            activeSaveBtn();
            let itemNew = [];
            const selectedRows = gridOptions.api.getSelectedRows();
            console.log(selectedRows);
            selectedRows.forEach(function(row) {

                if (row.newItem == 1) {
                    itemNew.push(row);
                } else {
                    itemSave.push({
                        id: row.item_id,
                        product_name: row.product_name,
                        table_id: {{ $id }},
                    });
                }
            })

            if (itemNew.length > 0) {
                for (var i = 0; i < itemNew.length; i++) {
                    gridOptions.api.applyTransaction({
                        remove: itemNew
                    });

                }


            }
            if (itemSave.length > 0) {
                Swal.fire({
                    title: 'Lý do xoá',
                    footer: 'Xoá các item đã lưu - vui lòng điền lý do (10 ký tự)',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Thực hiện',
                    showLoaderOnConfirm: true,
                    reverseButtons: true,
                    preConfirm: (reason) => {
                        reason_delete = reason;
                        if (reason_delete.length < 10) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Vui lòng điền lý do',
                                footer: 'Nội dung không dưới 10 ký tự'
                            })
                            return;
                        } else {
                            postDataDelete();
                        }

                    },
                })
            }

        })

        function postDataDelete() {
            $.ajax({
                url: '{{ asset('') }}' + 'delete_items',
                data: {
                    list: itemSave,
                    reason_delete: reason_delete,
                },
                success: function(result) {
                    if (result.code == 'SUCCESS') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Đã Xoá',
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
                            text: result.messages,
                        })
                        return;
                    }
                }
            })
        }

        $('#table_name').click(function() {
            activeSaveBtn();
        })

        $('#btn_save').click(function() {
            activeSaveBtn();
            let listUpdateItems = [];
            gridOptions.api.forEachNode(function(node) {
                if (node.data.newItem == 1) {
                    listUpdateItems.push({
                        product_id: node.data.product_id,
                        note: node.data.note
                    });
                }
            });
            updateItems.forEach(function(item) {
                if (item.item_id != undefined) {
                    listUpdateItems.push(item);
                }
            })
            $.ajax({
                url: '{{ asset('') }}' + 'save_update_item',
                data: {
                    table_id: {{ $id }},
                    table_name: $("#table_name").val(),
                    listUpdateItems: listUpdateItems,
                },
                success: function(result) {
                    if (result.code == 'SUCCESS') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Đã Lưu',
                            showConfirmButton: false,
                            timer: 1200
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                        return;
                    }
                    if (result.code == 'ERROR') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: result.messages,
                        })
                        return;
                    }


                }
            });

        })
        var total_price = 0;
        var rows = [];

        $('body').click(function() {
            rows = gridOptions.api.getSelectedRows();
            total_price = 0;
            rows.forEach(function(item) {
                total_price += Number(item.price);
            })
            if (gridOptions.api.getDisplayedRowCount() == 0) {
                $('#btn_delete_table').show();
            } else {
                $('#btn_delete_table').hide();
            }
            $('#total_price').text(total_price.toLocaleString() + 'đ');
            $('#total_rows').text(gridOptions.api.getDisplayedRowCount());
            $('#total_selected').text(rows.length);
        })

        $('#btn_pay').click(function() {
            if (rows.length == 0) {
                Swal.fire({
                    icon: 'error',
                    text: 'Vui lòng chọn tối thiểu 1 item để tính tiền!',
                })
                return;
            }
            Swal.fire({
                title: 'Tính tiền',
                html: 'Chắc chắn rằng các item đã chọn là chính xác?' +
                    '<br> Tính tiền <span class="font-weight-bold text-danger ">' +
                    rows.length +
                    '</span> item - Tổng <span class="font-weight-bold text-danger ">' +
                    total_price.toLocaleString() +
                    'đ </span>',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                reverseButtons: true,
                color: '#716add',
                backdrop: `
    rgba(0,0,123,0.4)
    url("/images/nyan-cat.gif")
    left top
    no-repeat
  `
            }).then((result) => {
                if (result.isConfirmed) {
                    payItems();
                } else {
                    return;
                }

            })
        })

        function payItems() {
            /* let pay_list =[];
            rows.forEach(function(row){
                pay_list.push({
                    price: row.price,
                    price: row.price,
                    price: row.price,
                    price: row.price,
                })
            }) */
            $.ajax({
                url: '{{ asset('') }}' + 'pay_items',
                data: {
                    pay_items: rows,
                    table_id: {{ $id }},
                },
                success: function(res) {
                    if (res.code == 'SUCCESS') {
                        Swal.fire({
                            title: 'Đã thanh toán',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#30d63e',
                            cancelButtonColor: '#3085d6',
                            cancelButtonText: 'Về trang chủ',
                            confirmButtonText: 'Xem hoá đơn',
                            reverseButtons: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.open('{{ asset('') }}bill-' + res.id, '_blank');
                                location.href = '{{ asset('') }}';
                            } else {
                                location.href = '{{ asset('') }}';
                            }
                        })
                        return;
                    }
                    if (res.code == 'ERROR') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: res.messages,
                        })
                        return;
                    }
                }
            })
        }


        $('#btn_delete_table').click(function() {
            if (gridOptions.api.getDisplayedRowCount() > 0) {
                alert('Bạn phải xoá hết tất cả item tại bàn trước khi xoá bàn này');
                return;
            }
            let text = "Bạn muốn xoá bàn này?";
            if (confirm(text) == false) {
                return;
            }
            $.ajax({
                url: '{{ asset('') }}delete_table',
                data: {
                    id: {{ $id }},
                },
                success: function(result) {
                    if (result.code == 'SUCCESS') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Đã xoá',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        setTimeout(function() {
                            location.href = '{{ asset('') }}';
                        }, 1000);
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
