
$(document).ready(function(){


    // filter function
    (function($) {
        $("#cs tbody").addClass("search");
        $('#searchInput').keyup(function() {
            var rex = new RegExp($(this).val(), 'i');
            $('.search tr ').hide();
            //Recusively filter the jquery object to get results.
            $('.search tr ').filter(function(i, v) {
                //Get the 3rd column object
                var $t = $(this).children(":eq(" + "1" + ")");
                return rex.test($t.text());
            }).show();
        })
    }(jQuery));
    
});