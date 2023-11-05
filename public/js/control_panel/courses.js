$(document).ready(function(){

    //Initialization
    $("#CoursesCount").html( courses_count );

    
    $("#btnAddNewCourse").on('click', function(e){
        $(".modal").removeClass('d-none');
    });

    $("#addCourse").on('click', function(e){
        e.preventDefault();
        $("#formAddCourse").submit();
    });
    
    $("#formAddCourse").on('submit', function(e){
        e.preventDefault();
        $("#addCourse").attr('disabled' , true);
        let url = $(this).attr('action');
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        $(".alert-danger").remove();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                $("#CoursesCount").html( ++courses_count );
                $("#addCourse").attr('disabled' , false);
                $("#courses").prepend(`
                    <tr>
                        <td class="align-middle"> <span class="text-success"> New </span> </td>
                        <td class="align-middle"> ${data.name} </td>
                        <td class="align-middle" style="width: 12%;"> <a href="#" class="btn btn-info btnShowresources w-100" data-toggle="modal" data-target=".divResources" > <i class="fa-solid fa-swatchbook"></i> Resources  </a> </td>
                        <td class="align-middle" style="width: 12%;"> <a href="#" class="btn btn-success btnEditCourse w-100" data-toggle="modal" data-target=".editCourse" > <i class="fas fa-edit"></i> Edit  </a> </td>
                        <td class="align-middle" style="width: 12%;">
                            <form action="${host}control_panel/courses/${data.id}" class="formDeleteCourse" method="POST">
                                <input type="hidden" name="_token" value="${token}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger text-white delete_college w-100"> <i class="fas fa-trash"></i> Delete  </button>
                            </form>
                        </td>
                    </tr>  
                `);

                closeModal();

                $("#formAddCourse").trigger("reset");
            },
            error: function(data){
                $("#addCourse").attr('disabled' , false);
                let errors = data.responseJSON.errors;
                for (error in errors)
                    $("."+error).after(`<div class = "alert alert-danger" style="padding: 3px;"> <i class="fa-solid fa-triangle-exclamation"></i> ${errors[error]}</div>`);
            },
            cache: false,
            processData: false,
            contentType: false
        });

    });

    $("#college_id").on('change', function(e){
        $.ajax({
            type: "GET",
            url: "/control_panel/courses/getCoursesCollege/" + $("#college_id").val() + "/",
            success: function(data){
                $("#courses").html(''); // clear courses
                courses_count = 1;
                for (const item of data) {
                    $("#courses").append(`     
                        <tr>
                            <td class="align-middle"> ${ courses_count } </td>
                            <td class="align-middle"> ${ item.name} </td>
                            <td class="align-middle" style="width: 12%;"> <a href="#" class="btn btn-info w-100" data-toggle="modal" data-target=".divResources" > <i class="fa-solid fa-swatchbook"></i> Resources  </a> </td>
                            <td class="align-middle" style="width: 12%;"> <a href="${ item.id }/${ item.name }/${courses_count++}/${item.college_id}" class="btn btn-success btnEditCourse w-100" data-toggle="modal" data-target=".editCourse" > <i class="fas fa-edit"></i> Edit  </a> </td>
                            <td class="align-middle" style="width: 12%;">
                                <button class="btn btn-danger delete_college w-100"> <i class="fas fa-trash"></i> Delete  </button>
                            </td>
                        </tr>  
                    `);
                }

                
         
            },
            error: function(data){
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });
  
    $("body").on('submit' , '.formDeleteCourse' , function(e){
        e.preventDefault();
        let t = $(this);
        let data = new FormData(this);
        if ( confirm("Are you sure you want to delete this Course ?") )
        {
            $.ajax({
                type: 'POST',
                url: t.attr('action'),
                data: data,
                success: function(data){
                    $("#CoursesCount").html( --courses_count );
                    t.closest('tr').hide(1100);
                },
                error: function(data){
                    alert("There is a problem in delete this Course, please try again ");
                },
                contentType: false,
                cache: false,
                processData: false
            });
        }
    });

    $("body").on('submit' , '.formAcceptResource' , function(e){
        e.preventDefault();
        let t = $(this);
        let data = new FormData(this);
        if ( confirm("Are you sure you want to accpet this resource ?") )
        {
            $.ajax({
                type: 'POST',
                url: t.attr('action'),
                data: data,
                success: function(data){
                    t.hide();
                },
                error: function(data){
                    alert("There is a problem in this operation ! ");
                },
                contentType: false,
                cache: false,
                processData: false
            });
        }
    });
    

    //edit Course
    var thisRow;
    var count;
    $("body").on('click' , '.btnEditCourse' , function(e){
        e.preventDefault();

        let link = $(this).attr('href');
        let id = link.split('/')[0];
        let name = link.split('/')[1];
        count = link.split('/')[2];
        college_id = link.split('/')[3];
        thisRow = $(this);

        $("#course_name").val( name );
        $("#formUpdateCourse").attr('action' , `${host}control_panel/courses/${id}`);
        $(".modal").removeClass('d-none');
    });
    
    //update Course
    $("#updateCourse").on('click' , function(e){
        e.preventDefault();
        $("#formUpdateCourse").submit();
    });

    $('#formUpdateCourse').on('submit', function(e){
        e.preventDefault();
        $("#updateCourse").attr('disabled' , true);
        let url = $(this).attr('action');
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        $(".alert-danger").remove();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                $("#updateCourse").attr('disabled' , false);
                thisRow.closest('tr').html(`
                    <td class="align-middle"> ${ count }  </td>
                    <td class="align-middle"> ${ data.name} </td>
                    <td class="align-middle" style="width: 12%;"> <a href="#" class="btn btn-info btnShowresources w-100" data-toggle="modal" data-target=".divResources" > <i class="fa-solid fa-swatchbook"></i> Resources  </a> </td>
                    <td class="align-middle" style="width: 12%;"> <a href="${ data.id }/${ data.name }" class="btn btn-success btnEditCourse w-100" data-toggle="modal" data-target=".editCourse" > <i class="fas fa-edit"></i> Edit  </a> </td>
                    <td class="align-middle" style="width: 12%;">
                        <form action="${host}control_panel/courses/${data.id}" class="formDeleteCourse" method="POST">
                            <input type="hidden" name="_token" value="${token}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger text-white delete_college w-100"> <i class="fas fa-trash"></i> Delete  </button>
                        </form>
                    </td>
            `);

             closeModal();
            },
            error: function(data){
                // $("#updateCourse").attr('disabled' , false);
                // let errors = data.responseJSON.errors;
                // for (error in errors)
                //     $(".u_"+error).after(`<div class = "alert alert-danger">${errors[error]}</div>`);
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });


    $('body').on('click' , '.btnShowresources' , function(e){
        e.preventDefault();
        $("#resources").html(``);
        let data = $(this).closest('.row_course').find('.btnEditCourse').attr('href');
        let id = data.split('/')[0];
        let name = data.split('/')[1];
        count = data.split('/')[2];
        college_id = data.split('/')[3];

        let token = $("meta[name='csrf-token']").attr("content");

        //get resources for course
        let url = `${host}control_panel/courses/getResources/${id}`
        $.get(url , function(data){
            for (const item of data)
            {
                let sharedFrom = JSON.parse( item.sharedFrom );
                let nameSharedFrom = ''
                let btnSharedFrom = '';
                if (sharedFrom)
                {
                    nameSharedFrom = `<label class="text-info">Shared from: ${sharedFrom.username}</label><br/>`;
                    if (sharedFrom.accepted == 0 )
                    {
                        btnSharedFrom = `
                            <form action="${host}control_panel/courses/acceptResource/${item.id}" class="formAcceptResource mt-1" method="POST">
                                <input type="hidden" name="_token" value="${token}">
                                <input type="hidden" name="_method" value="PUT">
                                <button class="btn btn-info text-white accept_resource w-50"> <i class="fa-solid fa-check-double"></i> Accept  </button>
                            </form> 
                        `;
                    }
                }

                $("#resources").append(`
                    <tr>
                        <td> ${item.title} <br/> ${nameSharedFrom} </td>
                        <td>--</td>
                        <td> ${item.name} </td>
                        <td style="width: 40%">
                            <form action="${host}control_panel/courses/deleteResource/${item.id}" class="formDeleteCourse" method="POST">
                                <input type="hidden" name="_token" value="${token}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger text-white delete_college w-50"> <i class="fas fa-trash"></i> Delete  </button>
                            </form> 
                            ${ btnSharedFrom }
                        </td>
                    </tr>
                `);
            }
        });

        $(".titleDiv").html(` <b> <i class="fa-solid fa-swatchbook"></i> Resources - ${ name } </b> `);

        $("#setResource").attr('action' , `${host}control_panel/courses/setResource/${id}`);

    });

    $('body').on('click' , '.btnShowMessages' , function(e){
        e.preventDefault();
        $("#chats").html(``);
        let data = $(this).closest('.row_course').find('.btnEditCourse').attr('href');
        let id = data.split('/')[0];

        let token = $("meta[name='csrf-token']").attr("content");

        //get resources for course
        let url = `${host}control_panel/getChatsCourse/${id}`
        let i = 0;
        $.get(url , function(data){
            for (const item of data)
            {
                $("#chats").append(`
                    <tr style="vertical-align: middle">
                        <td> ${++i} </td>
                        <td>
                            <img src="/storage/${ item.user.image }" style="min-width: 60px; min-height: 60px; max-width: 60px; max-height: 60px; border-radius: 30px ">
                            <b> ${item.user.name} </b>
                        </td>
                        <td>
                            <a href="/chatWithSupervisor/${id}/${item.user.id}" class="btn btn-info w-100"><i class="fa-solid fa-arrow-up-right-from-square"></i> Go to chat</a>
                        </td>
                    </tr>
                `);
            }
        });

    });


    // new resource
    $("#btn_addResource").on('click', function(){
        $("#setResource").submit();
    });

    $(".btnCloseResources").on('click', function(){
        $('.modal-backdrop').remove();
    });

    $(".btnAddNewResource").on('click', function(){
        $(".modal").removeClass('d-none');
    });

    
    $("#setResource").on('submit', function(e){
        e.preventDefault();
        $("#errorsR").hide();
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: data,
            success: function(data){
                $("#resources").append(`
                    <tr>
                        <td> ${data[0].title} </td>
                        <td>--</td>
                        <td> ${data[0].name} </td>
                        <td>
                            <form action="${host}control_panel/courses/deleteResource/${data[0].id}" class="formDeleteCourse" method="POST">
                                <input type="hidden" name="_token" value="${token}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger text-white delete_college w-50"> <i class="fas fa-trash"></i> Delete  </button>
                            </form> 
                        </td>
                    </tr>
                `);
                $('.modal-backdrop').remove();
                $("#newResource").modal('hide');
                $("#newResource").addClass('d-none');
                $('.divResources').css('overflow-y', 'auto');
                $("body").append(`<div class="modal-backdrop"></div>`);
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