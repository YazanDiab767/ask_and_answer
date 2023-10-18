$(document).ready(function(e){
    $("body").on('click', '.btnToggleComments', function(e){
        e.preventDefault();
        let id = $(this).attr('href');
        let btn = $(this);
        $.ajax({
            type: "POST",
            url: `/question/enableDisableComments/${id}`,
            data: null,
            success: function(data){
                if ( data == 0 )
                    btn.replaceWith(`<a class="dropdown-item text-primary btnToggleComments" href="${id}"><i class="fa-solid fa-stop"></i> Stop comments</a>`);
                else
                    btn.replaceWith(`<a class="dropdown-item text-primary btnToggleComments" href="${id}"><i class="fa-solid fa-play"></i> Run comments</a>`);

            },
            error: function(data){
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });

    $("body").on('click' , '.saveQuestion' , function(e){
        e.preventDefault();
        let t = $(this);
        let id = t.attr('href');
        $.ajax({
            type: 'POST',
            url: `/question/saveQuestion/${id}`,
            success: function(data){
                t.replaceWith(`
                    <a class="dropdown-item text-success unsaveQuestion" href="${id}"> <i class="fa-regular fa-bookmark"></i> Unsave </a>
                `);
            }

        });

    });

    $("body").on('click' , '.unsaveQuestion' , function(e){
        e.preventDefault();
        let t = $(this);
        let id = t.attr('href');
        $.ajax({
            type: 'POST',
            url: `/question/unsaveQuestion/${id}`,
            success: function(data){
                t.replaceWith(`
                <a class="dropdown-item text-success saveQuestion" href="${id}"> <i class="fa-solid fa-bookmark"></i> Save </a>
                `);
            }

        });


    

    });

    $("body").on('click', '.btnDeleteQuestion' , function(e){
        e.preventDefault();
        if (confirm("***Are you sure delete this question !\nYou can't undo this") == false)
            return;

        let id = $(this).attr('href');
        let btn = $(this);
        $.ajax({
            type: "POST",
            url: `/question/delete/${id}`,
            data: null,
            success: function(data){
                // window.location.reload();
                btn.closest('.user-post').hide(500);
            },
            error: function(data){
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });


});
