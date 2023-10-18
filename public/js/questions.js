$(document).ready(function(e){
    
    $("#btnAddImageToComment").on('click', function(e){
        e.preventDefault();
        $("#image").trigger('click');
    });
    
    $("#btnSendComment").on('click', function(e){
        e.preventDefault();
        $("#formAddComment").trigger('submit');
    });
    
    $('#image').change(function(){
        var filename = $(this).val().split('\\').pop();
        $('#file_name').html(filename);
        if ( filename )
            $("#result_form_question").html(`<label class="text-success"> You have attached a picture to the question: <b>${filename}</b> </label>`);
        else
            $("#result_form_question").html('');
    });

    $(".comment").on('click', function(e){
        e.preventDefault();
        window.location.hash = '#';
        window.location.hash = '#text';
    });


    $("#formAddComment textarea").on('keyup', function(e){
        e.preventDefault();
    });

    $("#count_comments").html( count_comments );

    //forms
    $("#formAddComment").on('submit', function(e){
        e.preventDefault();
        let url = $(this).attr('action');
        let data = new FormData(this);
        data.append('reply_user_id',reply_user_id);
        data.append('reply_comment_id',reply_comment_id);
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                $("#formAddComment").trigger("reset");
                addComment(data);
                $("#result_form_question").html('');
                reply_user_id = 0;
                reply_comment_id = 0;
                $("#count_comments").html( ++count_comments );
            },
            error: function(data){
                let errors = data.responseJSON.errors;
                for (error in errors)
                    $("."+error).after(`<div class = "alert alert-danger" style="padding: 3px;"> <i class="fa-solid fa-triangle-exclamation"></i> ${errors[error]}</div>`);
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });
    
    $("#form_new_question").on('submit', function(e){
        e.preventDefault();
        let url = $(this).attr('action');
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                $("#form_new_question").trigger("reset");
                addPost(data);
                $("#result_form_question").html('');
            },
            error: function(data){
                $("#addCollege").attr('disabled' , false);
                let errors = data.responseJSON.errors;
                for (error in errors)
                    $("."+error).after(`<div class = "alert alert-danger" style="padding: 3px;"> <i class="fa-solid fa-triangle-exclamation"></i> ${errors[error]}</div>`);
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });

    //for comments and questions
    let page = '';
    let count_page = 1;
    let reply_user_id = 0; // for reply comments
    let reply_comment_id = 0; // for reply comments
    let box_comment;

    function getQuestions(){

        $.get(`${host}questions/get/` + course + page , function (data) {
            questions = data.data;
            $(".btnGetMoreQuestion").show();
            if (Object.keys(questions).length < 10)
            {
                $(".btnGetMoreQuestion").hide();
            }
            for (const question of questions){
                addPost( question );
            }
        });
    }
    getQuestions();

    
    function getComments(){

        $.get(`${host}question/getComments/` + question + page, function (data) {
            comments = data.data;
            $(".btnGetMoreComment").show();
            if (Object.keys(comments).length < 10)
            {
                $(".btnGetMoreComment").hide();
            }
            for (const comment of comments){
                addComment( comment );
            }
        });
    }
    getComments();

    function getSubComments(comment_id){

        $.get(`${host}question/getSubComments/` + comment_id , function (data) {
            return data;
        });
    }

    $("body").on('click', '.replyComment' , function(e){
        e.preventDefault();
        window.location.hash = '#';
        window.location.hash = '#text';
        reply_user_id = $(this).attr('href').split('/')[0];
        reply_comment_id = $(this).attr('href').split('/')[1];
        box_comment = $(this).closest('.box_comment');
    });

    $("body").on('click', '.like' , function(e){
        e.preventDefault();
        alert(1);
    });
    
    $("body").on('click','.btnGetMoreQuestion', function(e){
        e.preventDefault();
        page = `/?page=${++count_page}`;
        getQuestions();
    });
    
    $("body").on('click','.btnGetMoreComment', function(e){
        e.preventDefault();
        page = `/?page=${++count_page}`;
        getComments();
    });


    function addPost(question)
    {
        let like = 0;
        let dislike = 0;
        let check_like = '';
        let check_dislike = '';
        let date_time = new Date(question.created_at);
        let image = ``;

        //check if there are likes and count them
        if ( Object.keys(question.likes).length > 0 )
            for (const r of question.likes)
            {
                if ( r.type == "like" ){
                    if ( r.user_id == user_id )
                        check_like = "text-primary";
                    like++;
                } else {
                    if ( r.user_id == user_id )
                        check_dislike = "text-primary";
                    dislike++;
                }
            }
        
        //check if post has image
        if ( question.image != '--' )
            image = `<img src = "/storage/${question.image}" class="mt-2" style="max-width: 250px; max-height: 250px;" />`;

        let menu = '';
        
        let saves = savedQuestions.split(',');


        if ( saves.includes( question.id.toString() ) )
            menu += `<a class="dropdown-item text-success unsaveQuestion" href="${question.id}"> <i class="fa-regular fa-bookmark"></i> Unsave </a>`;
        else
            menu += `<a class="dropdown-item text-success saveQuestion" href="${question.id}"> <i class="fa-solid fa-bookmark"></i> Save </a>`;
        
        menu += `<a class="dropdown-item text-warning" href="/questions/${question.id}"><i class="fa-solid fa-bug"></i> Report</a>`;
        if (user_id == question.user.id )
        {
            if ( question.stop_comments == 0)
                menu += `<a class="dropdown-item text-primary btnToggleComments" href="${question.id}"><i class="fa-solid fa-stop"></i> Stop comments</a>`;
            else
                menu += `<a class="dropdown-item text-primary btnToggleComments" href="${question.id}"><i class="fa-solid fa-play"></i> Run comments</a>`;
            
            menu += `<a class="dropdown-item text-danger btnDeleteQuestion" href="${question.id}"><i class="fa-solid fa-trash-can"></i> Delete </a>`;
        }

        $("#posts").prepend(`
        <div class="central-meta item">
            <div class="user-post">
                <div class="friend-info">
                    <figure>
                        <img src="/storage/${question.user.image}" alt="">
                    </figure>
                    <div class="dropdown float-right">
                        <a href="#" class="" data-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical text-primary"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            ${menu}
                        </div>
                    </div>
                    <div class="friend-name">
                        <ins><a href="time-line.html" title="">${question.user.name}</a></ins>
                        <span><i class="fa-solid fa-calendar-days"></i> published: ${ date_time.getFullYear() }/${date_time.getMonth()}/${date_time.getDate()} ${date_time.getHours()}:${date_time.getMinutes()}</span>
                    </div>
                    <div class="post-meta">
                        <div class="description">
                            <p>
                                ${question.text}
                            </p>
                            ${image}
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
        `);

    }

    function addComment(comment)
    {
        let date_time = new Date(comment.created_at);
        let image = ``;

        //check if subcomment
        if ( reply_comment_id != 0 )
        {
            let c = comment;
            let img = '';
            if ( c.image != '--' )
                img = `<img src = "/storage/${c.image}" class="mt-2" style="max-width: 250px; max-height: 250px;" /><br/>`;
            box_comment.append(`
            <ul>
                <li>
                    <div class="comet-avatar">
                        <img src="/storage/${c.user.image}" width="50">
                    </div>
                    <div class="we-comment">
                        <div class="coment-head">
                            <h5><a><i class="fa fa-reply text-primary"></i> ${c.user.name} <b class="text-primary">reply to</b> ${c.replyToUsername}</a></h5>
                            <span>${date_time}</span>
                        </div>
                        <p>${c.text}</p>
                        ${img}
                    </div>
                </li>
            </ul>
        `);
            return;
        }
 
        
        //check if post has image
        if ( comment.image != '--' )
            image = `<img src = "/storage/${comment.image}" class="mt-2" style="max-width: 250px; max-height: 250px;" />`;

        let subComments = ''; 
        let sub;
        $.ajaxSetup({async: false});

        $.get(`${host}question/getSubComments/` + comment.id , function (data) {
            if (Object.keys(data).length > 0 )
            {
                // subComments += '<ul>';
                for (const c of data)
                {
                    let img = '';
                    if ( c.image != '--' )
                        img = `<img src = "/storage/${c.image}" class="mt-2" style="max-width: 250px; max-height: 250px;" /><br/>`;
                    subComments +=
                    `<ul>
                        <li>
                            <div class="comet-avatar">
                                <img src="/storage/${c.user.image}" width="50">
                            </div>
                            <div class="we-comment">
                                <div class="coment-head">
                                    <h5><a><i class="fa fa-reply text-primary"></i> ${c.user.name} <b class="text-primary">reply to</b> ${c.replyToUsername}</a></h5>
                                    <span>${date_time}</span>
                                </div>
                                <p>${c.text}</p>
                                ${img}
                                <a class="we-reply replyComment" href="${c.user.id}/${comment.id}" title="Reply">Reply <i class="fa fa-reply"></i></a>
                            </div>
                        </li></ul>
                    `;
                }
                // subComments += '</ul>';
            }
            
        });


        $("#comments").append(`
            <li class="box_comment">
                <div class="comet-avatar">
                    <img src="/storage/${comment.user.image}" width="60" alt="">
                </div>
                <div class="we-comment">
                    <div class="coment-head">
                        <h5><a href="3" title="">${comment.user.name}</a></h5>
                        <span>${date_time}</span>
                    </div>
                    <p>${comment.text}</p>
                    ${image}
                    <a class="we-reply replyComment" href="${comment.user.id}/${comment.id}" title="Reply">Reply <i class="fa fa-reply"></i></a>
                </div>
                ${ subComments }
            </li>
        `);

    }

    $("#formSendComplaint").on('submit', function(e){
        e.preventDefault();
        let url = $(this).attr('action');
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                alert("Your complaint has been sent successfully, we will deal with it as soon as possible");
                $("#formSendComplaint").trigger("reset");
                $(".modalReport").modal('hide');
            },
            error: function(data){
                alert( "There is error in add this complaint" );
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });
    



});
