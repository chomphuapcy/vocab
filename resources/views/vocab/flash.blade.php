@extends('layouts.layouts')
@section('title', 'Vocabulary')
@section('content')
<div class="container-fluid gd-pink text-center text-white py-1">
    <h4><a href="./" class="logo-btn">Vocabulary</a></h4>
</div>
<div class="loadScreen d-none">
    <div class="load-spin">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
<div id="main-vocab">
    <div class="flash-card" id="word-card">
            <div class="float-left">
                <h3><span class="badge badge-pill badge-primary" id="num">0</span></h3>
            </div>
            <div class="float-right">
                <span>Score : <span class="badge badge-info score">0/0</span></span><br>
            </div>
        <div class="word-header mt-5" align="center">
            <h3 id="word">No word found</h3> <br>(<span id="word-type"></span>)
        </div>
        <div align="center">
        <button class="btn btn-primary mt-3 show-btn" onclick="$(this).hide();$('#word-meaning').removeClass('d-none')"><i class="material-icons" style="font-size: 16px;position: relative;top: 3px;">visibility</i> show</button> <h3 class="d-none mt-3" id="word-meaning">ไม่พบคำศัพท์</h3>
        </div>
        <br>
        <div class="d-flex justify-content-center mt-3">
            <button class="mr-2 reset-btn" onclick="reset()">Reset <i class="material-icons">replay</i></button>
            <button class="mr-2 incorrect-btn">Incorrect <i class="material-icons">clear</i></button>
            <button class="correct-btn">Correct <i class="material-icons">check</i></button>
        </div>
    </div>
    <div class="flash-card" id="result-page" style="display: none">
        <center>
            <h3 align="center" class="mb-3">Result</h3>
            <b>Yours score: </b><br>
            <h3 class="score">0/5</h3>
            <button class="reset-btn mt-3" onclick="reset()">Reset <i class="material-icons">replay</i></button>
        </center>
    </div>
</div>
@endsection

@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function fetchData(){
    var result;
    $.ajax({
      url: "{{ url("/vocab/get/all") }}",
      async: false,
      success: function(data) {
         result = data;
      }
   });
   return result;
}

function changeScore(score, number){
    $(".score").html(score + "/" + number)
}

function changeNumber(number){
    $("#num").html(number)
}

function get_random (arr) {
  return arr[Math.floor((Math.random() * arr.length))];
}

function showData(data, index_data){
    var word_s = data[index_data]
    $("#word").html(word_s.word)
    $("#word-type").html(word_s.type)
    $("#word-meaning").html(word_s.mean)
}

function finish(){
    $("#result-page").show();
    $("#word-card").hide();
}

function reset(){
    Swal.fire({
        title: 'Reset?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Reset!'
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
        }
    })
}

$(document).ready(function() {
    var data = fetchData();
    var score = 0;
    var no = 1;
    var len = Object.keys(data).length;
    var random_word = []
    index_array = [];
    for (i = 0; i < len; i++){
        index_array.push(i)
    }
    for (i = 0; i < len; i++){
        var r_data = get_random(index_array);
        index_array.splice(r_data, 1)
        random_word.push(r_data)
    }

    showData(data, random_word.pop())

    $(".correct-btn").click(function (e) {
        e.preventDefault();
        score += 1
        changeScore(score, no)
        if (random_word.length != 0){
            showData(data, random_word.pop())
            no += 1
            changeNumber(no)
            $(".show-btn").show()
            $("#word-meaning").addClass("d-none")

        }else{
            finish();
        }

    });

    $(".incorrect-btn").click(function (e) {
        e.preventDefault();
        changeScore(score, no)
        if (random_word.length != 0){
            showData(data, random_word.pop())
            no += 1
            changeNumber(no)
            $(".show-btn").show()
            $("#word-meaning").addClass("d-none")
        }else{
            finish();
        }
    });
})
</script>
@endsection
