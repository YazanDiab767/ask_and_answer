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

});