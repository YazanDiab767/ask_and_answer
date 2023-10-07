$(document).ready(function(e){

    //show more
    var page = 2;
    $("#showMoreUsers").on('click', function(){
        $("#showMoreUsers").attr('disabled', true);
        $.get( `${host}control_panel/getMoreUsers` + "/?page=" + (page++) , function(data){
            $("#showMoreUsers").attr('disabled', false);
            if (Object.keys(data).length == 0)  $("#showMoreUsers").hide();
            $("#users").append( data ); 
        });
    });

    //conformations messages
    $('body').on('submit','.delete',function(){return confirm("Are you sure you want to block this user?");});

    //change role
    $("body").on("submit",".makeSupervisor, .makeUser, .makeAdmin" , function(e){
        e.preventDefault();
        if ( ! confirm("Are you sure to do this convert ?") )
            return ;
        let data = new FormData(this);
        let t = $(this);
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: data,
            success: function(data){
                t.closest('tr').replaceWith( data );
            },
            error: function(data){
                alert("There is a problem, please try again");
            },
            contentType: false,
            cache: false,
            processData: false
        });
    });
   
    $("#btnSetPermissions").on('click', function(){
        $("#formSetPermissions").submit();
    });

    let row;
    
    $("body").on('click', '.btnMakeSupervisor', function(e){
        let link = $(this).attr('href')
        let data = JSON.parse(link);
        let id = data.id;
        let permissions_user = JSON.parse(data.permissions);
        
        $("#formSetPermissions").trigger("reset");

        if ( permissions_user.hasOwnProperty("colleges") )
            $("#check_colleges").prop( "checked", true );

        if ( permissions_user.hasOwnProperty("questions_complaints") )
            $("#check_questions_complaints").prop( "checked", true );

        if ( permissions_user.hasOwnProperty("check_course") )
            $("#check_course").prop( "checked", true );
            
        row = $(this);
        $(".modal").removeClass('d-none');
        $("#formSetPermissions").attr('action', `http://127.0.0.1:8000/control_panel/users/changeRole/user/${id}/supervisor`);
    });

    //set 
    $("body").on("submit","#formSetPermissions" , function(e){
        e.preventDefault();
        if ( ! confirm("Are you sure to do this convert ?") )
            return ;
        let data = new FormData(this);
        let t = $(this);
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: data,
            success: function(data){
                row.closest('tr').replaceWith( data );
                $(".modalSupervisor").modal('hide');
                closeModal();
            },
            error: function(data){
                alert("There is a problem, please try again");
            },
            contentType: false,
            cache: false,
            processData: false
        });
    });

    // $("#college_id").on('change', function(e){
    //     e.preventDefault();
    //     $.get( `${host}control_panel/courses/getCoursesCollege/` + $("#college_id").val() , function(data){
    //         for (const item of data){
    //             // $("#course_id").append(`
    //             //     <option value="${item.id}">${item.name}</option>
    //             // `);
    //             $('.mdb-course_id').material_select('destroy');
    //             $.each(data.result, function(i, field){
    //             $('#studenttags').append('<option value="'+field.id+'">'+field.class_name+"-"+field.class_nick_name+'['+field.enrolled_year+' Intake]'+'</option>');
    //             });
    //             $('.mdb-select').material_select();
    //         }
    //     });
    // });

    //filter
    $("#inputSearch").on('keyup' , function(e){
        $.get(`${host}control_panel/filter/users`+"?search="+$("#inputSearch").val() , function(data){
            $("#users").html( data );
        });
        $("#formShowMoreUser").hide();
    });

    //stop user
    $("body").on("click" , ".stopUser" , function(e){
        e.preventDefault();
        let data = new FormData(this);
        let t = $(this);
        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: data,
            success: function(data) {
                t.closest('tr').replaceWith( data );
            },
            error: function(data){
                $(".loading").hide();
                alert("There is a problem in this operation");
            },
            contentType: false,
            cache: false,
            processData: false
        });

    });
    

    //restore user
    $("body").on("submit" , ".restore" , function(e) {
        e.preventDefault();
        let data = new FormData(this);
        let t = $(this);
        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: data,
            success: function(data) {
                t.closest('tr').replaceWith( data );
            },
            error: function(data){
                alert("There is a problem in restore !");
            },
            contentType: false,
            cache: false,
            processData: false
        });
});

    //delete user
    $("body").on("submit" , ".delete" , function(e) {
        e.preventDefault();
        let data = new FormData(this);
        let t = $(this);
        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: data,
            success: function(data) {
                t.closest('tr').hide(700);
            },
            error: function(data){
                alert("There is problem in delete");
            },
            contentType: false,
            cache: false,
            processData: false
        });
    });

});