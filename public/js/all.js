$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('.btnLogout').on('click', function(e){
        e.preventDefault();
        $(".logout-form").submit();
    });

    $(".selectCourseSearch").select2({
        placeholder: {
            id: '-1', // the value of the option
            text: 'Search for a course'
          },
          maximumSelectionSize: 3,
          templateSelection: function (data) {
            if (data.id == -1 ) { // adjust for custom placeholder values
              return 'Search for a course';
            }
            window.location.assign(`/courses/${data.id}`);
          }
    });
    

});