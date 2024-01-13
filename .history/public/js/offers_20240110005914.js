$(document).ready(function () {
    $.get(`${host}user/getOffers` + page, function (data) {
        questions = data.data;
    });
});