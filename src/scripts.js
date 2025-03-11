
// DATA TABLES
$(document).ready( function () {
    $('#myTable').DataTable({
      responsive: true,
      scrollX: true
    });
  });

// ADMIN REGISTRATION
document.getElementById('registerAdminBtn').addEventListener('click', function() {
    const form = document.getElementById('signupForm');
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                position: 'center',
                icon: 'success',
                text: data.message,
                showConfirmButton: false,
                timer: 3000
            });
            // Optionally close the modal here
            // var modal = bootstrap.Modal.getInstance(document.getElementById('regNewAdmin'));
            // modal.hide();
        } else {
            Swal.fire({
                position: 'center',
                icon: 'error',
                text: data.message,
                showConfirmButton: false,
                timer: 3000
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            position: 'center',
            icon: 'error',
            text: 'An error occurred. Please try again.',
            showConfirmButton: false,
            timer: 3000
        });
    });
});