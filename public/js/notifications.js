$(document).ready(function(){

    let page = '';
    let count_page = 1;

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
        {
            format = formatReply( notification );
        }
        else if (data.type == "stop_question")
        {
            format = formatStopQuestion( notification );
        }
        else if ( data.type == "return_question" )
            format = formatReturnQuestion( notification );

        $(".notifications").append( format );
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
            <li onclick="location.assign('/questions/${data.questionID}#')" class="mt-2 notification w-100">
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

});