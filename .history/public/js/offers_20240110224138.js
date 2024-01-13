$(document).ready(function () {

    var i = 0;

    $.get(`${host}user/getOffers`, function (data) {


        let d = JSON.parse(data);

        console.log(d);

        for (i = 0; i < d.length; i++) {

            job = d[i];

            i = i + 1;

            $("body").append(`
                <h2>${job.title} at ${job.companyName}</h2>
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
            `);
        }


    });
});