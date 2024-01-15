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
        class ActiveRenderer {
            init(params) {
                this.eGui = document.createElement('span');
                var icon = params.value === 'Active' ?
                    " <span style='background-color:green; color:white;padding: 5px; border-radius:15px'> &nbsp Active &nbsp </span> " :
                    " <span style='background-color:gray;color:white;padding: 5px;border-radius:15px'> &nbspDisable&nbsp </span> ";
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
        $('title').text('Quản lý Menu')
        const columnDefs = [{
                field: "product_name",
                headerName: 'Tên Món',
                autoHeight: true,
                wrapText: true,
                headerCheckboxSelection: true,
                checkboxSelection: true,
                editable: true,
            },
            {
                field: "price",
                headerName: 'Giá',
                editable: true,
                cellRenderer: PriceRenderer,
            },
            {
                field: "active",
                headerName: 'T.Thái',
                editable: true,
                pinned: 'right',
                maxWidth: 100,
                cellRenderer: ActiveRenderer,
                cellEditor: 'agSelectCellEditor',
                cellEditorParams: {
                    values: ['Active', 'Disable'],
                },
            },
        ];

        // specify the data


        // let the grid know which columns and what data to use
        const gridOptions = {
            columnDefs: columnDefs,
            defaultColDef: {
                flex: 1,
                filter: 'agMultiColumnFilter',
                floatingFilter: true,
            },
            rowSelection: 'multiple',
            rowClassRules: {
                'green-row': 'data.id == undefined',
            },
            singleClickEdit: true,
            onCellValueChanged: cellValueChanged,
            onRowSelected: onRowSelected,

        };

        // lookup the container we want the Grid to use
        const eGridDiv = document.querySelector('#myGrid');

        // create the grid passing in the div to use together with the columns & data we want to use
        var myGrid = new agGrid.Grid(eGridDiv, gridOptions).gridOptions;

        function onRowSelected(event) {
            gridOptions.api.stopEditing();
        }
        var listUpdateItems = [];

        function cellValueChanged(event) {
            console.log(event.data);
            listUpdateItems = pushOrReplace(listUpdateItems, event.data);
            $('#btn_save').show(500);
        }
        $('#price').number(true, 0, ',', '.');
        getData();

        function getData() {
            $.ajax({
                url: '{{ asset('') }}all_menu',
                success: function(data) {
                    console.log(data);
                    myGrid.api.applyTransaction({
                        add: data
                    });

                    $('#total_rows').text(gridOptions.api.getDisplayedRowCount());
                }

            })
        }

        $('body').click(function() {
            rows = gridOptions.api.getSelectedRows();
            $('#total_selected').text(rows.length);
        })

        $('#btn_save').click(function() {
            gridOptions.api.stopEditing();
        })

        $('#add_item').click(function() {

            if ($('#product_name').val() == '' || $('#price').val() == '') {
                alert('Cần điền đủ "Tên món" và "Giá tiền"')
                return;
            }
            let items = {
                price: $('#price').val(),
                product_name: $('#product_name').val(),
                active: 'Active',
            };
            myGrid.api.applyTransaction({
                add: [items],
            });
            listUpdateItems = pushOrReplace(listUpdateItems, items);

            $('#btn_save').show(500);
        })

        function pushOrReplace(mainList, item) {
            let t = 0;
            mainList.forEach(function(node) {
                if (node.product_name == item.product_name) {
                    node = item;
                    t++;
                    return mainList;
                }
            })
            if (t == 0) {
                mainList.push(item);
            }
            return mainList;
        }

        $('#test').click(function() {
            console.log(listUpdateItems);
        })
        $('#btn_save').click(function() {
            if (listUpdateItems.length == 0) {
                alert('Vui chưa có thông tin thay đổi')
                return;
            }
            console.log(listUpdateItems);
            $.ajax({
                url: '{{ asset('') }}save_update_menu',
                data: {
                    listUpdateItems: listUpdateItems,
                },
                success: function(result) {
                    if (result.code == 'SUCCESS') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Đã lưu',
                            showConfirmButton: false,
                            timer: 1000
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
            })
        })
        var itemSave = [];
        $('#btn_delete_row').click(function() {
            let itemNew = [];
            itemSave = [];
            const selectedRows = gridOptions.api.getSelectedRows();
            selectedRows.forEach(function(row) {

                if (row.id == undefined) {
                    itemNew.push(row);
                } else {
                    itemSave.push({
                        id: row.id,
                    });
                }
            })

            if (itemNew.length > 0) {
                for (var i = 0; i < itemNew.length; i++) {
                    gridOptions.api.applyTransaction({
                        remove: itemNew,
                    });

                }


            }
            if (itemSave.length > 0) {
                console.log(itemSave);
                Swal.fire({
                    title: 'Xoá ' + itemSave.length + ' món ?',
                    text: "Dữ liệu sau khi xoá sẽ không thể phục hồi",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý!',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        postDataDelete();
                    } else {
                        return;
                    }
                })

            }

        })

        function postDataDelete() {
            $.ajax({
                url: '{{ asset('') }}delete_menu_items',
                data: {
                    list: itemSave,
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

    })
</script>
