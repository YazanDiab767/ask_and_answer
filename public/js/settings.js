$(document).ready(function(){
    //update name
    $("#formUpdateName").on('submit', function(e){
        e.preventDefault();
        $("#saveName").attr('disabled',true);
        let th = $(this);
        let data = new FormData(this);
        $.ajax({
            url : th.attr('action'),
            type : "POST",
            data : data,
            success: function() {
                $("#resultNameForm").show();
                $("#resultNameForm").html(`
                    <div class = "alert alert-success mt-3"> Your name has been successfully changed </div>
                `);
                setTimeout(function(){
                    location.reload();
                }, 2300);
            },
            error: function(data){
                let errors = data.responseJSON.errors
                $("#resultNameForm").show();

                $("#resultNameForm").html(`<div class = "alert alert-danger mt-3">${errors[Object.keys(errors)[0]]}</div>`);
              
                $("#saveName").attr('disabled',false);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    //update email
    $("#formUpdateEmail").on('submit', function(e){
        e.preventDefault();
        $("#saveEmail").attr('disabled',true);
        let th = $(this);
        let data = new FormData(this);
        $.ajax({
            url : th.attr('action'),
            type : "POST",
            data : data,
            success: function() {
                $("#resultEmailForm").show();
                $("#resultEmailForm").html(`
                    <div class = "alert alert-success mt-3"> Your email has been successfully changed </div>
                `);
                setTimeout(function(){
                    location.reload();
                }, 2300);
            },
            error: function(data){
                let errors = data.responseJSON.errors
                $("#resultEmailForm").show();

                $("#resultEmailForm").html(`<div class = "alert alert-danger mt-3">${errors[Object.keys(errors)[0]]}</div>`);
                
                $("#saveEmail").attr('disabled',false);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    //update email
    $("#formUpdatePassword").on('submit', function(e){
    e.preventDefault();
    $("#savePassword").attr('disabled',true);
    let th = $(this);
    let data = new FormData(this);
    $.ajax({
        url : th.attr('action'),
        type : "POST",
        data : data,
        success: function() {
            $("#resultPasswordForm").show();
            $("#resultPasswordForm").html(`
                <div class = "alert alert-success mt-3"> Your password has been successfully changed </div>
            `);
            setTimeout(function(){
                location.reload();
            }, 2300);
        },
        error: function(data){
            let errors = data.responseJSON.errors
            $("#resultPasswordForm").show();

            $("#resultPasswordForm").html(`<div class = "alert alert-danger mt-3">${errors[Object.keys(errors)[0]]}</div>`);
            
            $("#savePassword").attr('disabled',false);
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

});