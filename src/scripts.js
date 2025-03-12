// DATA TABLES
$(document).ready(function () {
    $('#myTable').DataTable({
        responsive: true,
        scrollX: true
    });
});

// ADMIN REGISTRATION
$(document).ready(function () {
    // Custom validation methods
    $.validator.addMethod("noSpecialChars", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "No special characters or numbers allowed.");

    $.validator.addMethod("validPassword", function (value, element) {
        return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/.test(value);
    }, "must have an upper and lowercase letter, a number, and a special character.");

    $('#adminSignupForm').validate({
        rules: {
            uFname: {
                required: true,
                minlength: 3,
                noSpecialChars: true
            },
            uLname: {
                required: true,
                minlength: 3,
                noSpecialChars: true
            },
            uAdd: {
                required: true,
                minlength: 5,
                noSpecialChars: true
            },
            uPhone: {
                required: true,
                digits: true,
                minlength: 11,
            },
            uEmail: {
                required: true,
                email: true
            },
            uPass: {
                required: true,
                minlength: 8,
                validPassword: true
            }
        },
        messages: {
            uFname: {
                required: "Please enter your first name",
                minlength: "Must be at least 3 characters"
            },
            uLname: {
                required: "Please enter your last name",
                minlength: "Mst be at least 3 characters"
            },
            uAdd: {
                required: "Please enter your address",
                minlength: "Must be at least 5 characters",
                noSpecialChars: "No special characters allowed"
            },
            uPhone: {
                required: "Please provide a contact number",
                digits: "Please enter only digits",
                minlength: "Must be at least 11 digits long",
            },
            uEmail: {
                required: "Please enter a valid email address",
                email: "Please enter a valid email address"
            },
            uPass: {
                required: "Please provide a password",
                minlength: "Must be at least 8 characters"
            }
        },
        submitHandler: function (form) {
            // Get form data
            var formData = $(form).serialize();

            // Send form data via AJAX
            $.ajax({
                type: 'POST',
                url: 'serverSideScripts.php',
                data: formData,
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.success) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#adminSignupForm')[0].reset(); // Reset the form
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            text: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
                    });
                }
            });
        }
    });
});