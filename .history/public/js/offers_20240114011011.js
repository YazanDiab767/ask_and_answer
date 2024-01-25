$(document).ready(function () {

    var i = 0;

    $.get(`${host}user/getOffers`, function (data) {


        let d = JSON.parse(data);

        console.log(d["data"]);

        d = d["data"];

        for (i = 0; i < d.length; i++) {

            job = d[i];

            i = i + 1;

            $("#body").append(`
             
            <div class="container p-5">
                <h2><i class="fa-brands fa-buffer"></i> Offer - ${job.title} at ${job.company.name} ( <small> <i class="fa-solid fa-clock"></i> posted:${job.postDate} </small> )</h2>
                <br/>
                <img src = "${job.company.logo}" />
                <br/><br/>
                <a href="#demo${i}" class="btn btn-primary w-100" data-toggle="collapse"><i class="fa-solid fa-circle-info"></i> Show Full Details </a>
                <div id="demo${i}" class="collapse">
                    <br/>
                    <p><strong>Company Name:</strong> ${job.company.name}</p>
                    <p><strong>Company Name:</strong> ${job.company.name}</p>
                    <p><strong>Location:</strong> ${job.location}</p>
                    <p><strong>Posted:</strong> ${job.postDate}</p>
                    <p><strong>Work Type:</strong> ${job.type}</p>
                    <p><strong>URL:</strong> <a href="${job.url}">${job.url}</a></p>
                </div>
            </div>

            <hr>


            `);

            //     <div class="clickable-container">
            //     <h1 class="clickable" data-target="details1"> <h2>${job.title} at ${job.companyName}</h2> </h1>
            //     <div class="details mt-3" id="details1">

            //     </div>
            // </div>

        }


    });
});