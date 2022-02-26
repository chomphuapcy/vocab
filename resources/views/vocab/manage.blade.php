@extends('layouts.layouts')
@section('title', 'Vocabulary')
@section('content')
    <div class="container-fluid gd-pink text-center text-white py-3">
        <h4><a href="./" class="logo-btn">Vocabulary</a></h4>
        {{-- Search Bar --}}
        <input type="text" id="search-box" placeholder="Search">
    </div>
    <div class="loadScreen">
        <div class="load-spin">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mx-4">
        <a href="" class="add-btn" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> Add</a>
    </div>
    <div id="main-vocab">
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add vocabulary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="add-body">
                    <form enctype="multipart/form-data" method="post" id="addForm">
                        @csrf
                        <div class="form-group mt-3">
                            <input type="text" name="word" class="form-control" placeholder="Word" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="meaning" class="form-control" placeholder="Meaning" required>
                        </div>
                        <div class="form-group" id='type-sel'>
                            <select class="form-control" name="word_type">
                                <option value="n." selected="true">Noun</option>
                                <option value="pron.">Pronoun</option>
                                <option value="v.">Verb</option>
                                <option value="adj.">Adjective</option>
                                <option value="adv.">Adverb</option>
                                <option value="prep.">Preposition</option>
                                <option value="conj.">Conjunction</option>
                                <option value="interj.">Interjection</option>
                                <option value="Phrv.">Phrasal Verbs</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="add-save-btn">
                        <span class="spinner-border spinner-border-sm" id="add-spin" role="status" aria-hidden="true"
                            style="position: relative;top: -5px;display:none"></span>
                        Add
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit vocabulary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="edit-body">
                    <form enctype="multipart/form-data" method="post" id="editForm">
                        @csrf
                        <input type="hidden" name="e_id" value="">
                        <div class="form-group mt-3">
                            <input type="text" name="e_word" class="form-control" placeholder="Word" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="e_meaning" class="form-control" placeholder="Meaning" required>
                        </div>
                        <div class="form-group" id='type-sel'>
                            <select class="form-control" name="e_word_type" id="e_word_type">
                                <option value="n.">Noun</option>
                                <option value="pron.">Pronoun</option>
                                <option value="v.">Verb</option>
                                <option value="adj.">Adjective</option>
                                <option value="adv.">Adverb</option>
                                <option value="prep.">Preposition</option>
                                <option value="conj.">Conjunction</option>
                                <option value="interj.">Interjection</option>
                                <option value="Phrv.">Phrasal Verbs</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-save-btn">
                        <span class="spinner-border spinner-border-sm" id="edit-spin" role="status" aria-hidden="true"
                            style="position: relative;top: -5px;display:none"></span>
                        Save
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function fetchData(word) {
            if (word == "") {
                word = "all"
            }
            $.ajax({
                type: "get",
                url: "{{ url('/vocab/get/') }}/" + word,
                data: {},
                beforeSend: function() {
                    $(".loadScreen").show()
                    $("#main-vocab").html("")
                },
                success: function(response) {
                    showWord(response)
                    $(".loadScreen").hide()
                }
            });
        }

        function showWord(data) {
            main_content = $("#main-vocab");
            main_content.html("");
            data.forEach(row => {
                var fav
                if (row.favorite == 1) {
                    fav = "heart"
                } else {
                    fav = "plus"
                }
                content = " <div class='word-tab' id='w" + row.id + "'> \
                            <div class='word-header'> \
                                <h3>" + row.word + "</h3> (<span class='word-type'>" + row.type + "</span>) \
                                </div> \
                                <div class='word-meaning'> \
                                " + row.mean + " \
                                </div> \
                                <div class='d-flex justify-content-end'>\
                                <button class='btn btn-sm btn-warning mr-2' onclick='editWord(`" + row.id + "`)'><i class='fas fa-edit'></i></button>\
                                <button class='btn btn-sm btn-danger' onclick='deleteWord(`" + row.id + "`)'><i class='fas fa-trash'></i></button>\
                            </div>\
                            </div>"
                main_content.append(content);
            })
            if (data == "") {
                main_content.html(
                    "<div class='m-3 rounded'><div class='card'><div class='card-body'><div align='center'>Not found</div></div></div><div>"
                );
            }
        }

        function deleteWord(id) {
            Swal.fire({
                title: 'Delete',
                text: "You do want to delete?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.get("{{ url('/manage/delete/') }}" + "/" + id, {},
                        function(res) {
                            $("#w" + id).fadeOut();
                        },
                    );
                }
            })
        }

        function editWord(id) {
            $.get("{{ url('/voacb/json/') }}" + "/" + id, {},
                function(data) {
                    console.log(data);
                    $("#editModal").modal("show");
                    $("#editForm input[name='e_word']").val(data[0].word)
                    $("#editForm input[name='e_meaning']").val(data[0].mean)
                    $("#e_word_type option[value='" + data[0].type + "']").prop("selected", 'true');
                    $("#editForm input[name='e_id']").val(data[0].id)
                }
            );
        }

        $(document).ready(function() {
            fetchData("all");
            $("#search-box").keyup(function() {
                var data = $(this).val()
                fetchData(data)
            });
            $("#addForm").on("submit", function(e) {
                e.preventDefault();
                $("#add-spin").show()
                var formData = $(this).serialize();
                $.post("{{ route('word.add.save') }}", formData, function(res) {
                    fetchData("");
                    $("#add-spin").hide()
                    $("#addModal").modal('hide');
                    $("input[name='word']").val("")
                    $("input[name='meaning']").val("")
                    $("select[name='word_type']").prop('selectedIndex', 0);

                })
            });

            $("#editForm").on("submit", function(e) {
                e.preventDefault();
                $("#edit-spin").show()
                var formData = $(this).serialize();
                $.post("{{ route('word.edit.save') }}", formData, function(res) {
                    $("#edit-spin").hide()
                    $("#editModal").modal('hide');
                    $("#w" + res.e_id + " .word-header h3").html(res.e_word);
                    $("#w" + res.e_id + " .word-header .word-type").html(res.e_word_type);
                    $("#w" + res.e_id + " .word-meaning ").html(res.e_meaning);
                })
            });
        });
    </script>
@endsection
