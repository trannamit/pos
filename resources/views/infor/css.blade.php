<style>
    body {
        background-color: rgb(250, 226, 242);
        height: 100%;
    }
    .menu_list{
        display: flex;
        flex-wrap: wrap;
    }
    .item{
        box-sizing: border-box;
        font-family: 'Paytone One', sans-serif;
        width: 165px;
        min-height: 50px;
        color: #fff;
        background-color: rgba(248, 12, 169, 0.456);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 3px;
        
    }
    .item>.right{
        padding: 2px 5px 2px 1px;
        font-size: 20px;
        
    }
    .item>.left{
        padding: 2px 1px 2px 5px;
        font-size: 14px;

    }
    .page_body_title > H2{
        font-family: 'Pacifico', cursive;
    }
    .page_body{
        min-height: 40em;
    }
    .button_infor{
        display: flex;
        align-items: end;
        flex-direction: column-reverse;
        width: 100%;
        position: fixed;
        bottom: 50px;
        right: 20px;
    }
    .button_infor a{
        margin: 5px;
        background-color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .button_infor i{
        font-size: 24px;
    }
    .facebook{
        color: rgb(38, 108, 246);
    }
    .call{
        color: rgb(7, 143, 23);
    }
    .address{
        color: rgb(153, 11, 11);
    }
    .btn_login{
        position: absolute;
        top: 10px;
        left: 10px;
    }

</style>