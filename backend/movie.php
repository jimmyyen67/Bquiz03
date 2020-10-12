<style>
    .list {
        height: 435px;
        overflow: auto;
    }

    .movie-item {
        display: grid;
        grid-template-columns: 2fr 1fr 5fr;
    }

    .infos {
        display: grid;
        grid-template-rows: 1fr 1fr 1fr;
    }
</style>

<button onclick="location.href='?do=add_movie'">新增電影</button>
<button onclick="allToday()">一鍵上映</button>
<hr>
<div class="list">


</div>

<script>
    // 將全部電影的上映日期變更為今日
    function allToday() {
        $.post("api/all_today.php", {}, (res) => {
            reloadlist();
        })
    }


    //在頁面載入完成後先載入一次電影列表
    reloadlist();

    //取得電影列表的函式
    function reloadlist() {
        $.get("api/movie_list.php", function(list) {
            $(".list").html(list)

            //使用jquery來對載入後的列表中的button進行點擊動作的處理
            $(".shift").on("click", function() {

                //取得data屬性的值，並拆成一個id陣列
                let id = $(this).data("rank").split("-");

                //將id陣列連同要修改的資料表名稱一起用ajax的方式一直傳到後台
                $.post("api/rank.php", {
                    id,
                    "table": "b03movie"
                }, function() {

                    //後台api處理完畢後重新載入一次頁面
                    reloadlist()
                })
            })
        })
    }

    //處理顯示切換的功能
    function showing(table, id) {
        $.post("api/showing.php", {
            table,
            id
        }, function() {
            //後端的資料更新完後,重新載入一次電影列表
            reloadlist()
        })
    }

    //刪除資料表資料的函式
    function del(table, id) {
        $.post("api/del.php", {
            table,
            id
        }, function() {
            //後端的資料更新完後,重新載入一次電影列表
            reloadlist()
        })
    }


    /* 這一段程式碼在電影列表改為ajax載入後，需要搬到reloadList()函式，也就是當列表的內容載入到網頁時，才能去註冊列表中的按鈕事件
     
    //使用jquery來對button的點擊做處理
    $(".shift").on("click",function(){

        //取得data屬性的值，並拆成一個id陣列
        let id=$(this).data("rank").split("-");

        //將id陣列連同要修改的資料表名稱一起用ajax的方式一直傳到後台
        $.post("api/rank.php",{id,"table":"movie"},function(){

            //後台api處理完畢後重新載入一次頁面
            reloadlist()
        })
    })
     */
</script>