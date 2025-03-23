<div class="row mb-4 border-bottom border-danger">
    <div class="col-md-9">
        <h1 class="fs-1">All Orders</h1>
    </div>
</div>

<div class="container mt-4">
    <ul class="nav nav-underline nav-justified" id="myTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="processing-tab" data-bs-toggle="tab" data-bs-target="#processing" type="button" role="tab">Processing</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="to-pick-up-tab" data-bs-toggle="tab" data-bs-target="#to-pick-up" type="button" role="tab">To Pick Up</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="picked-up-tab" data-bs-toggle="tab" data-bs-target="#picked-up" type="button" role="tab">Picked Up</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab">Cancelled</button>
        </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
        <!-- Processing Tab -->
        <div class="tab-pane fade show active" id="processing" role="tabpanel">
            <!-- Search Form -->
            <div class="col-md-3 mb-3">
                <form class="form-inline" id="processingSearchForm">
                    <div class="input-group">
                        <input class="form-control" type="search" name="processingSearch" placeholder="Search by Reference No. or Product Name" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="cart-header bg-danger text-white mb-3">
                <div class="row align-items-center p-3">
                    <div class="col-lg-6">
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
                </div>
            </div>

            <div class="order-results">
                <?php include 'fetch_processing.php'; // Load initial orders 
                ?>
            </div>
        </div>

        <!-- To Pick Up Tab -->
        <div class="tab-pane fade" id="to-pick-up" role="tabpanel">
            <!-- Search Form -->
            <div class="col-md-3 mb-3">
                <form class="form-inline" id="toPickUpSearchForm">
                    <div class="input-group">
                        <input class="form-control" type="search" name="toPickUpSearch" placeholder="Search by Reference No. or Product Name" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="cart-header bg-danger text-white mb-3">
                <div class="row align-items-center p-3">
                    <div class="col-lg-6">
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
                </div>
            </div>

            <div class="order-results">
                <?php include 'fetch_to-pick-up.php'; // Load initial orders 
                ?>
            </div>


        </div>

        <!-- Picked Up Tab -->
        <div class="tab-pane fade" id="picked-up" role="tabpanel">
            <!-- Search Form -->
            <div class="col-md-3 mb-3">
                <form class="form-inline" id="receivedSearchForm">
                    <div class="input-group">
                        <input class="form-control" type="search" name="receivedSearch" placeholder="Search by Reference No. or Product Name" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="cart-header bg-danger text-white mb-3">
                <div class="row align-items-center p-3">
                    <div class="col-lg-6">
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
                </div>
            </div>

            <div class="order-results">
                <?php include 'fetch_received.php'; // Load initial orders 
                ?>
            </div>

        </div>

        <!-- Cancelled Tab -->
        <div class="tab-pane fade" id="cancelled" role="tabpanel">
            <!-- Search Form -->
            <div class="col-md-3 mb-3">
                <form class="form-inline" id="cancelledSearchForm">
                    <div class="input-group">
                        <input class="form-control" type="search" name="cancelledSearch" placeholder="Search by Reference No. or Product Name" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="cart-header bg-danger text-white mb-3">
                <div class="row align-items-center p-3">
                    <div class="col-lg-6">
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
                </div>
            </div>

            <div class="order-results">
                <?php include 'fetch_cancelled.php'; // Load initial orders 
                ?>
            </div>

        </div>
    </div>

    <!-- Edit Order Modal -->
    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editOrderModalLabel">Edit Order Status</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editOrderForm">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="orderStatus" class="form-label">Order Status</label>
                                <select class="form-select" id="orderStatus" name="orderStatus">
                                    <option value="1">Processing</option>
                                    <option value="2">To Pick Up</option>
                                    <option value="4">Picked Up</option>
                                    <option value="3">Cancelled</option>
                                </select>
                                <label class="error-message" for="orderStatus"></label>
                            </div>
                        </div>
                        <input type="hidden" id="orderID" name="orderID">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-warning" id="confirmEditOrder">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>