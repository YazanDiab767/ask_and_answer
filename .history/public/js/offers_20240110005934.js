$(document).ready(function () {
    $.get(`${host}user/getOffers`, function (data) {


        console.log(data.length);

    });
});