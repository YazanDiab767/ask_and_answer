$(document).ready(function(){

    let page = '';
    let count_page = 1;
    let flag_new_message = 0;
    let chat_page = 0; // 0 => chat with all , 1 => chat with private

    //Listen New Messages
    Echo.private(`message_workspace.${workspace}`)
    .listen('NewMessageWorkspace', (message) => {
        if ( message.message.reciver_id == 0 )
        {
            flag_new_message = 1;
            addMessageWithAll( message.message );
            flag_new_message = 0;
            $(".chatWithAll").animate({ scrollTop: $('.chatWithAll').prop("scrollHeight")}, 1000);

            if ( chat_page == 1 )
            {
                $(".linkChatWithAll .fa-comments").addClass('fa-bounce');
                $(".linkChatWithAll .fa-comments").addClass('text-danger');
            }
        }
        else
        {
            if ( message.message.reciver_id == user_id )
            {
                if ( admin_workspace == user_id)
                {
                    if ( sendTo == message.message.user_id  )
                    {
                        flag_new_message = 1;
                        addMessagePrivate( message.message );
                        flag_new_message = 0;
                        if ( chat_page == 0 )
                        {
                            $(".linkChatWithPrivate .fa-comments").addClass('fa-bounce');
                            $(".linkChatWithPrivate .fa-comments").addClass('text-danger');
                        }
                    }
                    return ;
                }
                else
                {
                    flag_new_message = 1;
                    addMessagePrivate( message.message );
                    flag_new_message = 0;
                    if ( chat_page == 0 )
                    {
                        $(".linkChatWithPrivate .fa-comments").addClass('fa-bounce');
                        $(".linkChatWithPrivate .fa-comments").addClass('text-danger');
                    }
                }
            }
            $(".chatWithAdmin").animate({ scrollTop: $('.chatWithAdmin').prop("scrollHeight")}, 1000);
        }
    });

    $(".linkChatWithAll").on('click', function(e){
        chat_page = 0;
        $(".linkChatWithAll .fa-comments").removeClass('fa-bounce');
        $(".linkChatWithAll .fa-comments").removeClass('text-danger');
        $(".chatWithAll").animate({ scrollTop: $('.chatWithAll').prop("scrollHeight")}, 1000);
    });

    $(".linkChatWithPrivate").on('click', function(e){
        chat_page = 1;
        $(".linkChatWithPrivate .fa-comments").removeClass('fa-bounce');
        $(".linkChatWithPrivate .fa-comments").removeClass('text-danger');
        $(".chatWithAdmin").animate({ scrollTop: $('.chatWithAdmin').prop("scrollHeight")}, 1000);
    });

    $(".chatWithAll").animate({ scrollTop: $('.chatWithAll').prop("scrollHeight")}, 1000);

    $("#formSendMessageToAll").on('submit', function(e){
        e.preventDefault();

        let url = $(this).attr('action');
        let data = new FormData(this);
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                $("#formSendMessageToAll").trigger("reset");
                flag_new_message = 1;
                addMessageWithAll(data);
                flag_new_message = 0;
                $(".chatWithAll").animate({ scrollTop: $('.chatWithAll').prop("scrollHeight")}, 1000);
            },
            error: function(data){
                alert("There is error in send this message !");
            },
            cache: false,
            processData: false,
            contentType: false
        });

    });

    $("#selectUser").on('change', function(e){
        sendTo = $("#selectUser").val();

        // /workspace/getMessagesPrivate/{workspace}/{user}
        $(".chatWithAdmin").html('');
        getPrivateMessages();

    });

    $("#formSendPrivateMessage").on('submit', function(e){
        e.preventDefault();

        let id = admin_workspace;
        if ( admin_workspace == user )
            id = sendTo;

        let url = `/workspace/sendMessageToUser/${workspace}/${id}`;
        let data = new FormData(this);
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                $("#formSendPrivateMessage").trigger("reset");
                flag_new_message = 1;
                addMessagePrivate(data);
                flag_new_message = 0;
                $(".chatWithAdmin").animate({ scrollTop: $('.chatWithAdmin').prop("scrollHeight")}, 1000);
            },
            error: function(data){
                alert("There is error in send this message !");
            },
            cache: false,
            processData: false,
            contentType: false
        });

    });

    
    //get messages
    function getMessages(){

        $.get(`${host}workspace/getMessagesToAll/${workspace}` + page, function (data) {
            let messages = data.data;
            $(".btnGetMoreMessages").show();
            if (Object.keys(messages).length < 10)
                $(".btnGetMoreMessages").hide();

            for (const message of messages)
            {
                addMessageWithAll( message );
            }
        });
    }
    getMessages();

    //get messages
    function getPrivateMessages(){

        let id = admin_workspace;
        if ( admin_workspace == user )
            id = sendTo;

        $.get(`${host}workspace/getMessagesPrivate/${workspace}/${id}` + page, function (data) {
            let messages = data.data;
            for (const message of messages)
            {
                addMessagePrivate( message );
            }
        });
    }
    getPrivateMessages();

    $("body").on('click','.btnGetMoreMessages', function(e){
        e.preventDefault();
        page = `/?page=${++count_page}`;
        $(".chatWithAll").animate({ scrollTop: 0}, 1000);
        getMessages();
    });

    function addMessageWithAll(message)
    {
        let msg = `;`
        if ( message.user_id == user ){
            
                msg = `<li class="me">
                    <figure><img src="/storage/${user_image}" style="min-width: 35px; min-height: 33px; max-width: 35px; max-height: 33px;"></figure>
                    <p class="text-white">${message.text}</p>
                </li>`;
        }else{
            msg = `
                <li class="you">
                    <figure><img src="/storage/${message.user.image}" style="min-width: 35px; min-height: 33px; max-width: 35px; max-height: 33px;"></figure>
                    <p class="text-white">${message.text}</p>
                </li>
            `;
        }
        
        if ( flag_new_message == 1 )
            $(".chatWithAll").append(`${msg}`);
        else
            $(".chatWithAll").prepend(`${msg}`);


    }

    function addMessagePrivate(message)
    {
        let msg = ``;
        if ( message.user_id == user ){
            
                msg = `<li class="me">
                    <figure><img src="/storage/${user_image}" style="min-width: 35px; min-height: 33px; max-width: 35px; max-height: 33px;"></figure>
                    <p class="text-white">${message.text}</p>
                </li>`;
        }else{
            msg = `
                <li class="you">
                    <figure><img src="/storage/${message.user.image}" style="min-width: 35px; min-height: 33px; max-width: 35px; max-height: 33px;"></figure>
                    <p class="text-white">${message.text}</p>
                </li>
            `;
        }
        
        if ( flag_new_message == 1 )
            $(".chatWithAdmin").append(`${msg}`);
        else
            $(".chatWithAdmin").prepend(`${msg}`);


    }

});