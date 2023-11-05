$(document).ready(function(){

    let page = '';
    let count_page = 1;
    let flag_new_notification = 0;

    $(".count_messages").html( count_messages );

    //Listen Notifications
    Echo.private(`notification.${user_id}`)
    .listen('NewNotification', (notification) => {
        flag_new_notification = 1;
        addNotification( notification.notification );
        flag_new_notification = 0;
    })

    $(".btnShowNotifications").on('click', function(e){
        $(".fa-bell").removeClass('fa-beat');
    });

    $(".btnMessages").on('click' , function(e){
        $(".fa-message").removeClass('fa-beat');
    });

    function showNotifications()
    {

        $.get(`${host}notifications/get` + page , function (data) {
            notifications = data.data;
            $(".btnGetMoreNotifications").show();
            if (Object.keys(notifications).length < 10)
            {
                $(".btnGetMoreNotifications").hide();
            }
            for (const notification of notifications)
            {
                addNotification( notification );
            }
        });
    }
    showNotifications();

    $("body").on('click','.btnGetMoreNotifications', function(e){
        e.preventDefault();
        page = `/?page=${++count_page}`;
        showNotifications();
    });

    function addNotification(notification)
    {
        let format = '';
        let data = JSON.parse( notification.data );
        if ( data.type == "reply_on_question" ||  data.type == "reply_on_user")
            format = formatReply( notification );
        else if (data.type == "stop_question")
            format = formatStopQuestion( notification );
        else if ( data.type == "return_question" )
            format = formatReturnQuestion( notification );
        else if ( data.type == "invite_workspace" )
            format = formatInviteWorkspace( notification );
        else if ( data.type == "message" )
            format = formatMessage( notification );

        if ( data.type == "message" )
        {
            $("#messages").prepend( format );
            if ( flag_new_notification == 1 )
            {
                $(".count_messages").html( ++count_messages );
                $(".fa-message").addClass('fa-beat');
            }
        }
        else
        {
            if ( flag_new_notification == 1 )
            {
                $(".notifications").prepend( format );
                $(".currentNotification").html(++count_notifications);
                $(".fa-bell").addClass('fa-beat');
            }
            else if (  flag_new_notification == 0 )
            {
                $(".notifications").append( format );
            }
        }
    }

    function formatReply(notification )
    {
        let data = JSON.parse( notification.data );
        let date_time = new Date(notification.created_at);
        let isNew = '';

        let reply = `to your question in ${data.course} course`;
        if (data.type == 'reply_on_user')
            reply = `to you`;

        if ( notification.read == 0 )
            isNew = `<span class="float-right bg-danger text-white p-1">NEW</span>`;

        return `
            <li onclick="location.assign('/questions/${data.questionID}#comment_${data.commentID}')" class="mt-2 notification w-100">
                <div class="we-comment text-left">
                    <div class="coment-head">
                        <img src="/storage/${data.image}">

                        <a> <b><u> ${data.username} </u></b> <label> <b class="text-danger">reply</b> ${reply} </label> </a>
                        
                        <p>
                            ${data.short_text}
                        </p>
                    </div>
                    
                    <small class="text-black"><i class="fa-solid fa-clock"></i> ${ date_time.getFullYear() }/${date_time.getMonth()}/${date_time.getDate()} ${date_time.getHours()}:${date_time.getMinutes()} </small>
                </div>
            </li>
        `;
    }

    function formatStopQuestion(notification )
    {
        let data = JSON.parse( notification.data );
        let date_time = new Date(notification.created_at);
        let isNew = '';

        if ( notification.read == 0 )
            isNew = `<span class="float-right bg-danger text-white p-1">NEW</span>`;

        return `
            <li class="mt-2 notification w-100">
                <div class="we-comment text-left">
                    <div class="coment-head">
                        <div class="alert alert-danger">
                            <b><i class="fa-solid fa-triangle-exclamation"></i> Your question has been suspended by the supervisors</b>
                            <br/>
                            <label class="text-black">
                                Note by supervisor: ${data.short_text}
                            </label>
                        </div>                        
                       
                    </div>
                    
                    <small class="text-black"><i class="fa-solid fa-clock"></i> ${ date_time.getFullYear() }/${date_time.getMonth()}/${date_time.getDate()} ${date_time.getHours()}:${date_time.getMinutes()} </small>
                </div>
            </li>
        `;
    }

    function formatReturnQuestion(notification )
    {
        let data = JSON.parse( notification.data );
        let date_time = new Date(notification.created_at);
        let isNew = '';

        if ( notification.read == 0 )
            isNew = `<span class="float-right bg-danger text-white p-1">NEW</span>`;

        return `
            <li class="mt-2 notification w-100" onclick="location.assign('/questions/${data.questionID}')">
                <div class="we-comment text-left">
                    <div class="coment-head">
                        <div class="alert alert-success">
                            <b><i class="fa-solid fa-square-check"></i> Your question has been forwarded by the supervisors</b>
                        </div>                        
                       
                    </div>
                    
                    <small class="text-black"><i class="fa-solid fa-clock"></i> ${ date_time.getFullYear() }/${date_time.getMonth()}/${date_time.getDate()} ${date_time.getHours()}:${date_time.getMinutes()} </small>
                </div>
            </li>
        `;
    }

    function formatInviteWorkspace(notification )
    {
        let data = JSON.parse( notification.data );
        let date_time = new Date(notification.created_at);
        let isNew = '';

        if ( notification.read == 0 )
            isNew = `<span class="float-right bg-danger text-white p-1">NEW</span>`;

        return `
            <li class="mt-2 notification w-100" onclick="location.assign('/workspace/${data.workspace_id}')">
                <div class="we-comment text-left">
                    <div class="coment-head">
                        <div class="alert alert-success">
                            <b>
                                <i class="fa-solid fa-bullhorn"></i>
                                <img src="/storage/${data.sender_image}" style="min-width: 30px; min-height: 30px; max-width: 30px; max-height: 30px;" />
                                ${ data.sender } Invites you to join the workspace ( ${data.workspace_name} )  .
                            </b>
                        </div>                        
                       
                    </div>
                    
                    <small class="text-black"><i class="fa-solid fa-clock"></i> ${ date_time.getFullYear() }/${date_time.getMonth()}/${date_time.getDate()} ${date_time.getHours()}:${date_time.getMinutes()} </small>
                </div>
            </li>
        `;
    }

    function formatMessage(notification )
    {
        let data = JSON.parse( notification.data );
        let date_time = new Date(notification.created_at);
        let isNew = '';

        if ( notification.read == 0 )
            isNew = `<span class="float-right bg-danger text-white p-1">NEW</span>`;

        return `
            <li class="mt-2 notification w-100" onclick="location.assign('${data.goTo}')">
                <div class="we-comment text-left">
                    <div class="coment-head">
                        <div class="alert alert-primary">
                            <b>
                                <img src="/storage/${data.sender_image}" style="min-width: 30px; min-height: 30px; max-width: 30px; max-height: 30px;" />
                                ${ data.sender } ${data.text}.
                            </b>
                        </div>                        
                       
                    </div>
                    
                    <small class="text-black"><i class="fa-solid fa-clock"></i> ${ date_time.getFullYear() }/${date_time.getMonth()}/${date_time.getDate()} ${date_time.getHours()}:${date_time.getMinutes()} </small>
                </div>
            </li>
        `;
    }
});