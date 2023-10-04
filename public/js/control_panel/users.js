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