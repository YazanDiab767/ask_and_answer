$(document).ready(function(){
    var page = 2;
    $("#showMore").on('click' , function(){
        $("#showMore").attr('disabled' , true);
        $.get(`${host}control_panel/complaints/getMoreComplaints` + "/?page=" + (page++) , function (data) {
                data = data.data
                if (Object.keys(data).length == 0)
                {
                    $("#showMore").hide();
                    return ;
                }
                for ( const complaint of data )
                {
                    let handledBy = '';

                    if ( complaint.handledBy )
                    {
                        handledBy = `
                            <label class="text-success">
                            <i class="far fa-check-circle"></i> 
                            Done by: ${ complaint.handledBy }
                            </label> 
                        `;
                    }
                    else
                    {
                        handledBy = `
                        <a href="${ complaint.id }" class="btn btn-success btnDone"><i class="far fa-check-circle"></i>  Done  </a>
                        `;
                    }

                    $("#complaints").append(`
                    <tr>
                        <td class="align-middle"> ${ count++ } </td>
                        <td class="align-middle"> ${ complaint.created_at } </td>
                        <td class="align-middle"> ${ complaint.username } </td>
                        <td class="align-middle"> ${ complaint.question_id } </td>
                        <td class="align-middle"> ${ complaint.type } </td>
                        <td class="align-middle "> <a href="${ complaint.text }" class="btn btn-success showText" data-toggle="modal" data-target=".complaintText" > <i class="fa-solid fa-eye"></i> Show text  </a> </td>
                        <td class="align-middle ">
                            <td>
                                ${ handledBy }
                            </td>
                        </td>
                    </tr>  
                    `);
                }
                $("#showMore").attr('disabled' , false);
            }
        );
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("body").on('click' , '.btnDone' , function(e){
        e.preventDefault();
        $(this).attr('disabled' , true);
        let id = $(this).attr('href');
        let url = `${host}control_panel/complaints/doneBy/${id}`;
        let t = $(this);
        $.ajax({
            type: "POST",
            url: url,
            success: function(data){
                t.attr('disabled' , false);
                t.replaceWith(`
                    <label class="text-success">
                        <i class="far fa-check-circle"></i> 
                        Done by : ${name}
                    </label> 
                `);
            },
            error: function(data){
                t.attr('disabled' , false);
                alert("There is a problem :) PTA");
            }
        });
    });


    $("body").on('click', '.showText', function(e){
        e.preventDefault();
        let text = $(this).attr('href');
        $(".text_complaint").html(text);

    });

});