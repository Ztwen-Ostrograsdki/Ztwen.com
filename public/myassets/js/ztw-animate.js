$(function() {
    var controller = $('#adminsToggler');
    var controller_left = $('#adminHider');
    var controller_right = $('#adminShower');
    var left_dash = $('#adminLeftDashboard');
    var right_dash = $('#adminRightDashboard');

    controller_right.click(function() {
        $(this).hide(function() {
            controller_left.removeClass('d-none');
            left_dash.hide();
            right_dash.addClass('col-12');
        });

    });

    controller_left.click(function() {
        $(this).addClass('d-none', function() {
            controller_right.show();
        });
        left_dash.show();
        right_dash.removeClass('col-12');
    });


});