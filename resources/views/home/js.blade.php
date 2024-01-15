<script type="module">
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js";
    import {
        getDatabase, 
        ref,
        onValue/*,
        get,
        set,
        update,
        remove        
         */
    } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-database.js";

    const firebaseConfig = {
        databaseURL: "https://notifi-94695-default-rtdb.asia-southeast1.firebasedatabase.app",
    };

    // Khởi tạo ứng dụng Firebase
    const app = initializeApp(firebaseConfig);

    // Lấy cơ sở dữ liệu
    const db = getDatabase(app);

    const dataPath = '/table/';

    // Lấy tham chiếu đến root của cơ sở dữ liệu
    const dbRef = ref(db, dataPath);

    // Lắng nghe sự kiện thay đổi trên database
    onValue(dbRef, (snapshot) => {
        const data = snapshot.val();
        console.log(data);
    });


   /*  // Thêm dữ liệu
    function addData() {
        var data = {
            id: 5,
            status: "off"
        };

        var newKey = data.id;
        set(ref(db, dataPath + newKey), data);
    }

    // Cập nhật dữ liệu
    function updateData(key) {
        var updates = {
            status: "off"
        };

        update(ref(db, dataPath + key), updates);
    }

    // Xoá dữ liệu
    function removeData(key) {
        remove(ref(db, dataPath + key));
    } */

    /* 
        get(dbRef).then((snapshot) => {
            if (snapshot.exists()) {
                console.log(snapshot.val());
            } else {
                console.log("No data available");
            }
        }).catch((error) => {
            console.error(error);
        });
     */


    $(document).ready(function() {
        $("title").text('{{ $title }}');
        var html = '';
        var listTable = [];
        var listTableNumber = [];


        function getTableListData() {
            $.ajax({
                url: '{{ asset('') }}' + 'table_list',
                success: function(data) {
                    console.log(data);
                    let arrTableId = [];
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].paid == data[i].total && data[i].total != 0) {

                        } else {
                            arrTableId.push(data[i].id);
                            listTable.push(data[i]);
                            listTableNumber.push(data[i].table_number);
                        }
                    }
                    $('#count_table').text(data.length);
                    if (arrTableId.length > 0) {
                        getStatistics(arrTableId);
                    }
                }
            })
        }
        getTableListData();

        function getStatistics(arrId) {
            let totalItem = 0;
            let total_price = 0;
            let total_price_table = 0;
            $.ajax({
                url: '{{ asset('') }}' + 'statistics',
                data: {
                    arrId: arrId,
                },
                success: function(data) {
                    let j = 0;
                    console.log(data)
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].cashier_id == null) {
                            total_price_table += data[i].price;
                        }
                        if (data[i].price != null) {
                            totalItem++;
                        }
                        if (i > 0) {
                            if (data[i].table_id != data[i - 1].table_id) {
                                if (data[i].price == null) {
                                    total_price_table = 0;
                                } else {
                                    total_price_table = data[i].price;
                                }
                            }
                        }
                        if (i == data.length - 1) {
                            html += '<div class="item "><a href="/table-' + listTable[j].id +
                                '" class="item_box"><div class="item_head">' +
                                listTable[j].name_table +
                                '</div> <div style="font-size: 11px; color: black;">' +
                                convertTimeStamp(listTable[j].created_at) +
                                '</div> <div class="item_num">' +
                                listTable[j].table_number +
                                '</div> <div class="text-danger text-right">' + total_price_table
                                .toLocaleString() + 'đ </div>' +
                                '<div class="item_footer"> Còn lại ' +
                                listTable[j].total + '<span">/' + totalItem + '</span> item' +
                                '</div> </a> </div>';
                            j++;
                            totalItem = 0;
                            total_price_table = data[i].price;
                        } else if (data[i].table_id != data[i + 1].table_id) {
                            html += '<div class="item "><a href="/table-' + listTable[j].id +
                                '" class="item_box"><div class="item_head">' +
                                listTable[j].name_table +
                                '</div> <div style="font-size: 11px; color: black;">' +
                                convertTimeStamp(listTable[j].created_at) +
                                '</div> <div class="item_num">' +
                                listTable[j].table_number +
                                '</div> <div class="text-danger text-right">' + total_price_table
                                .toLocaleString() + 'đ </div>' +
                                '<div class="item_footer"> Còn lại ' +
                                listTable[j].total + '<span">/' + totalItem + '</span> item' +
                                '</div> </a> </div>';
                            j++;
                            totalItem = 0;
                            total_price_table = data[i].price;
                        }
                        if (data[i].cashier_id == null) {
                            total_price += Number(data[i].price);
                        }
                    }
                    $('#total_price').text(total_price.toLocaleString() + 'đ');
                    /* html += '<div class="item "><a href="/table-' + listTable[j].id +
                                '" class="item_box"><div class="item_head">' +
                                listTable[j].name_table +
                                '</div> <div style="font-size: 11px; color: black;">' +
                                    convertTimeStamp(listTable[j].created_at) +
                                '</div> <div class="item_num">' +
                                listTable[j].table_number +
                                '</div> <div class="text-danger text-right">' + total_price_table.toLocaleString() + ' đ </div>' +
                                '<div class="item_footer"> Còn lại ' +
                                listTable[j].total + '<span">/' + totalItem + '</span> item' +
                                '</div> </a> </div>'; */
                    $('.cont_item').html(html);
                }
            })
        }

        $('#btn_add').click(function() {
            console.log('add')
            $.ajax({
                url: '{{ asset('') }}new-table',
                data: {
                    listTableNumber: listTableNumber,
                },
                success: function(data) {
                    if (data.code == 'SUCCESS') {
                        window.location.href = '{{ asset('') }}table-' + data.id;
                    }
                    if (data.code == 'ERROR') {
                        alert(' Something went wrong ');
                    }
                }
            })
        })


    })
</script>
