$(document).ready(function (e) {

    $('.selectCourses').select2();
    $(".selectCourse").select2();

    // $(".select2-selection__clear").trigger('click');



    $('.image').change(function () {
        var filename = $(this).val().split('\\').pop();
        $('#file_name').html(filename);
        if (filename)
            $("#result_form_question").html(`<label class="text-success"> You have attached a picture to the question: <b>${filename}</b> </label>`);
        else
            $("#result_form_question").html('');
    });

    $("#btnSendComment").on('click', function (e) {
        e.preventDefault();
        $("#formAddComment").trigger('submit');
    });

    $("#formSelectCourses").on('submit', function (e) {
        e.preventDefault();
        let t = $(this);
        let data = new FormData(this);
        $.ajax({
            url: t.attr('action'),
            type: 'POST',
            data: data,
            success: function (data) {
                window.location.reload();
            },
            cache: false,
            processData: false,
            contentType: false
        });

    });

    $("#form_new_question").on('submit', function (e) {
        e.preventDefault();
        let url = $(this).attr('action');
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data) {
                $("#form_new_question").trigger("reset");
                flag_new_post = 1;
                addPost(data);
                flag_new_post = 0;
                $("#result_form_question").html('');
            },
            error: function (data) {
                $("#addCollege").attr('disabled', false);
                let errors = data.responseJSON.errors;
                for (error in errors)
                    $("." + error).after(`<div class = "alert alert-danger" style="padding: 3px;"> <i class="fa-solid fa-triangle-exclamation"></i> ${errors[error]}</div>`);
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });

    let page = '';
    let count_page = 1;
    let flag_new_post = 0;
    let flag_start = 0

    function getQuestions() {
        let name = 'getNewQuestions';
        if (typeof page_name !== 'undefined' && page_name == 'profile')
            name = `getUserPosts/${user_id}`;
        else if (typeof page_name !== 'undefined' && page_name == 'settings')
            name = 'getUserSavedPosts';

        $.get(`${host}${name}` + page, function (data) {
            questions = data.data;
            $(".btnGetMoreQuestion").show();
            if (Object.keys(questions).length < 10) {
                $(".btnGetMoreQuestion").hide();
            }
            for (const question of questions) {
                addPost(question);
            }

            if (flag_start == 0 && Object.keys(questions).length == 0) {
                flag_start = 1;
                if (typeof page_name === 'undefined')
                    $("#posts").html(`

                        <div class="alert alert-warning">
                            <h5>
                                <b>
                                    <i class="fa-solid fa-circle-question"></i>
                                    There are no new questions.<br/><br/>
                                    - Select the courses whose questions you would like to see.<br/><br/>
                                    <a  href="#" class="btn btn-primary ml-2" data-toggle="modal" data-target=".modalSelectCourses"><i class="fa-solid fa-book"></i> Select</a>
                                </b>
                            </h5>
                        </div>
                    `);
                else
                    $("#posts").html(`
                    <div class="alert alert-warning mt-3">
                        <h5>
                            <b>
                                <i class="fa-solid fa-circle-question"></i>
                                There are no new questions.<br/>
                            </b>
                        </h5>
                    </div>
                `);
            }
        });
    }

    getQuestions();


    function addPost(question) {
        let like = 0;
        let dislike = 0;
        let check_like = '';
        let check_dislike = '';
        let date_time = new Date(question.created_at);
        let image = ``;

        //check if there are likes and count them
        if (Object.keys(question.likes).length > 0)
            for (const r of question.likes) {
                if (r.type == "like") {
                    if (r.user_id == user_id)
                        check_like = "text-primary";
                    like++;
                } else {
                    if (r.user_id == user_id)
                        check_dislike = "text-primary";
                    dislike++;
                }
            }

        //check if post has image
        if (question.image != '--')
            image = `<img src = "/storage/${question.image}" class="mt-2" style="max-width: 250px; max-height: 250px;" />`;

        let menu = '';

        let saves = savedQuestions.split(',');


        if (saves.includes(question.id.toString()))
            menu += `<a class="dropdown-item text-success unsaveQuestion" href="${question.id}"> <i class="fa-regular fa-bookmark"></i> Unsave </a>`;
        else
            menu += `<a class="dropdown-item text-success saveQuestion" href="${question.id}"> <i class="fa-solid fa-bookmark"></i> Save </a>`;

        menu += `<a class="dropdown-item text-warning" href="/questions/${question.id}"><i class="fa-solid fa-bug"></i> Report</a>`;
        if (user_id == question.user.id) {
            if (question.stop_comments == 0)
                menu += `<a class="dropdown-item text-primary btnToggleComments" href="${question.id}"><i class="fa-solid fa-stop"></i> Stop comments</a>`;
            else
                menu += `<a class="dropdown-item text-primary btnToggleComments" href="${question.id}"><i class="fa-solid fa-play"></i> Run comments</a>`;

            menu += `<a class="dropdown-item text-danger btnDeleteQuestion" href="${question.id}"><i class="fa-solid fa-trash-can"></i> Delete </a>`;
        }

        var tag = ``;

        if (question.course == null) {
            console.log(question.major);
            tag = `<a href="/courses/${question.course.id}" class="text-primary"><u>#${question.course.name} Course</u></a>`;

        }

        var post = `
        <div class="central-meta item mt-5">
            <div class="user-post">
                <div class="friend-info">
                    <figure>
                        <img src="/storage/${question.user.image}" style="min-width: 60px; min-height: 60px; max-width: 60px; max-height: 60px;">
                        
                    </figure>
                    <div class="dropdown float-right">
                        <a href="#" class="" data-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical text-primary"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            ${menu}
                        </div>
                    </div>
                    <div class="friend-name">
                        <ins><a href="/profile/${question.user.id}" title="">${question.user.name}</a></ins>
                        <span><i class="fa-solid fa-calendar-days"></i> published: ${date_time.getFullYear()}/${date_time.getMonth()}/${date_time.getDate()} ${date_time.getHours()}:${date_time.getMinutes()}</span>
                    </div>
                    <div class="post-meta">
                        <div class="description">
                            <p>
                                ${question.text}
                            </p>
                            ${image}
                        </div>
                        <div class="mt-4 d-block">
                            ${tag}
                        </div>
                        <div class="we-video-info">
                            <ul>
                                <li>
                                    <span class="views" data-toggle="tooltip" title="views">
                                        <i class="fa fa-eye"></i>
                                        <ins>1.2k</ins>
                                    </span>
                                </li>
                                <li>
                                    <span class="comment" data-toggle="tooltip" title="Comments">
                                        <i class="fa-solid fa-comments"></i>
                                        <ins>${question.comments.length}</ins>
                                    </span>
                                </li>
                                <li>
                                    <span class="like ${check_like}" data-toggle="tooltip" title="like">
                                        <i class="fa-solid fa-thumbs-up"></i>
                                        <ins>${like}</ins>
                                    </span>
                                </li>
                                <li>
                                    <span class="dislike ${check_dislike}" data-toggle="tooltip" title="dislike">
                                        <i class="fa-solid fa-thumbs-down"></i>
                                        <ins>${dislike}</ins>
                                    </span>
                                </li>
                            
                            </ul>
                        </div>

                        <div class="row justify-content-center">
                            <a href="/questions/${question.id}" class="btn btn-sm w-25 btn-primary text-white"><i class="fa-solid fa-circle-info"></i> More details </a>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
        `;

        if (flag_new_post == 1)
            $("#posts").prepend(post);
        else
            $("#posts").append(post);

    }


    $("body").on('click', '.btnGetMoreQuestion', function (e) {
        e.preventDefault();
        page = `/?page=${++count_page}`;
        getQuestions();
    });


});
