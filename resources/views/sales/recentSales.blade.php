<div class="col-12">
    <div class="card recent-sales overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Recent Sales</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <input class="form-control searchBill" placeholder="Search..." type="search" name="search" title="Search within table">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="fromDate" placeholder="From Date">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="toDate" placeholder="To Date">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" id="filterButton">Filter</button>
                </div>
            </div>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">Bill No</th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Category</th>
                    </tr>
                </thead>
                <tbody id="billData">
                    <!-- Data will be populated here by AJAX -->
                </tbody>
            </table>
            <div>Total Quantity: <span id="totalQuantity"></span></div>
            <div>Total Amount: <span id="totalAmount"></span></div>
        </div>
    </div>
</div>

{{-- modal to show bill --}}

<div class="modal fade" id="billDetailsModal" tabindex="-1" aria-labelledby="billDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="billDetailsModalLabel">Bill Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Bill details will be populated here by AJAX -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Bill No</th>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Category</th>
                            <th scope="col">Customer number</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody id="billDetailsData">
                        <!-- Data will be populated here by AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        fetchBillData();

        function fetchBillData(query = '', fromDate = '', toDate = '') {
            $.ajax({
                url: '{{ route("getAllSales") }}',
                method: 'GET',
                data: {
                    query: query,
                    fromDate: fromDate,
                    toDate: toDate
                },
                success: function(response) {
                    console.log(response);
                    let billData = '';
                    $.each(response.bills, function(index, bill) {
                        billData += `
                            <tr>
                                <td>${bill.billNo}</td>
                                <td>${bill.product ? bill.product.name : 'N/A'}</td>
                                <td>${bill.productQuantity}</td>
                                <td>${bill.productMrp}</td>
                                <td>${bill.salesCategory}</td>
                                <td><button class="btn btn-outline-info btn-sm viewDetails" data-id="${bill.id}">Details</button></td>
                            </tr>
                        `;
                    });

                    $('#billData').html(billData);
                    $('#totalQuantity').text(response.totalQuantity);
                    $('#totalAmount').text(response.totalAmount);

                    // Attach click event to details buttons
                    $('.viewDetails').click(function() {
                        const billId = $(this).data('id');
                        fetchBillDetails(billId);
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }

        $('#filterButton').click(function() {
            let query = $('.searchBill').val();
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            fetchBillData(query, fromDate, toDate);
        });

        $('.searchBill').on('input', function() {
            let query = $(this).val();
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            fetchBillData(query, fromDate, toDate);
        });

        $('#fromDate, #toDate').on('change', function() {
            let query = $('.searchBill').val();
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            fetchBillData(query, fromDate, toDate);
        });

        function formatDate(dateString) {
            let options = { year: '2-digit', month: '2-digit', day: '2-digit' };
            return new Date(dateString).toLocaleDateString(undefined, options);
        }

        function fetchBillDetails(billId) {
            $.ajax({
                url: `/sales/${billId}`, // Assuming you have a route to get bill details
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    let formattedDate = formatDate(response.bill.created_at);
                    let billDetails = `
                        <tr>
                            <td>${response.bill.billNo}</td>
                            <td>${response.bill.product ? response.bill.product.name : 'N/A'}</td>
                            <td>${response.bill.productQuantity}</td>
                            <td>${response.bill.productMrp}</td>
                            <td>${response.bill.salesCategory}</td>
                            <td>${response.bill.phone}</td>
                            <td>${formattedDate}</td>
                        </tr>
                    `;
                    $('#billDetailsData').html(billDetails);
                    $('#billDetailsModal').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }
    });
</script>
