$(document).ready(function () {

    // CUSTOM VALIDATIONS==================================================
    // Validation for no special char and num
    $.validator.addMethod("noSpecialChars", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "No special characters or numbers allowed.");

    // Specific validation for passwords
    $.validator.addMethod("validPassword", function (value, element) {
        return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/.test(value);
    }, "must have an upper and lowercase letter, a number, and a special character.");


    // VIEW PRODUCTS==================================================
    // quantity counter
    $('#decreaseQuantity').click(function () {
        var quantity = parseInt($('#quantityInput').val());
        if (quantity > 1) {
            $('#quantityInput').val(quantity - 1);
        }
    });
    $('#increaseQuantity').click(function () {
        var quantity = parseInt($('#quantityInput').val());
        $('#quantityInput').val(quantity + 1);
    });

    // add to cart
    $('#addToCartBtn').click(function () {
        var productID = $(this).data('product-id');
        var quantity = $('#quantityInput').val();
        var price = parseFloat($('#productPrice').text());
        var totalPrice = quantity * price;

        // Check if user is logged in
        $.ajax({
            url: 'serverSideScripts.php',
            method: 'POST',
            data: {
                action: 'checkLoginStatus'
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.loggedIn) {
                    // User is logged in, proceed to add to cart
                    $.ajax({
                        url: 'serverSideScripts.php',
                        method: 'POST',
                        data: {
                            action: 'addToCart',
                            productID: productID,
                            quantity: quantity,
                            totalPrice: totalPrice
                        },
                        success: function (response) {
                            var result = JSON.parse(response);
                            if (result.success) {
                                Swal.fire({
                                    title: 'Added to Cart',
                                    text: 'The item has been added to your cart.',
                                    showConfirmButton: false,
                                    backdrop: false,
                                    position: 'top',
                                    showClass: {
                                        popup: `
                                          animate__animated
                                          animate__fadeInDown
                                          animate__faster
                                        `
                                    },
                                    hideClass: {
                                        popup: `
                                          animate__animated
                                          animate__fadeOutUp
                                          animate__faster
                                        `
                                    },
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: result.message,
                                    showConfirmButton: false,
                                    backdrop: false,
                                    position: 'top',
                                    timer: 1500
                                });
                            }
                        }
                    });
                } else {
                    // User is not logged in, show alert and redirect to login
                    Swal.fire({
                        title: 'Please login to add item to cart',
                        icon: 'warning',
                        showConfirmButton: false,
                        backdrop: false,
                        position: 'top',
                        timer: 1500
                    }).then(() => {
                        window.location.href = 'login.php';
                    });
                }
            }
        });
    });

    // CART==================================================
    // cart check all
    $('#checkAll').click(function () {
        $('.item-check').prop('checked', this.checked);
        updateFooterTotal();
    });
    $('.item-check').click(function () {
        if ($('.item-check:checked').length == $('.item-check').length) {
            $('#checkAll').prop('checked', true);
        } else {
            $('#checkAll').prop('checked', false);
        }
        updateFooterTotal();
    });

    // quantity counter
    $('.increaseQuantity').click(function () {
        var $quantityInput = $(this).siblings('.quantityInput');
        var quantity = parseInt($quantityInput.val());
        $quantityInput.val(quantity + 1);
        updateTotal($(this).closest('.cart-item'));
        updateFooterTotal();
        updateQuantityInDatabase($(this).closest('.cart-item'), quantity + 1);
    });
    $('.decreaseQuantity').click(function () {
        var $quantityInput = $(this).siblings('.quantityInput');
        var quantity = parseInt($quantityInput.val());
        if (quantity > 1) {
            $quantityInput.val(quantity - 1);
            updateTotal($(this).closest('.cart-item'));
            updateFooterTotal();
            updateQuantityInDatabase($(this).closest('.cart-item'), quantity - 1);
        }
    });

    // Function to update quantity in the database
    function updateQuantityInDatabase($cartItem, newQuantity) {
        var cartItemID = $cartItem.data('item-id');
        var unitPrice = parseFloat($cartItem.data('unit-price'));
        var newTotalPrice = unitPrice * newQuantity;

        $.ajax({
            url: 'serverSideScripts.php',
            method: 'POST',
            data: {
                action: 'updateCartItemQuantity',
                cartItemID: cartItemID,
                newQuantity: newQuantity,
                newTotalPrice: newTotalPrice,
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (!result.success) {
                    alert(result.message);
                }
            }
        });
    }

    // update total of individual cart item
    function updateTotal($cartItem) {
        var unitPrice = parseFloat($cartItem.data('unit-price'));
        var quantity = parseInt($cartItem.find('.quantityInput').val());
        var totalPrice = unitPrice * quantity;
        $cartItem.find('.total-price').text(totalPrice.toFixed(2));
    };

    // update total in footer
    function updateFooterTotal() {
        var totalItems = 0;
        var totalPrice = 0.0;

        $('.item-check:checked').each(function () {
            totalItems++;
            var $cartItem = $(this).closest('.cart-item');
            var itemTotalPrice = parseFloat($cartItem.find('.total-price').text().replace(/,/g, ''));

            if (!isNaN(itemTotalPrice)) {
                totalPrice += itemTotalPrice;
            }
        });

        $('#totalText').text('Total (' + totalItems + '): PHP ' + totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    };

    // Remove cart item
    // Event listener for the remove button
    $('.cart-item').on('click', '#delCartItemBtn', function () {
        // Get the parent cart-item div
        var cartItemDiv = $(this).closest('.cart-item');

        // Extract the cartItemID
        var cartItemID = cartItemDiv.data('item-id');

        console.log(cartItemID);

        // Send the cartItemID to the PHP function via AJAX
        $.ajax({
            url: 'serverSideScripts.php',
            type: 'POST',
            data: {
                action: 'deleteCartItem',
                cartItemID: cartItemID
            },
            success: function (response) {
                // Parse the JSON response
                var res = JSON.parse(response);

                // Handle success response
                if (res.success) {
                    // Remove the cart-item div from the DOM
                    location.reload();
                } else {
                    // Handle failure response
                    console.log('Failed to remove item from cart: ' + res.message);
                }
            },
            error: function () {
                // Handle AJAX error
                console.log('An error occurred while trying to remove the item from cart.');
            }
        });
    });

    // Checkout button click event
    $('#checkoutButton').click(function () {
        var selectedItems = [];
        $('.item-check:checked').each(function () {
            var cartItemID = $(this).closest('.cart-item').data('item-id');
            selectedItems.push(cartItemID);
        });

        if (selectedItems.length > 0) {
            // Redirect to the checkout page with selected cartItemIDs
            window.location.href = 'checkoutPage.php?items=' + selectedItems.join(',');
        } else {
            Swal.fire({
                icon: 'warning',
                text: 'No items selected for checkout',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });

    // CHECKOUT PAGE==================================================
    $('#confirmCheckout').on('click', function () {
        let totalAmount = $('.confirmCheckout').data('totalamount');
        let sanitizedAmount = totalAmount.replace(/,/g, ''); // Remove commas
        let totalAmountFloat = parseFloat(sanitizedAmount);
        let cartItems = [];
        $('.itemsToOrder').each(function () {
            let productID = $(this).data('productid');
            let quantity = $(this).find('.quantity').text().split(': ')[1];
            let total = $(this).find('.price').text().replace(/[^0-9.-]+/g, "")

            cartItems.push({
                productID: productID,
                quantity: parseInt(quantity),
                total: parseFloat(total)
            });
        });
        let paymentMethod = $('input[name="paymentMethod"]:checked').val();

        console.log(cartItems);

        if (!paymentMethod) {
            Swal.fire({
                icon: 'warning',
                text: 'Please select a payment method to proceed with the checkout.',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        $.ajax({
            url: 'serverSideScripts.php',
            method: 'POST',
            data: {
                action: 'placeOrder',
                cartItems: cartItems,
                totalAmount: totalAmountFloat.toFixed(2),
                mopID: paymentMethod
            },
            success: function (response) {
                try {
                    var res = JSON.parse(response);
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Order placed!',
                            text: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Redirect after the SweetAlert is closed
                            window.location.href = 'Home.php?page=cartPage';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message
                        });
                    }
                } catch (e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while placing the order. Please try again.'
                    });
                    console.log('Response:', response);
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    text: 'An error occurred while placing the order. Please try again.'
                });
            }
        });
    });

    // DATA TABLES==================================================
    // INITIALIZE DATA TABLES
    $('#myTable').DataTable({
        responsive: true,
        scrollCollapse: true,
        scrollY: '475px',
        lengthMenu: [
            [5, 10, 15, -1],
            [5, 10, 15, 'All']
        ]
    });

    // LOGIN==================================================
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

    // LOGOUT==================================================
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

    // CUSTOMER REGISTRATION
    // Customer registration form handling
    $('#customerSignupForm').validate({
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
            },
            policy: {
                required: true
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
            },
            policy: {
                required: "You must agree to the terms and conditions"
            },
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") === "policy") {
                // Place the error message below the checkbox wrapper
                error.insertAfter("#checkboxWrapper");
            } else {
                // Default behavior: place error after the input element
                error.insertAfter(element);
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
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: res.message,
                            showConfirmButton: false,
                            timer: 1500,
                            willClose: () => {
                                location.reload();
                            }
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

    // ADMIN REGISTRATION==================================================
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
                            timer: 1500,
                            willClose: () => {
                                location.reload();
                            }
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

    // UPDATE USER==================================================
    // Handle Edit button click
    $(document).on('click', '.editUserBtn', function () {
        var row = $(this).closest('tr');
        var userID = row.find('td:eq(0)').text();
        var userFname = row.find('td:eq(1)').text().split(" ")[0];
        var userLname = row.find('td:eq(1)').text().split(" ")[1];
        var userAdd = row.find('td:eq(2)').text();
        var userPhone = row.find('td:eq(3)').text();
        var userEmail = row.find('td:eq(4)').text();

        // Clear or reset modal data
        $('#editUserModal input').val('');

        // Set new data in modal
        $('#editUserLabel').text("Update User: " + userEmail /*+ userFname + " " + userLname + " (" + userID + ")"*/);
        $('#editUserID').val(userID);
        $('#editUserFname').val(userFname);
        $('#editUserLname').val(userLname);
        $('#editUserAdd').val(userAdd);
        $('#editUserPhone').val(userPhone);
        $('#editUserEmail').val(userEmail);

        // Show the modal
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
                            timer: 1500,
                            willClose: () => {
                                location.reload();
                            }
                        });
                        $('#editUserForm')[0].reset(); // Reset the form
                        $('#editUser').modal('hide');
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

    // DELETE USER==================================================
    // Handle Delete button click
    $(document).on('click', '.delUserBtn', function () {
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
                        timer: 1500,
                        willClose: () => {
                            location.reload();
                        }
                    });
                    $('#deleteUserForm')[0].reset();
                    $('#deleteUserModal').modal('hide');
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

    // ADD PRODUCT==================================================
    // Add product image preview
    $('input[name="prodIMG"]').change(function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = $('#addProdIMGPreview');
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
        submitHandler: function (form) {
            var formData = new FormData(form);
            $.ajax({
                url: 'serverSideScripts.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.success) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: res.message,
                            showConfirmButton: false,
                            timer: 1500,
                            willClose: () => {
                                location.reload();
                            }
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

    // EDIT PRODUCT==================================================
    // Edit product image preview
    $('input[name="editProdIMG"]').change(function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = $('#editProdIMGPreview');
            output.attr('src', reader.result);
            output.show();
        }
        reader.readAsDataURL(event.target.files[0]);
    });
    // Pass row data to modal
    $(document).on('click', '.editProdBtn', function () {
        var row = $(this).closest('tr');
        var productID = row.find('td:eq(0)').text();
        var productIMG = row.find('td:eq(2) img').attr('src');
        var productName = row.find('td:eq(3)').text();
        var categoryName = row.find('td:eq(4)').text();
        var productDesc = row.find('td:eq(5)').text();
        var productPrice = row.find('td:eq(6)').text();
        var productStock = row.find('td:eq(7)').text();

        console.log(productIMG);

        // Set new data in modal
        $('#editProdID').val(productID);
        $('#editProdName').val(productName);
        $('#editProdDesc').val(productDesc);
        $('#editProdPrice').val(productPrice);
        $('#editProdStock').val(productStock);
        $('#editProdIMGPreview').attr('src', productIMG).show();

        $('#editProdCategory option').each(function () {
            if ($(this).text() == categoryName) {
                $(this).attr('selected', 'selected');
            } else {
                $(this).removeAttr('selected');
            }
        });

        $('#editProdModal').modal('show');
    });
    // edit product form handling
    $('#editProductForm').validate({
        rules: {
            editProdIMG: {

            },
            editProdName: {
                minlength: 3
            },
            editProdCategory: {
            },
            editProdDesc: {
                minlength: 10
            },
            editProdPrice: {
                number: true,
                min: 0.01
            },
            editProdStock: {
                number: true,
                min: 1
            }
        },
        messages: {
            editProdIMG: "Please select a product image",
            editProdName: "Please enter a valid product name",
            editProdCategory: "Please select a category",
            editProdDesc: "Please enter a description (at least 10 characters)",
            editProdPrice: "Please enter a valid price",
            editProdStock: "Please enter a valid stock quantity"
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
                            timer: 1500,
                            willClose: () => {
                                location.reload();
                            }
                        });
                        $('#editProductForm')[0].reset(); // Reset the form
                        $('#editProdModal').modal('hide');
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

    // DELETE PRODUCT==================================================
    // Handle Delete button click
    $(document).on('click', '.delProdBtn', function () {
        var row = $(this).closest('tr');
        var userID = row.find('td:eq(0)').text();

        $('#deleteProdID').val(userID);
        $('#deleteProdModal').modal('show');
    });
    // Handle delete confirmation
    $('#deleteProdForm').submit(function (e) {
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
                        timer: 1500,
                        willClose: () => {
                            location.reload();
                        }
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
});