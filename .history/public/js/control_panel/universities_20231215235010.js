$(document).ready(function () {

    //Initialization
    $("#universitiesCount").html(universities_count);

    $("#btnAddNewUniversity").on('click', function (e) {
        $(".modal").removeClass('d-none');
    });

    $("#addUniversity").on('click', function (e) {
        e.preventDefault();
        $("#formAddUniversity").submit();
    });

    $("#formAddUniversity").on('submit', function (e) {
        e.preventDefault();
        $("#addUniversity").attr('disabled', true);
        let url = $(this).attr('action');
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        $(".alert-danger").remove();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data) {
                $("#universitiesCount").html(++universities_count);
                $("#addUniversity").attr('disabled', false);
                $("#universities").prepend(`
                    <tr class="university">
                        <td class="align-middle"> <span class="text-success"><b>New</b></span> </td>
                        <td class="align-middle"> ${data.created_at} </td>
                        <td class="align-middle"> ${data.name} </td>
                        <td class="align-middle text-right" style="width: 20%;">
                        <a href="${data.id}/${data.name}" class="btn btn-success btnEditUniversity w-50" data-toggle="modal" data-target=".editUniversity"> <i class="fas fa-edit"></i> Edit  </a>
                        </td>
                        <td class="align-middle text-left" style="width: 20%;">
                            <form action="${host}control_panel/universities/${data.id}" class="formDeleteUniversity" method="POST">
                                <input type="hidden" name="_token" value="${token}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger delete_university w-50"> <i class="fas fa-trash"></i> Delete  </button>
                            </form>
                        </td>
                    </tr> 
                `);

                closeModal();

                $("#formAddUniversity").trigger("reset");
            },
            error: function (data) {
                $("#addUniversity").attr('disabled', false);
                let errors = data.responseJSON.errors;
                for (error in errors)
                    $("." + error).after(`<div class = "alert alert-danger" style="padding: 3px;"> <i class="fa-solid fa-triangle-exclamation"></i> ${errors[error]}</div>`);
            },
            cache: false,
            processData: false,
            contentType: false
        });

    });

    $("body").on('submit', '.formDeleteUniversity', function (e) {
        e.preventDefault();
        let t = $(this);
        let data = new FormData(this);
        if (confirm("Are you sure you want to delete this university ?")) {
            $.ajax({
                type: 'POST',
                url: t.attr('action'),
                data: data,
                success: function (data) {
                    $("#universitiesCount").html(--universities_count);
                    t.closest('tr').hide(1100);
                },
                error: function (data) {
                    alert("There is a problem in delete this University, please try again ");
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
        $("#formUpdateCollege").attr('action', `${host}control_panel/universities/${id}`);
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
                            <form action="${host}control_panel/universities/${data.id}" class="formDeleteCollege" method="POST">
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

});