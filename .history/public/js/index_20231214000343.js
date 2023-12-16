$(document).ready(function () {

    $("#showFormSignUp").on('click', function (e) {
        e.preventDefault();
        $(".card-login").hide();
        $(".card-sign-up").show(500);
    });

    $("#showLoginForm").on('click', function (e) {
        e.preventDefault();
        $(".card-sign-up").hide();
        $(".card-login").show(500);
    });

    $(".majors").select2({
        tags: true,
        createTag: function (params) {
            var term = $.trim(params.term);

            if (term === '') {
                return null;
            }

            return {
                id: -1,
                text: term,
                newTag: true // add additional parameters
            }
        }
    });

    $(".universities").select2({
        tags: true,

        createTag: function (params) {
            var term = $.trim(params.term);

            if (term === '') {
                return null;
            }

            return {
                id: -1,
                text: term,
                newTag: true // add additional parameters
            }
        }
    });

});