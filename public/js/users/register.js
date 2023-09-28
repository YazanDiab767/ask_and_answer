$(document).ready(function(){

    $("body").on('submit' , '#formRegister' , function(e){
        e.preventDefault();

        $("#btn_register").attr('disabled' , true);
        let url = $(this).attr('action');
        let data = new FormData(this);
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                $(".alert-danger").remove();

                $("#result").html(' <b> <i class="fas fa-check-circle"></i> Your account has been registered successfully  </b> ');
                $("#result").show();
               
                setTimeout(function(){
                    window.location.assign('/main');
                } , 2000);
                $("#btn_register").attr('disabled' , false);
            },
            error: function(data){
                $("#btn_register").attr('disabled' , false);

                let errors = data.responseJSON.errors;
                $(".alert-danger").remove();
                for (error in errors)
                {
                    $("#r_"+error).after(`
                        <div class="alert alert-danger" style="padding: 3px;" role="alert">
                            <strong> ${ errors[ error ]  } </strong>
                        </div>
                    `);
                }

            },
            cache: false,
            processData: false,
            contentType: false
        });

    });

});
