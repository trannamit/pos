<style>
.cont_item{
    display: flex;
    flex-wrap: wrap;
}
.item{
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px
}
.item_box{
    background-color : rgb(219, 219, 219);
    min-height: 154px;
    min-width: 154px;
    display: flex;
    flex-direction: column;
    align-content: space-between;
}
.item_head{
    color : white;
    text-align : center;
    background-color : #4e73df;
}
.item_num{
    color : black;
    font-size : 500%;
    line-height : 78px;
    text-align : center;
}
.item_footer{
    color : white;
    text-align : center;
    background-color : #243568;
}

.bottom_bar{
    position : fixed;
    bottom: 0px;
    background-color : white;
    width: 100%;
    height: 77px;
    display: flex;
    align-items : center;
    justify-content: space-between;
    margin-left: -1.5rem;
}
#btn_add{
    position : fixed;
    right: 1.5rem;
}
.bar_infor{
    margin-left: 1.5rem;

}

</style>