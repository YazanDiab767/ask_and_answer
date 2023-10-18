$(document).ready(function(){

    $(".central-meta").hide();
    $("#tap_posts").show();

    $("#btn_posts").on('click', function(e){
        e.preventDefault();
        $(".central-meta").hide();
        $("#tap_posts").show(250);
        $(".btnTaps").removeClass('active');
        $("#btn_posts").addClass('active');
    });

    $("#btn_info").on('click', function(e){
        e.preventDefault();
        $(".central-meta").hide();
        $("#tap_info").show(250);
        $(".btnTaps").removeClass('active');
        $("#btn_info").addClass('active');
    });


    $("#btn_activities").on('click', function(e){
        e.preventDefault();
        $(".central-meta").hide();
        $("#tap_activity").show(250);
        $(".btnTaps").removeClass('active');
        $("#btn_activities").addClass('active');
    });
    $("#profile_photo").on('change',function(e){
        e.preventDefault();
        let data = new FormData($("#form_edit_photo")[0]);
        $.ajax({
            url: '/profile/updateImage',
            type: 'POST',
            data: data,
            success: function(data){
                location.reload();
            },
            error: function(data){

                alert("Error in add this photo !!");
            },
            cache: false,
            contentType: false,
            processData: false
        });

    });
});