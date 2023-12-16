$(document).ready(function () {

    //Initialization
    $("#collegesCount").html(colleges_count);

    $("#btnAddNewCollege").on('click', function (e) {
        $(".modal").removeClass('d-none');
    });

    $("#addCollege").on('click', function (e) {
        e.preventDefault();
        $("#formAddCollege").submit();
    });

    $("#formAddCollege").on('submit', function (e) {
        e.preventDefault();
        $("#addCollege").attr('disabled', true);
        let url = $(this).attr('action');
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        $(".alert-danger").remove();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data) {
                $("#collegesCount").html(++colleges_count);
                $("#addCollege").attr('disabled', false);
                $("#colleges").prepend(`
                    <tr class="college">
                        <td class="align-middle"> <span class="text-success"><b>New</b></span> </td>
                        <td class="align-middle"> ${data.name} </td>
                        <td class="align-middle"> <img class="rounded" width="150" height="100" src="${host}storage/${data.image}" /> </td>
                        <td class="align-middle text-right" style="width: 20%;">
                        <a href="${data.id}/${data.name}" class="btn btn-success btnEditCollege w-50" data-toggle="modal" data-target=".editCollege"> <i class="fas fa-edit"></i> Edit  </a>
                        </td>
                        <td class="align-middle text-left" style="width: 20%;">
                            <form action="${host}control_panel/colleges/${data.id}" class="formDeleteCollege" method="POST">
                                <input type="hidden" name="_token" value="${token}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger delete_college w-50"> <i class="fas fa-trash"></i> Delete  </button>
                            </form>
                        </td>
                    </tr> 
                `);

                closeModal();

                $("#formAddCollege").trigger("reset");
            },
            error: function (data) {
                $("#addCollege").attr('disabled', false);
                let errors = data.responseJSON.errors;
                for (error in errors)
                    $("." + error).after(`<div class = "alert alert-danger" style="padding: 3px;"> <i class="fa-solid fa-triangle-exclamation"></i> ${errors[error]}</div>`);
            },
            cache: false,
            processData: false,
            contentType: false
        });

    });

    $("body").on('submit', '.formDeleteCollege', function (e) {
        e.preventDefault();
        let t = $(this);
        let data = new FormData(this);
        if (confirm("Are you sure you want to delete this college ?")) {
            $.ajax({
                type: 'POST',
                url: t.attr('action'),
                data: data,
                success: function (data) {
                    $("#collegesCount").html(--colleges_count);
                    t.closest('tr').hide(1100);
                },
                error: function (data) {
                    alert("There is a problem in delete this college, please try again ");
                },
                contentType: false,
                cache: false,
                processData: false
            });
        }
    });

    //edit college
    var thisRow;
    var count;
    $("body").on('click', '.btnEditCollege', function (e) {
        e.preventDefault();

        let link = $(this).attr('href');
        let id = link.split('/')[0];
        let name = link.split('/')[1];
        count = link.split('/')[2];
        thisRow = $(this);

        $("#collegeName").val(name);
        $(".modal").removeClass('d-none');
        $("#formUpdateCollege").attr('action', `${host}control_panel/colleges/${id}`);
    });

    //update college
    $("#updateCollege").on('click', function (e) {
        e.preventDefault();
        $("#formUpdateCollege").submit();
    });

    $('#formUpdateCollege').on('submit', function (e) {
        e.preventDefault();
        $("#updateCollege").attr('disabled', true);
        let url = $(this).attr('action');
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        $(".alert-danger").remove();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data) {
                $("#updateCollege").attr('disabled', false);
                thisRow.closest('.college').html(`
                   
                        <td class="align-middle"> ${count} </td>
                        <td class="align-middle"> ${data.name} </td>
                        <td class="align-middle"> <img class="rounded" width="150" height="100" src="${host}storage/${data.image}" /> </td>
                        <td class="align-middle text-right" style="width: 20%;">
                        <a href="${data.id}/${data.name}" class="btn btn-success btnEditCollege w-50" data-toggle="modal" data-target=".editCollege"> <i class="fas fa-edit"></i> Edit  </a>
                        </td>
                        <td class="align-middle text-left" style="width: 20%;">
                            <form action="${host}control_panel/colleges/${data.id}" class="formDeleteCollege" method="POST">
                                <input type="hidden" name="_token" value="${token}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger delete_college w-50"> <i class="fas fa-trash"></i> Delete  </button>
                            </form>
                        </td>
                 
                `);

                closeModal();
            },
            error: function (data) {
                $("#updateCollege").attr('disabled', false);
                let errors = data.responseJSON.errors;
                for (error in errors)
                    $(".u_" + error).after(`<div class = "alert alert-danger">${errors[error]}</div>`);
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });




    $('body').on('click', '.btnShowMajors', function (e) {
        e.preventDefault();
        $("#majors").html(``);
        let data = $(this).closest('.college').find('.btnEditCollege').attr('href');

        count = data.split('/')[1];
        college_id = data.split('/')[0];

        let token = $("meta[name='csrf-token']").attr("content");

        //get majors for college
        let url = `${host}control_panel/college/getMajors/${college_id}`
        $.get(url, function (data) {
            console.log(data);
            for (const item of data) {


                $("#majors").append(`
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
                            ${btnSharedFrom}
                        </td>
                    </tr>
                `);
            }
        });

        // $(".titleDiv").html(` <b> <i class="fa-solid fa-swatchbook"></i> Resources - ${name} </b> `);

        // $("#setResource").attr('action', `${host}control_panel/courses/setResource/${id}`);

    });

});