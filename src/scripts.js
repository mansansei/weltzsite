
// DATA TABLES
$(document).ready(function () {
    $('#myTable').DataTable({
        responsive: true,
        scrollX: true
    });
});

// ADMIN REGISTRATION
$(document).ready(function () {
    $('#adminSignupForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Get form data
        var formData = $(this).serialize();

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
    });
});