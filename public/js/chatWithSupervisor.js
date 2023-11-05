$(document).ready(function(){

    let page = '';
    let count_page = 1;
    let flag_new_message = 0;

    $(".chatting-area").animate({ scrollTop: $('.chatting-area').prop("scrollHeight")}, 1000);


    //Listen New Messages
    Echo.private(`message_with_supervisor.${course_id}.${user}`)
    .listen('NewMessageWithSupervisor', (message) => {
        flag_new_message = 1;
        addMessage( message.message );
        flag_new_message = 0;
        $(".chatting-area").animate({ scrollTop: $('.chatting-area').prop("scrollHeight")}, 1000);
    })

    //formSendMessage
    $("#formSendMessage").on('submit', function(e){
        e.preventDefault();
        let data = new FormData(this);
        let token = $("meta[name='csrf-token']").attr("content");
        let sender = "student";
        if ( type == "supervisor " )
            sender = "supervisor";
        data.append("sender" , sender);
        $.ajax({
            type: "POST",
            url: `/setChatWithSupervisor/${course_id}/${user}`,
            data: data,
            success: function(data){
                flag_new_message = 1;
                addMessage( data[0] );
                flag_new_message = 0;
                $("#text").val('');
                $(".chatting-area").animate({ scrollTop: $('.chatting-area').prop("scrollHeight")}, 1000);
            },
            error: function(data){
                alert("Error in send this message !");
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });

    $("body").on('click','.btnGetMoreMessages', function(e){
        e.preventDefault();
        page = `/?page=${++count_page}`;
        $(".chatting-area").animate({ scrollTop: 0}, 1000);
        getMessages();
    });

    //get messages
    function getMessages(){

        $.get(`${host}getChatWithSupervisor/${course_id}/${user}` + page, function (data) {
            let messages = data.data;
            $(".btnGetMoreMessages").show();
            if (Object.keys(messages).length < 10)
                $(".btnGetMoreMessages").hide();

            for (const message of messages)
            {
                addMessage( message );
            }
        });
    }
    getMessages();


    function addMessage(message)
    {
        let sender = "student";
        if ( type == "supervisor " )
            sender = "supervisor";

        let msg = '';

        if ( message.sender == sender )
            msg = `
                <li class="me">
                    <figure><img src="/storage/${user_image}" style="min-width: 35px; min-height: 33px; max-width: 35px; max-height: 33px;"></figure>
                    <p>${message.text}</p>
                </li>
            `
        else
            msg = `
                <li class="you">
                    <figure><img src="/storage/users/user.png" style="min-width: 35px; min-height: 33px; max-width: 35px; max-height: 33px;"></figure>
                    <p>${message.text}</p>
                </li>
            `;

         if ( flag_new_message == 1 )
            $(".chatting-area").append(`${msg}`);
        else
            $(".chatting-area").prepend(`${msg}`);
    }

});