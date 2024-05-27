<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <button type="button" class="btn btn-primary nav-link " data-bs-toggle="modal" data-bs-target="#addBillModal">
          <li class="bi bi-book"></li>
          &nbsp;  &nbsp; Add New Bill 
        </button>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link " href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="ri-home-3-line"></i>
          <span>Master</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('products.index') }}">
          <i class="ri-home-3-line"></i>
          <span>Report</span>
        </a>
      </li><!-- End Dashboard Nav -->
    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

  @include('bills.add')

