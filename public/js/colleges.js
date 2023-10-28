$(document).ready(function(){

    // filter colleges
    $("#searchInput").keyup(function(){
        let input = $(this).val();

        $("#body .card").each(function(){
            if ($(this).text().search(new RegExp(input, "i")) < 0)
                $(this).hide();
            else
                $(this).show();
        });
    });

    $("#setResource").on('submit', function(e){
        e.preventDefault();
        $("#errorsR").hide();
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        data.append("user_id", user_id);
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: data,
            success: function(data){
                
                alert("It has been sent to the course supervisor and will be reviewed and accepted as soon as possible\nThank you");
                $(".modal").modal('hide');
                $("#title").val("");
                $("#link").val("");
            },
            error: function (data){
                $("#errorsR").show();
                let errors = data.responseJSON.errors;
                $.each( errors , function(i,v){
                    $("#errorsR").html( errors[i] );
                    return false;
                } );
            },
            processData: false,
            contentType: false,
            cache: false
        });

    });
});