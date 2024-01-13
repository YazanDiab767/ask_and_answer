$(document).ready(function () {

    var i = 0;

    $.get(`${host}user/getOffers`, function (data) {


        let d = JSON.parse(data);

        console.log(d);

        for (i = 0; i < d.length; i++) {

            job = d[i];

            i = i + 1;

            $("#body").append(`
             
            <div class="container p-5">
                <h2>Offer - ${job.title} at ${job.companyName} ( posted:${job.postedTime} )</h2>
                <a href="#demo${i}" class="btn btn-primary" data-toggle="collapse">Show Full Details </a>
                <div id="demo${i}" class="collapse">
                    <br/>
                    <p><strong>Location:</strong> ${job.location}</p>
                    <p><strong>Posted:</strong> ${job.postedTime}</p>
                    <p><strong>Applications:</strong> ${job.applicationsCount}</p>
                    <p><strong>Description:</strong> ${job.description}</p>
                    <p><strong>Salary:</strong> ${job.salary}</p>
                    <p><strong>Experience Level:</strong> ${job.experienceLevel}</p>
                    <p><strong>Contract Type:</strong> ${job.contractType}</p>
                    <p><strong>Work Type:</strong> ${job.workType}</p>
                    <p><strong>Sector:</strong> ${job.sector}</p>
                    <p><a href="${job.jobUrl}" target="_blank">Job Link</a></p>
                    <p><a href="${job.companyUrl}" target="_blank">Company Link</a></p>
                </div>
            </div>


            `);

            //     <div class="clickable-container">
            //     <h1 class="clickable" data-target="details1"> <h2>${job.title} at ${job.companyName}</h2> </h1>
            //     <div class="details mt-3" id="details1">

            //     </div>
            // </div>

        }


    });
});