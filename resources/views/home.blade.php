@include('header')
@include('nav')

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@php
    $categories = \App\Models\Category::all();
    $products = \App\Models\Product::all();
@endphp

<div class="row">
    <div class="col-lg-6">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Product Form</h5>

          <!-- product Form for entering details of product-->
            <form class="row g-3" action="{{ route('storeProduct') }}" method="POST">
                @csrf
                <div class="col-12">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" class="form-control @error('productName') is-invalid @enderror" id="productName" name="productName" value="{{ old('productName') }}">
                    @error('productName')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="productId" class="form-label">Product ID</label>
                    <input type="number" class="form-control @error('productId') is-invalid @enderror" id="productId" name="productId" value="{{ old('productId') }}">
                    @error('productId')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="productCost" class="form-label">Product Cost</label>
                    <input type="number" class="form-control @error('productCost') is-invalid @enderror" id="productCost" name="productCost" value="{{ old('productCost') }}">
                    @error('productCost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="productCategory" class="form-label">Product Category</label>
                    <select class="form-select @error('productCategory') is-invalid @enderror" id="productCategory" name="productCategory">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option class="text-capitalize" value="{{ $category->id }}" {{ old('productCategory') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('productCategory')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>

        </div>
      </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Category Form</h5>
                <div class="col-12">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCatModal">Add New Category</button>
                    @include('addCat')
                </div>
                <br>
                <ul class="text-capitalize">
                    @foreach ($categories as $category)
                        <li> <button class="btn btn-outline-danger btn-sm ri-delete-bin-5-line" onclick="deleteCategory({{ $category->id }})"></button>&nbsp;{{ $category->name }}</li>
                    @endforeach
                </ul>
                <h5 class="card-title">Products</h5>
                <ul class="text-capitalize">
                    @foreach ($products as $product)
                        <li><button class="btn btn-outline-danger btn-sm ri-delete-bin-5-line" onclick="deleteProduct({{ $product->id }})"></button>&nbsp;{{ $product->name }} </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
        function deleteCategory(categoryId) {
            if (confirm('Are you sure you want to delete this category?')) {
                // Get the CSRF token value
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Include the CSRF token in your AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                // Perform AJAX request to delete the category
                $.ajax({
                    url: '/delete-category/' + categoryId,
                    method: 'DELETE',
                    success: function(response) {
                        // Reload the page or update the UI as needed
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('An error occurred while deleting the category.');
                    }
                });
            }
        }
    
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                // Perform AJAX request to delete the product
                // Get the CSRF token value
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Include the CSRF token in your AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.ajax({
                    url: '/delete-product/' + productId,
                    method: 'DELETE',
                    success: function(response) {
                        // Reload the page or update the UI as needed
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('An error occurred while deleting the product.');
                    }
                });
            }
        }
    </script>
  
@include('footer')