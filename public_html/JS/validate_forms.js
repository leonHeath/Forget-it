$(function () {
    $("#register_user").validate({
        debug: true, //TODO remember I put this here, remove after debugging
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            username: {
                required: true,
                remote: "Requests/check_username.php"
            },
            password_1: {
                required: true,
                minlength: 8
            },
            password_2: {
                required: true,
                equalTo: "#reg_pass_1"
            }
        },
        messages: {
            first_name: {
                required: "Please enter your first name."
            },
            last_name: {
                required: "Please enter your last name."
            },
            username: {
                required: "Please enter a username.",
                remote: "Sorry, this username has been taken"
            },
            password_1: {
                required: "Please enter a password.",
                minlength: $.validator.format("To keep your password secure we require at least {0} characters.")
            },
            password_2: {
                required: "Please re-enter your password.",
                equalTo: "You've mistyped your password, please re-enter it."
            }
        },
        highlight: function (element) {
            $(element).addClass('invalid').removeClass('valid');
        },
        unhighlight: function (element) {
            $(element).addClass('valid').removeClass('invalid');
        }
    });
});
