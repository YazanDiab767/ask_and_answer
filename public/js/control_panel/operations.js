$(document).ready(function() {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //delete
    $("body").on('click' , '.btnDelete' , function(e){
        e.preventDefault();
        let t = $(this);
        let url = $(this).attr('href');
        $.ajax({
            type: "POST",
            url: url,
            success: function(){
                t.closest('.tr').remove();
            },
            error: function(){
                alert("There is problem, please try again");
            },
            cache: false,
            processData: false,
            contentType: false
        });

    });

    //show more
    var page = 2;
    $("#showMore").on('click', function(e){
        e.preventDefault();
        $("#showMore").attr('disabled' , true);
        $.get("/control_panel/operationsLog/getMore/?page=" + (page++) , function(data){
            $("#showMore").attr('disabled' , false);
            if (Object.keys(data).length == 0)
                $("#showMore").hide();
            $("#operations_body").append( data );
        });
    });

    //filter
    $("#formFilter").on('submit', function(e){
        e.preventDefault();
        let url = $(this).attr('action');
        $.get(url + "?search="+$("#inputSearch").val(), function(data){
            $("#operations_body").html( data );
        });
        $('#showMore').hide();
    });

});