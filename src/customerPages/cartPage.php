<div class="container-fluid p-5">
    <div class="row mb-4 border-bottom border-danger">
        <div class="col-md-9">
            <h1 class="fs-1">Customer's Cart</h1>
        </div>
        <div class="col-md-3">
            <form class="form-inline" method="POST">
                <div class="input-group">
                    <input class="form-control" type="search" name="productSearch" placeholder="Search products" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger" type="submit" name="searchSubmit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="container mt-5">
        <div class="cart-header bg-danger text-white mb-3">
            <div class="row align-items-center p-3">
                <div class="col-lg-1 text-center">
                    <input type="checkbox" class="form-check-input item-check" id="checkAll">
                </div>
                <div class="col-lg-4">
                    <p class="fs-5 mb-0">Product</p>
                </div>
                <div class="col-lg-2 text-center">
                    <p class="fs-5 mb-0">Unit Price</p>
                </div>
                <div class="col-lg-2 text-center">
                    <p class="fs-5 mb-0">Quantity</p>
                </div>
                <div class="col-lg-2 text-center">
                    <p class="fs-5 mb-0">Total</p>
                </div>
                <div class="col-lg-1 text-center">
                    <p class="fs-5 mb-0">Action</p>
                </div>
            </div>
        </div>

        <div class="cart-item bg-light">
            <div class="row align-items-center p-3">
                <div class="col-lg-1 d-flex justify-content-center">
                    <input type="checkbox" class="form-check-input item-check">
                </div>
                <div class="col-lg-4 d-flex">
                    <img src="https://via.placeholder.com/50" alt="Product Image" class="me-2">
                    <div class="d-flex flex-column justify-content-center">
                        <span>Product Name</span>
                        <span class="text-secondary">Category: Electronics</span>
                        <span class="text-secondary">Brand: ExampleBrand</span>
                    </div>
                </div>
                <div class="col-lg-2 text-center">
                    <span class="unit-price">$10.00</span>
                </div>
                <div class="col-lg-2 text-center">
                    <div class="input-group input-group">
                        <button type="button" class="btn btn-secondary" id="decreaseQuantity">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <input type="number" id="quantityInput" class="form-control text-center" value="1" min="1">
                        <button type="button" class="btn btn-secondary" id="increaseQuantity">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="col-lg-2 text-center">
                    <span class="total-price">$10.00</span>
                </div>
                <div class="col-lg-1 text-center">
                    <button class="btn btn-danger">Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>