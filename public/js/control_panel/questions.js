
//stop question
function stopQuestion(question_id)
{
    let note = $("#note").val();
    $.ajax({
        type : "POST" ,
        url: `${host}control_panel/questions/${question_id}/stop`,
        data: "note=" + note,
        success: function(data){
            search();
        },
        error: function(data){
            alert("يوجد مشكلة في توقيف السؤال");
        }
    });
    return ;
}

//restore question
function returnQuestion(question_id)
{
    $.ajax({
        type : "POST" ,
        url: `${host}control_panel/questions/${question_id}/retrunQuestion`,
        success: function(data){
            $("#btnReturnQuestion").attr('disabled' , false);
            $("#question").html( data );
            search();
        },
        error: function(data){
            $("#btnReturnQuestion").attr('disabled' , false);
            alert("يوجد مشكلة في تفعيل السؤال");
        }
    });
    return ;
}

function search()
{
    let question_id = $("#question_id").val();

    $.ajax({
        type : "GET" ,
        url: `${host}control_panel/questions/${question_id}/get`,
        data: null,
        success: function(data){
            let status;
            let note = '';
            if ( Object.keys(data).length < 1)
            {
                $("#question_number").html(`<lable class="text-danger"><b>Not Found</b></labe>`);
                $("#student_name").html('');
                $("#college_course").html( '' );
                $("#date_time").html( '');
                $("#visit_question").html('');
                $("#status_question").html('');
                return;
            }
            if ( data[0].active )
            {
                status = `
                    <label class="text-success font-weight-bold">Active</label>
                    <button class="btn btn-danger inactive ml-5" onclick="stopQuestion(${data[0].id})"> <i class="fa-solid fa-toggle-off"></i> Inavtive  </button>
                     <textarea class="form-control mt-3"  id="note" rows="3" cols="30" placeholder = "A note on why the question was stopped"></textarea>
                `;
            } else {
                status = `
                <label class="text-danger font-weight-bold">Inactive</label>
                <button class="btn btn-success active ml-5" onclick="returnQuestion(${data[0].id})"> <i class="fa-solid fa-toggle-on"></i> Avtive  </button>
            `;
                note = jQuery.parseJSON( data[0].note );
            }
        

            $("#question_number").html( data[0].id );
            $("#student_name").html( data[0].username );
            $("#college_course").html( ` ${data[0].college_name} / ${data[0].course_name} ` );
            $("#date_time").html( data[0].created_at );
            $("#visit_question").html(` <a href="${host}questions/${data[0].id}" class="text-info"> <i class="fa-solid fa-eye"></i> Visit Question</a> `);
            $("#status_question").html(status);
            if ( ! data[0].active )
                $("#comments").html( "<b>Stopped by : " + note.stopedBy + "</b>,<br/> note : " + note.note );
            console.log( note );
            // college_course
            
        },
        error: function(data){
        }
    });
}

$(document).ready(function(){

    //search on question based on question id
    
    $("#question_id").on('keypress',function(e){

        if ( e.which == 13 )
        {
            e.preventDefault();
            search();
        }
    });

});