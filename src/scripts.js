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
        var inStock = parseInt($('p:contains("In Stock:")').text().match(/\d+/)[0]); // Extract stock number
        if (quantity < inStock) {
            $('#quantityInput').val(quantity + 1);
        }
    });

    // Prevent manual input beyond stock limit
    $('#quantityInput').on('input', function () {
        var quantity = parseInt($(this).val());
        var inStock = parseInt($('p:contains("In Stock:")').text().match(/\d+/)[0]);

        if (isNaN(quantity) || quantity < 1) {
            $(this).val(1);
        } else if (quantity > inStock) {
            $(this).val(inStock);
        }
    });

    // add to cart
    $('#addToCartBtn').click(function () {
        var productID = $(this).data('product-id');
        var quantity = $('#quantityInput').val();
        var price = parseFloat($('#productPrice').text().replace(/,/g, ''));
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
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
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
                                    timer: 2000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
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
                                    timer: 2000
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.error("AJAX Error:", textStatus, errorThrown);
                            console.log("Server response:", jqXHR.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while processing your request.',
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
                                timer: 2000
                            });
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
                        timer: 2000
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
            dataType: 'json',
            success: function (response) {
                if (!response.success) {
                    alert(response.message);
                }
            }
        });
    }

    // update total of individual cart item
    function updateTotal($cartItem) {
        var quantity = parseInt($cartItem.find('.quantityInput').val());
        var unitPrice = parseFloat($cartItem.attr('data-unit-price')); // Use `attr` instead of `data`
        if (isNaN(unitPrice) || isNaN(quantity)) return; // Prevent errors if values are undefined

        var totalPrice = (unitPrice * quantity).toFixed(2);
        $cartItem.find('.total-price').text(totalPrice);
    }

    // update total in footer
    function updateFooterTotal() {
        var totalItems = 0;
        var totalPrice = 0.0;

        $('.item-check:checked').each(function () {
            totalItems++;
            var $cartItem = $(this).closest('.cart-item');
            var itemTotalPrice = parseFloat($cartItem.find('.total-price').text().replace(/,/g, ''));
            if (!isNaN(itemTotalPrice)) {
                totalPrice += itemTotalPrice; // Accumulate the total price
            }
        });

        $('#totalText').text('Total (' + totalItems + '): PHP ' + totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    }

    // Remove cart item
    // Event listener for the remove button
    $('.cart-item').on('click', '#delCartItemBtn', function () {
        // Get the parent cart-item div
        var cartItemDiv = $(this).closest('.cart-item');

        // Extract the cartItemID
        var cartItemID = cartItemDiv.data('item-id');

        // Send the cartItemID to the PHP function via AJAX
        $.ajax({
            url: 'serverSideScripts.php',
            type: 'POST',
            data: {
                action: 'deleteCartItem',
                cartItemID: cartItemID
            },
            dataType: 'json',
            success: function (response) {
                // Handle success response
                if (response.success) {
                    // Remove the cart-item div from the DOM
                    location.reload();
                } else {
                    // Handle failure response
                    console.log('Failed to remove item from cart: ' + response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
                });
            }
        });
    });

    $('#checkoutButton').click(function () {
        var selectedItems = [];
        var lowStockItems = [];
        var outOfStockItems = [];
        var stockCheckPromises = [];

        $('.item-check:checked').each(function () {
            var cartItemID = $(this).closest('.cart-item').data('item-id');
            var productID = $(this).closest('.cart-item').data('product-id');
            selectedItems.push(cartItemID);

            // Check the stock for each product
            stockCheckPromises.push(
                $.ajax({
                    url: 'serverSideScripts.php', // Use serverSideScripts.php for the stock check
                    type: 'POST',
                    data: {
                        productID: productID,
                        action: 'getProductStock' // Add an action to indicate the purpose
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.stock <= 0) { // If stock is 0 (Out of stock)
                            outOfStockItems.push(cartItemID); // Store the out of stock item
                        } else if (response.stock <= 5) { // If stock is low (<= 5)
                            lowStockItems.push(cartItemID); // Store the low stock item
                        }
                    }
                })
            );
        });

        // Wait for all stock checks to complete before proceeding
        $.when.apply($, stockCheckPromises).then(function () {
            // Handle out-of-stock items
            if (outOfStockItems.length > 0) {
                Swal.fire({
                    icon: 'warning',
                    text: 'One or more items are out of stock. Do you want to remove them from your cart?',
                    showConfirmButton: true,
                    showCancelButton: true,
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
                    preConfirm: function () {
                        // Remove the out of stock item from the cart
                        removeCartItem(outOfStockItems);
                    }
                });
            } else if (lowStockItems.length > 0) {
                // Handle low-stock items warning (if no out of stock items)
                Swal.fire({
                    icon: 'warning',
                    text: 'One or more items have low stock. Proceed with caution.',
                    showConfirmButton: true,
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
                    }
                }).then(function () {
                    // Proceed to checkout after warning for low stock
                    window.location.href = 'checkoutPage.php?items=' + selectedItems.join(',');
                });
            } else {
                // No issues, proceed directly to checkout
                window.location.href = 'checkoutPage.php?items=' + selectedItems.join(',');
            }
        });

        // If no items are selected
        if (selectedItems.length === 0) {
            Swal.fire({
                icon: 'warning',
                text: 'No items selected for checkout',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });

    // Function to remove cart item
    function removeCartItem(cartItemIDs) {
        $.each(cartItemIDs, function (index, cartItemID) {
            $.ajax({
                url: 'serverSideScripts.php',
                type: 'POST',
                data: {
                    action: 'deleteCartItem',
                    cartItemID: cartItemID
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Optionally, you can reload the page or remove the item from the DOM
                        location.reload(); // Reload the page to reflect the changes
                    } else {
                        // Handle failure response
                        console.log('Failed to remove item from cart: ' + response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    console.log("Server response:", jqXHR.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
                    });
                }
            });
        });
    }



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

        if (!paymentMethod) {
            Swal.fire({
                icon: 'warning',
                text: 'Please select a payment method to proceed with the checkout.',
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
                timer: 2000
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
            dataType: 'json',
            success: function (response) {
                try {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Order placed!',
                            text: response.message,
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
                            timer: 2000
                        }).then(() => {
                            // Redirect after the SweetAlert is closed
                            window.location.href = 'Home.php?page=cartPage';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
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
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
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
                    timer: 2000
                });
            }
        });
    });

    // 
    $('.view-notif').on('click', function () {
        let notifID = $(this).data('notif-id');

        $.ajax({
            url: 'serverSideScripts.php',
            type: 'POST',
            data: { action: 'markAsRead', notifID: notifID },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
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
                    timer: 2000
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
            }
        },
        messages: {
            uEmail: {
                required: "Please enter a valid email address",
                email: "Please enter a valid email address"
            },
            uPass: {
                required: "Please provide a password",
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
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.redirect;
                        $('#adminSignupForm')[0].reset(); // Reset the form
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    console.log("Server response:", jqXHR.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
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
                        timer: 2000
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
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    window.location.href = response.redirect;
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
        errorPlacement: function (error, element) {
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

            // Send form data via AJAX
            $.ajax({
                type: 'POST',
                url: 'serverSideScripts.php',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000,
                            willClose: () => {
                                location.reload();
                            }
                        });
                        $('#adminSignupForm')[0].reset(); // Reset the form
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    console.log("Server response:", jqXHR.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
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
                        timer: 2000
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
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000,
                            willClose: () => {
                                location.reload();
                            }
                        });
                        $('#adminSignupForm')[0].reset(); // Reset the form
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    console.log("Server response:", jqXHR.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
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
                        timer: 2000
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
                            timer: 2000,
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
                            timer: 2000
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    console.log("Server response:", jqXHR.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
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
                        timer: 2000
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
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000,
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
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
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
                    timer: 2000
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
            prodSpecs: {
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
            prodSpecs: "Please enter the specifications",
            prodPrice: "Please enter a valid price",
            prodStock: "Please enter a valid stock quantity"
        },
        submitHandler: function (form) {
            // Get the prodSpecs data
            var prodSpecs = $('textarea[name="prodSpecs"]').val().trim();

            // If prodSpecs is not empty, format it as a line-separated list of specification: description
            if (prodSpecs) {
                prodSpecs = prodSpecs.split("\n").map(function (line) {
                    var parts = line.split(":");
                    if (parts.length === 2) {
                        return parts[0].trim() + ": " + parts[1].trim();
                    }
                    return null;  // skip if the format is incorrect
                }).filter(Boolean).join("\n");
            }

            // Append the formatted prodSpecs to the form data
            var formData = new FormData(form);
            formData.append('prodSpecs', prodSpecs);  // Add prodSpecs to the form data

            $.ajax({
                url: 'serverSideScripts.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,  // Prevent jQuery from processing data
                contentType: false,  // Prevent jQuery from setting content type
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000,
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
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    console.log("Server response:", jqXHR.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
                        showConfirmButton: false,
                        backdrop: false,
                        position: 'top',
                        showClass: {
                            popup: `animate__animated animate__fadeInDown animate__faster`
                        },
                        hideClass: {
                            popup: `animate__animated animate__fadeOutUp animate__faster`
                        },
                        timer: 2000
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
        var productSpecs = row.find('td:eq(6)').text();
        var productPrice = row.find('td:eq(7)').text();
        var productStock = row.find('td:eq(8)').text();

        // Set new data in modal
        $('#editProdID').val(productID);
        $('#editProdName').val(productName);
        $('#editProdDesc').val(productDesc);
        $('#editprodSpecs').val(productSpecs);
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
            editProdSpecs: {
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
            editProdSpecs: "Please enter the specifications",
            editProdPrice: "Please enter a valid price",
            editProdStock: "Please enter a valid stock quantity"
        },
        submitHandler: function (form) {
            // Get form data
            var formData = new FormData(form);

            // Send form data via AJAX
            $.ajax({
                type: 'POST',
                url: 'serverSideScripts.php',
                data: formData,
                dataType: 'json',
                dataType: 'json',
                processData: false,  // Prevent jQuery from processing data
                contentType: false,  // Prevent jQuery from setting content type
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000,
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
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    console.log("Server response:", jqXHR.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
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
                        timer: 2000
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
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                        willClose: () => {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
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
                    timer: 2000
                });
            }
        });
    });


    // RESTORE PRODUCT==================================================
    // Handle Restore button click
    $(document).on('click', '.restoreProdBtn', function () {
        var row = $(this).closest('tr');
        var productID = row.find('td:eq(0)').text(); // Assuming product ID is in the first column

        $('#restoreProdID').val(productID);
        $('#restoreProdModal').modal('show');
    });
    // Handle restore confirmation
    $('#restoreProdForm').submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: 'serverSideScripts.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                        willClose: () => {
                            location.reload(); // Reload the page to reflect the changes
                        }
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
                    showConfirmButton: false,
                    backdrop: false,
                    position: 'top',
                    showClass: {
                        popup: `animate__animated animate__fadeInDown animate__faster`
                    },
                    hideClass: {
                        popup: `animate__animated animate__fadeOutUp animate__faster`
                    },
                    timer: 2000
                });
            }
        });
    });



    // ADMIN ORDER HANDLING==================================================
    let orderIDToCancel = null;

    // When the "Cancel Order" button is clicked, store the orderID
    $('.cancel-order-btn').click(function () {
        orderIDToCancel = $(this).data('order-id');
    });

    // When the "Confirm Cancel Order" button is clicked, send the AJAX request
    $('#confirmCancelOrder').click(function () {
        if (!orderIDToCancel) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No order selected for cancellation.',
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
                timer: 2000
            });
            return;
        }

        // Send the AJAX request to cancel the order
        $.ajax({
            url: 'serverSideScripts.php',
            method: 'POST',
            data: {
                action: 'cancelOrder',
                orderID: orderIDToCancel
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {

                    Swal.fire({
                        title: 'Order Cancelled',
                        text: 'The order has been cancelled successfully.',
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
                        timer: 2000
                    }).then(() => {

                        location.reload();
                    });
                } else {
                    // Show error notification
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
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
                        timer: 2000
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while cancelling the order.',
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
                    timer: 2000
                });
            }
        });


        $('#cancelOrderModal').modal('hide');
    });


    // EDIT ORDERS STATUS==================================================
    // update to to pick up
    let orderIDToEdit = null;

    // When the "Edit Order" button is clicked, store the orderID
    $('.edit-order-btn').click(function () {
        orderIDToEdit = $(this).data('order-id');
        $('#orderID').val(orderIDToEdit);
    });

    // Preview image on file select
    $('input[name="orderProofIMG"]').change(function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#addorderProofIMGPreview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(file);
        }
    });

    // Initialize form validation
    $('#editOrderToPickUpForm').validate({
        rules: {
            orderStatus: {
                required: true
            },
            orderProofIMG: {
                required: true,
            }
        },
        messages: {
            orderStatus: {
                required: "Please select an order status."
            },
            orderProofIMG: {
                required: "Please upload a proof of order.",
            }
        },
        errorClass: 'text-danger small',
        errorPlacement: function (error, element) {
            error.insertAfter(element); // Show error below the input
        },
        submitHandler: function (form) {
            const formData = new FormData(form);
            formData.append("action", "updateOrderStatus");
            console.log(formData);

            $.ajax({
                url: 'serverSideScripts.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Order Updated',
                            text: 'The order status has been updated successfully.',
                            icon: 'success',
                            position: 'top',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    console.error("AJAX Error:", textStatus, errorThrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the order.',
                        position: 'top',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });

            $('#editOrderToPickUpModal').modal('hide');
            return false;
        }
    });

    // Trigger form validation manually on button click
    $('#confirmEditOrderToPickUp').click(function () {
        $('#editOrderToPickUpForm').submit();
    });

    // update to picked up
    let pickedUpOrderID = null;

    // When the "Edit Order to Picked Up" button is clicked
    $('.edit-order-to-picked-up-btn').click(function () {
        pickedUpOrderID = $(this).data('order-id');
        $('#orderIDToPickedUp').val(pickedUpOrderID);
    });

    // Initialize form validation
    $('#editOrderToPickedUpForm').validate({
        rules: {
            newStatus: {
                required: true
            }
        },
        messages: {
            newStatus: {
                required: "Please select an order status."
            }
        },
        errorClass: 'text-danger small',
        errorPlacement: function (error, element) {
            error.insertAfter(element); // Show error below the select
        },
        submitHandler: function (form) {
            const formData = new FormData(form);
            formData.append("action", "updateOrderStatus");

            $.ajax({
                url: 'serverSideScripts.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Order Updated',
                            text: 'The order status has been updated successfully.',
                            icon: 'success',
                            position: 'top',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    console.error("AJAX Error:", textStatus, errorThrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the order.',
                        position: 'top',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });

            $('#editOrderToPickedUpModal').modal('hide');
            return false;
        }
    });

    // Manually trigger validation on confirm button click
    $('#confirmEditOrderToPickedUp').click(function () {
        $('#editOrderToPickedUpForm').submit();
    });



    // ADMIN SEARCH ORDERS==================================================
    // Admin search processing orders
    $("#processingSearchForm").submit(function (e) {
        e.preventDefault(); // Prevent the default form submission

        var searchQuery = $("input[name='processingSearch']").val();

        $.ajax({
            url: "adminPages/fetch_processing.php", // PHP file that processes the search
            type: "POST",
            data: { searchSubmit: true, productSearch: searchQuery },
            dataType: "html",
            success: function (response) {
                $("#processing .order-results").html(response); // Update results
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
            }
        });
    });

    // Admin search to-pick-up orders
    $("#toPickUpSearchForm").submit(function (e) {
        e.preventDefault(); // Prevent the default form submission

        var searchQuery = $("input[name='toPickUpSearch']").val();

        $.ajax({
            url: "adminPages/fetch_to-pick-up.php", // PHP file that processes the search
            type: "POST",
            data: { searchSubmit: true, productSearch: searchQuery },
            dataType: "html",
            success: function (response) {
                $("#to-pick-up .order-results").html(response); // Update results
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
            }
        });
    });

    // Admin search received orders
    $("#receivedSearchForm").submit(function (e) {
        e.preventDefault(); // Prevent the default form submission

        var searchQuery = $("input[name='receivedSearch']").val();

        $.ajax({
            url: "adminPages/fetch_received.php", // PHP file that processes the search
            type: "POST",
            data: { searchSubmit: true, productSearch: searchQuery },
            dataType: "html",
            success: function (response) {
                $("#picked-up .order-results").html(response); // Update results
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
            }
        });
    });

    // Admin search cancelled orders
    $("#cancelledSearchForm").submit(function (e) {
        e.preventDefault(); // Prevent the default form submission

        var searchQuery = $("input[name='cancelledSearch']").val();

        $.ajax({
            url: "adminPages/fetch_cancelled.php", // PHP file that processes the search
            type: "POST",
            data: { searchSubmit: true, productSearch: searchQuery },
            dataType: "html",
            success: function (response) {
                $("#cancelled .order-results").html(response); // Update results
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
            }
        });
    });

    // CUSTOMER UPLOAD RECEIPT
    // receipt upload handling
    let selectedFile;

    // Open Modal and Set Order Details
    $(".upload-receipt-btn").click(function () {
        let orderID = $(this).data("order-id");
        let referenceNum = $(this).data("reference-num");

        $("#orderID").val(orderID);
        $("#referenceNum").val(referenceNum);
        $("#receiptImage").val('');
        $("#receiptPreview").hide();
    });

    // Preview Uploaded Image
    $("#receiptImage").change(function (event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $("#receiptPreview").attr("src", e.target.result).show();
            };
            reader.readAsDataURL(file);
            selectedFile = file;
        }
    });

    // Upload Receipt via AJAX
    $("#submitReceipt").click(function () {
        let formData = new FormData();
        let orderID = $("#orderID").val();
        let referenceNum = $("#referenceNum").val();
        let file = $("#receiptImage")[0].files[0];

        if (!file) {
            Swal.fire({
                icon: 'error',
                text: 'Please select an image to upload.',
                showConfirmButton: false,
                backdrop: false,
                position: 'top',
                timer: 2000
            });
            return;
        }

        formData.append("action", "uploadReceipt"); // Adding action parameter
        formData.append("orderID", orderID);
        formData.append("referenceNum", referenceNum);
        formData.append("receiptImage", file);

        $.ajax({
            url: "serverSideScripts.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Receipt Uploaded',
                        text: response.message,
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
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: response.message,
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
                        timer: 2000
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
                    showConfirmButton: false,
                    backdrop: false,
                    position: 'top',
                    timer: 2000
                });
            }
        });
    });

    // RESET PASSWORD
    // send otp to user
    $('#sendOtpBtn').on('click', function () {
        const email = $('#email').val().trim();

        if (email === '') {
            alert("Please enter your email first.");
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'serverSideScripts.php',
            data: {
                action: 'sendOtp',
                email: email
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        text: response.message,
                        showConfirmButton: false,
                        backdrop: false,
                        position: 'top',
                        showClass: {
                            popup: `animate__animated animate__fadeInDown animate__faster`
                        },
                        hideClass: {
                            popup: `animate__animated animate__fadeOutUp animate__faster`
                        },
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: response.message,
                        showConfirmButton: false,
                        backdrop: false,
                        position: 'top',
                        showClass: {
                            popup: `animate__animated animate__fadeInDown animate__faster`
                        },
                        hideClass: {
                            popup: `animate__animated animate__fadeOutUp animate__faster`
                        },
                        timer: 2000
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
            }
        });
    });
    // reset password for user
    $('#resetForm').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            otp: {
                required: true,
                number: true,
                minlength: 4,
                maxlength: 6
            },
            newPassword: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            email: "Enter a valid email address",
            otp: "Enter the OTP sent to your email",
            newPassword: "Enter a new password (min. 6 characters)"
        },
        submitHandler: function (form) {
            // AJAX request to reset password
            $.ajax({
                type: 'POST',
                url: 'serverSideScripts.php',
                data: $(form).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            showConfirmButton: false,
                            backdrop: false,
                            position: 'top',
                            showClass: {
                                popup: `animate__animated animate__fadeInDown animate__faster`
                            },
                            hideClass: {
                                popup: `animate__animated animate__fadeOutUp animate__faster`
                            },
                            timer: 2000
                        }).then(function () {
                            window.location.href = "Login.php";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                            showConfirmButton: false,
                            backdrop: false,
                            position: 'top',
                            showClass: {
                                popup: `animate__animated animate__fadeInDown animate__faster`
                            },
                            hideClass: {
                                popup: `animate__animated animate__fadeOutUp animate__faster`
                            },
                            timer: 2000
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    console.log("Server response:", jqXHR.responseText);
                }
            });
        }
    });

    // PRODUCT REVIEWS
    // review form handling
    $('#reviewForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        const formData = {
            action: 'uploadProductReview',
            productID: $('input[name="productID"]').val(),
            rating: $('input[name="rating"]:checked').val(),
            reviewText: $('#review').val()
        };

        $.ajax({
            url: 'serverSideScripts.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        text: response.message,
                        showConfirmButton: false,
                        backdrop: false,
                        position: 'top',
                        showClass: {
                            popup: `animate__animated animate__fadeInDown animate__faster`
                        },
                        hideClass: {
                            popup: `animate__animated animate__fadeOutUp animate__faster`
                        },
                        timer: 2000
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: response.message,
                        showConfirmButton: false,
                        backdrop: false,
                        position: 'top',
                        showClass: {
                            popup: `animate__animated animate__fadeInDown animate__faster`
                        },
                        hideClass: {
                            popup: `animate__animated animate__fadeOutUp animate__faster`
                        },
                        timer: 2000
                    })
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server response:", jqXHR.responseText);
            }
        });
    });

});