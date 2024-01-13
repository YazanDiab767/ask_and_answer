$(document).ready(function () {
    $.get(`${host}user/getOffers`, function (data) {
        questions = data.data;
    });
});