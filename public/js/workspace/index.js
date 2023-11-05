$(document).ready(function(){

    let page = '';
    let count_page = 1;

    $("#count").html(`${count}`);

    function getWorkspaces(){

        $.get(`${host}workspace/get/1` + page , function (data) {
            workspaces = data;
            for (const workspace of workspaces)
            {
                addWorkspace(workspace);
            }
            
        });
    }
    getWorkspaces();

    $("#addNewWorkspace").on('submit', function(e){
        e.preventDefault();
        $("#result").hide();
        let url = $(this).attr('action');
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                $("#addNewWorkspace").trigger("reset");
                addWorkspace(data);
                $(".modal").modal('hide');
                $("#result").hide();
                $("#count").html(`${++count}`);
            },
            error: function(data){
                let errors = data.responseJSON.errors;
                $("#result").html(` `);
                $("#result").show();
                for (error in errors)
                    $("#result").append(`<div class = "alert alert-danger" style="padding: 3px;"> <i class="fa-solid fa-triangle-exclamation"></i> ${errors[error]}</div>`);
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });

    $("#formInvite").on('submit', function(e){
        e.preventDefault();
        $("#result_invite").hide();
        let url = $(this).attr('action');
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                // $("#formInvite").trigger("reset");
                // $(".modal").modal('hide');
                $("#result_invite").hide();
            },
            error: function(data){
                let errors = data.responseJSON.errors;
                $("#result").html(` `);
                $("#result").show();
                for (error in errors)
                    $("#result_invite").append(`<div class = "alert alert-danger" style="padding: 3px;"> <i class="fa-solid fa-triangle-exclamation"></i> ${errors[error]}</div>`);
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });

    $("#formUploadWork").on('submit', function(e){
        e.preventDefault();
        let url = $(this).attr('action');
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                $("#formUploadWork").trigger("reset");
                $(".modal").modal('hide');
            },
            error: function(data){
                alert("There is error in add this work !");
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });

    $("body").on('click','#btnDeleteWorkspace' , function(e){
        e.preventDefault();
        if ( ! confirm("Are you sure to delete this workspace with all details : ") )
            return false;
        let t = $(this);
        let id = $(this).attr('href');
        $.ajax({
            type: "POST",
            url: `/workspace/delete/${id}`,
            data: null,
            success: function(data){
                t.closest('li').hide();
                $("#count").html(`${--count}`);
            },
            error: function(data){
                alert("There is error in delete this workspace");
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });

    $("body").on('click','.btnLeave' , function(e){
        e.preventDefault();
        if ( ! confirm("Are you sure to leave from this workspace ?") )
            return false;
        let t = $(this);
        let id = $(this).attr('href');

        $.ajax({
            type: "POST",
            url: `/workspace/leave/${id}/${user_id}`,
            data: null,
            success: function(data){
                t.closest('li').hide();
            },
            error: function(data){
                alert("There is error in delete this workspace");
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });

    $("body").on('click','.btnLeaveMember' , function(e){
        e.preventDefault();
        if ( ! confirm("Are you sure to leave from this member ?") )
            return false;
        let t = $(this);
        let id = $(this).attr('href');

        $.ajax({
            type: "POST",
            url: `/workspace/leave/${workspace}/${id}`,
            data: null,
            success: function(data){
                t.closest('.row').hide();
            },
            error: function(data){
                alert("There is error in delete this workspace");
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });
    
    $(".btnShowWorks").on('click', function(e){
        e.preventDefault();

        $("#works").html(``);

        $.get(`${host}workspace/getWorks/${workspace}` , function (data) {
            files = data;
            let i = 0;
            for (const file of files)
            {
                $("#works").prepend(`
                    <tr>
                        <td>${++i}</td>
                        <td>${file.name}</td>
                        <td><a href="/storage/${file.file}" class="text-info"><i class="fa-solid fa-file"></i> FILE</a></td>
                        <td>${file.comment}</td>
                        <td>${file.date}</td>
                    </tr>
                `);
            }
            
        });

    }); 


    function addWorkspace(workspace)
    {
        let btnDelete = '';
        let btnLeave = '';

        var path = window.location.pathname;
        var page = path.split("/")[1];
        let figure = '';
        let img = '<img src="/images/group.webp" style="width: 70%">';

        if ( page != 'main' ) 
        {
            figure = `<figure><img src="/images/group.webp"></figure>`;
            img = '';
        }

        if ( workspace.user_id == user_id )
            btnDelete = `<a href="${workspace.id}" class="btn btn-sm btn-danger" id="btnDeleteWorkspace"> <i class="fa-solid fa-trash-can text-white"></i> Delete </a>`;
        else
            btnLeave = `<a href="${workspace.id}" class="btn btn-sm btn-warning btnLeave text-white "> <i class="fa-solid fa-xmark text-white"></i> Leave </a>`;

        $("#workspaces").prepend(`
            <li class="mt-3">
                <div class="nearly-pepls">
                    ${ figure }
                    <div class="pepl-info text-center">
                        ${ img }
                        <h2>
                            <a href="/workspace/${workspace.id}" title="">${workspace.name}</a>
                        </h2>
                        <em></em>
                        <br/>
                        <div class="float-right">
                            <a href="/workspace/${workspace.id}" class="btn btn-sm btn-success"><i class="fa-solid fa-up-right-and-down-left-from-center text-white"></i> Enter </a>
                            ${ btnLeave }
                            ${ btnDelete }
                        </div>
                    </div>
                </div>
            </li>
    `);
    }

});