@include('header')
@include('products.nav')

@php
  $products = \App\Models\Product::all();
@endphp

<div class="card recent-sales overflow-auto">
    <div class="card-body">
        <h5 class="card-title">Sales Repoert</h5>
        <div class="filter col-md-3">
            <label for="product-select">Select Product:</label>
            <select id="product-select" class="form-control">
                <option value="">Select a product</option>
                @foreach ($products as $product)
                    <option class="product-link" data-id="{{ $product->id }}" value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            <div class="date-filters ">
                <label for="fromDate">From Date:</label>
                <input type="date" class="form-control" id="fromDate">
                <label for="toDate" class="mt-2">To Date:</label>
                <input type="date" class="form-control" id="toDate">
            </div>
        </div>
    </div>
</div>

<div class="col-12" id="product-details">
    <div class="card recent-sales overflow-auto">
        <div class="card-body" style="display: none;">
            <h5 class="card-title">Product Details</h5>
            <div id="product-info"></div>
            <button id="back-button" class="btn btn-primary">Back</button>
            <hr>
            <!-- Sales Sections (Discount, Retail, Wholesale) -->
            <h5 class="card-title">Discount Sales</h5>
            <div class="row">
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Quantity <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart" id="discount-total-quantity"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">P & L <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="discount-total-profit"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="discount-total-amount"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Retail Sales -->
            <h5 class="card-title">Retail Sales</h5>
            <div class="row">
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Quantity <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart" id="retail-total-quantity"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">P & L <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="retail-total-profit"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="retail-total-amount"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wholesale Sales -->
            <h5 class="card-title">Wholesale Sales</h5>
            <div class="row">
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Quantity <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart" id="wholesale-total-quantity"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">P & L <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="wholesale-total-profit"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="wholesale-total-amount"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@include('footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(document).ready(function() {
    // Hide product details section initially
    $('#product-details .card-body').hide();

    // Function to fetch and display product details and sales categories
    function fetchProductDetails(productId, fromDate = '', toDate = '') {
        $.ajax({
            url: '/products/' + productId,
            method: 'GET',
            success: function(response) {
                // Display the product details
                $('#product-info').html(`
                    <h1>${response.product.name}</h1>
                    <p>Category: ${response.product.category.name}</p>
                    <p>Product Code: ${response.product.code}</p>
                    <p>Production Cost: ${response.product.cost}</p>
                `);
                // Fetch sales categories
                fetchSalesCategories(productId, response.product.cost, fromDate, toDate);
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    }

    // Function to fetch sales categories
    function fetchSalesCategories(productId, productCost, fromDate, toDate) {
        $.ajax({
            url: '/sales/product/' + productId,
            method: 'GET',
            data: { fromDate: fromDate, toDate: toDate },
            success: function(response) {
                console.log(response, fromDate);
                // Calculate sales data
                calculateSalesData(response.discountSales, '#discount-total-quantity', '#discount-total-amount', '#discount-total-profit', productCost);
                calculateSalesData(response.retailSales, '#retail-total-quantity', '#retail-total-amount', '#retail-total-profit', productCost);
                calculateSalesData(response.wholesaleSales, '#wholesale-total-quantity', '#wholesale-total-amount', '#wholesale-total-profit', productCost);

                // Show product details section
                $('#product-details .card-body').show();
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    }

    // Function to calculate sales data
    function calculateSalesData(sales, quantitySelector, amountSelector, profitSelector, productCost) {
        let totalQuantity = 0;
        let totalAmount = 0;
        let totalProfit = 0;

        $.each(sales, function(index, sale) {
            const quantity = sale.productQuantity;
            const mrp = sale.productMrp;

            totalQuantity += quantity;
            totalAmount += quantity * mrp;
            totalProfit += (quantity * mrp) - (quantity * productCost);
        });
        console.log(totalQuantity, totalAmount, totalProfit);
        // Update the UI with the calculated data
        $(quantitySelector).text(totalQuantity);
        $(amountSelector).text(totalAmount);
        $(profitSelector).text(totalProfit);
    }

    // Handle change event on product select dropdown
    $('#product-select').change(function() {
        const productId = $(this).val();
        const fromDate = $('#fromDate').val();
        const toDate = $('#toDate').val();
        console.log(productId, fromDate, toDate);
        if (productId) {
            fetchProductDetails(productId, fromDate, toDate);
        }
    });

    // Handle change events on date inputs
    $('#fromDate, #toDate').on('change', function() {
        const productId = $('#product-select').val();
        const fromDate = $('#fromDate').val();
        const toDate = $('#toDate').val();
        console.log(fromDate, toDate, productId);
        if (productId) {
            fetchProductDetails(productId, fromDate, toDate);
        }
    });

    // Handle click event on back button to hide product details and show the product list again
    $(document).on('click', '#back-button', function() {
        $('#product-details .card-body').hide();
        $('#product-select').val(''); // Reset the select box
        $('#fromDate').val(''); // Reset the date inputs
        $('#toDate').val('');
    });
});
</script>
