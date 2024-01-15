<script>
    $('.facebook, .call, .address, .item').hide();
    setTimeout(function() {
        $('.facebook').show(500);
    }, 1000);
    setTimeout(function() {
        $('.call').show(500);
    }, 2000);
    setTimeout(function() {
        $('.address').show(500);
    }, 3000);

    function showItems() {
        var items = $('.item');
        items.each(function(e) {
            console.log(e);
        });
    }

    function getListData() {
        $.ajax({
            url: '{{ asset('menu_list_client') }}',
            success: function(data) {
                showMenu(data);
            }
        })
    }
    getListData();

    function showMenu(data){
        data.forEach(async function(item) {
            let html = '<div style="display: none" class="item" id="item' + item.id + '" > <span class="left"> '+ item.text +' </span> <span class="right ">'+ item.value/1000 +'K</span></div>';
            $('.menu_list').append(html);
        })
        let i = 0;
        function loop(i){
            setTimeout(function(){
                $('#item'+data[i].id).show(400);
                i++;
                if(i < data.length){
                    loop(i);
                }
            },100)
        }
        loop(i);
    }
</script>
