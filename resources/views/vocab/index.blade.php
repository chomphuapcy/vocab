@extends('layouts.layouts')
@section('title', 'Vocabulary')
@section('content')
<div class="container-fluid gd-pink text-center text-white py-3">
    <h4><a href="./" class="logo-btn">Vocabulary</a></h4>
    {{-- Search Bar --}}
    <input type="text" id="search-box" placeholder="Search">
</div>
<div class="loadScreen" >
    <div class="load-spin">
        <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
<div id="main-vocab">

</div>
@endsection

@section('script')
<script>

    function fetchData(word){
        if (word == ""){
            word = "all"
        }
        $.ajax({
            type: "get",
            url: "{{ url("/vocab/get/") }}/" + word,
            data: {},
            beforeSend: function() {
                $(".loadScreen").show()
                $("#main-vocab").html("")
            },
            success: function (response) {
                showWord(response)
                $(".loadScreen").hide()
            }
        });
    }

    function showWord(data){
        main_content = $("#main-vocab");
        main_content.html("");
        data.forEach(row => {
            var fav
            if (row.favorite == 1){
                fav = "heart"
            }else{
                fav = "plus"
            }
            content = "<div class='word-tab' id='w" + row.id + "'> \
                    <div class='word-header'> \
                        <h3>" + row.word + "</h3> (" + row.type + ") \
                    </div> \
                    <div class='word-meaning'> \
                        " + row.mean + " \
                    </div> \
                        <button class='btn-love' id='" + row.id + "' data-fav='" + row.favorite + "' onclick='changeFav(`" + row.id + "`)'><i id='icon" + row.id + "' class='fas fa-" + fav + "'></i></button>\
                    </div>"
            main_content.append(content);
        })
        if (data == ""){
            main_content.html("<div class='m-3 rounded'><div class='card'><div class='card-body'><div align='center'>Not found</div></div></div><div>");
        }
    }

    function changeFav(id){
        status  = $("button#" + id).data("fav")
        status = (status > 0) ? 0 : 1
        $.ajax({
            type: "get",
            url: "{{ url("/vocab/change/fav/") }}/" + id + "/" + Number(status),
            data: {},
            success: function (response) {
                if (status == 1){
                    document.getElementById("icon" + id).className = "fas fa-heart"
                    $("button#" + id).data("fav", status)
                }else{
                    document.getElementById("icon" + id).className = "fas fa-plus"
                    $("button#" + id).data("fav", status)
                }
            }
        });
    }

    $(document).ready(function(){
        fetchData("all");
        $("#search-box").keyup(function () {
            var data = $(this).val()
            fetchData(data)
        });
    });
</script>
@endsection
