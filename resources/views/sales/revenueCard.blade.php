<div class="col-xxl-4 col-md-6">
    <div class="card info-card revenue-card">

      {{-- <div class="filter">
        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <li class="dropdown-header text-start">
            <h6>Filter</h6>
          </li>

          <li><a class="dropdown-item" href="#">Today</a></li>
          <li><a class="dropdown-item" href="#">This Month</a></li>
          <li><a class="dropdown-item" href="#">This Year</a></li>
        </ul>
      </div> --}}

      <div class="card-body">
        <h5 class="card-title">Total sales <span>| Month</span></h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
            <i class="bi bi-currency-rupee"></i>
          </div>
          <div class="ps-3">
            <h6><span id="totalSalesAmount"></span></h6>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $.ajax({
        url: '{{ route("getSalesData") }}',
        method: 'GET',
        success: function(response) {
            // Update the UI with the fetched data
            //$('#quantitySold').text(response.quantitySold);
            $('#totalSalesAmount').text(response.totalSalesAmount);
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });

</script>