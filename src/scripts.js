$(document).ready(function () {

    // CUSTOM VALIDATION FUNCTIONS
    // Validation for no special char and num
    $.validator.addMethod("noSpecialChars", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "No special characters or numbers allowed.");

    // Specific validation for passwords
    $.validator.addMethod("validPassword", function (value, element) {
        return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/.test(value);
    }, "must have an upper and lowercase letter, a number, and a special character.");

    // DATA TABLES
    // INITIALIZE DATA TABLES
    $('#myTable').DataTable({
        responsive: true,
        scrollX: true,
        lengthMenu: [
            [5, 10, 15, -1],
            [5, 10, 15, 'All']
        ]
    });

    // LOGIN
    // LOGIN FORM DATA HANDLING
    $('#loginForm').validate({
        rules: {
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

            console.log(formData);

            // Send form data via AJAX
            $.ajax({
                type: 'POST',
                url: 'serverSideScripts.php',
                data: formData,
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.success) {
                        window.location.href = res.redirect;
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

    // LOGOUT
    // LOGOUT DATA HANDLING
    $('#logoutUserForm').submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: 'serverSideScripts.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                var res = JSON.parse(response);
                if (res.success) {
                    window.location.href = res.redirect;
                }
            }
        });
    });

    // ADMIN REGISTRATION
    // ADMIN REGISTRATION FORM DATA HANDLING
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

    // UPDATE USER
    // Handle Edit button click
    $('.editUserBtn').click(function () {
        var row = $(this).closest('tr');
        var userID = row.find('td:eq(0)').text();
        var userFname = row.find('td:eq(1)').text().split(" ")[0];
        var userLname = row.find('td:eq(1)').text().split(" ")[1];
        var userAdd = row.find('td:eq(2)').text();
        var userPhone = row.find('td:eq(3)').text();
        var userEmail = row.find('td:eq(4)').text();

        $('#editUserLabel').text("Update User: " + userEmail /*+ userFname + " " + userLname + " (" + userID + ")"*/);
        $('#editUserID').val(userID);
        $('#editUserFname').val(userFname);
        $('#editUserLname').val(userLname);
        $('#editUserAdd').val(userAdd);
        $('#editUserPhone').val(userPhone);
        $('#editUserEmail').val(userEmail);

        $('#editUserModal').modal('show');
    });

    // UPDATE USER FORM DATA HANDLING
    $('#editUserForm').validate({
        rules: {
            uFname: {
                minlength: 3,
                noSpecialChars: true
            },
            uLname: {
                minlength: 3,
                noSpecialChars: true
            },
            uAdd: {
                minlength: 5,
                noSpecialChars: true
            },
            uPhone: {
                digits: true,
                minlength: 11,
            },
            uEmail: {
                email: true
            }
        },
        messages: {
            uFname: {
                minlength: "Must be at least 3 characters"
            },
            uLname: {
                minlength: "Mst be at least 3 characters"
            },
            uAdd: {
                minlength: "Must be at least 5 characters",
                noSpecialChars: "No special characters allowed"
            },
            uPhone: {
                digits: "Please enter only digits",
                minlength: "Must be at least 11 digits long",
            },
            uEmail: {
                email: "Please enter a valid email address"
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
                        $('#editUserForm')[0].reset(); // Reset the form
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

    // DELETE USER
    // Handle Delete button click
    $('.delUserBtn').click(function () {
        var row = $(this).closest('tr');
        var userID = row.find('td:eq(0)').text();
        $('#deleteUserID').val(userID);
        $('#deleteUserModal').modal('show');
    });

    // Handle Delete confirmation
    $('#deleteUserForm').submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: 'serverSideScripts.php',
            type: 'POST',
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
    });


    // ADD PRODUCT
    // Add product image preview
    $('input[name="prodIMG"]').change(function(event){
        var reader = new FileReader();
        reader.onload = function(){
            var output = $('#imagePreview');
            output.attr('src', reader.result);
            output.show();
        }
        reader.readAsDataURL(event.target.files[0]);
    });

    // Add product form handling
    $('#addProductForm').validate({
        rules: {
            prodIMG: {
                required: true
            },
            prodName: {
                required: true,
                minlength: 3
            },
            prodCategory: {
                required: true
            },
            prodDesc: {
                required: true,
                minlength: 10
            },
            prodPrice: {
                required: true,
                number: true,
                min: 0.01
            },
            prodStock: {
                required: true,
                number: true,
                min: 1
            }
        },
        messages: {
            prodIMG: "Please select a product image",
            prodName: "Please enter a valid product name",
            prodCategory: "Please select a category",
            prodDesc: "Please enter a description (at least 10 characters)",
            prodPrice: "Please enter a valid price",
            prodStock: "Please enter a valid stock quantity"
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            $.ajax({
                url: 'serverSideScripts.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.success) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#addProductForm')[0].reset(); // Reset the form
                        $('#addNewProdModal').modal('hide');
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
                error: function() {
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