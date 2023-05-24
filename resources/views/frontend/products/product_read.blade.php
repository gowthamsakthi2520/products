<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trader product</title>
    <meta name="base_url" content="{{ url('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('css/frontend/bootstrap-tables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/bootstrap.min.css.map') }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        .user-view-table th,
        .user-view-table td {
            border: solid 0.5px;
            padding: 10px;
        }

    </style>
</head>

<body>

    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav class="mb-0" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-sa-simple">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">View Product</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="table-container pos-relative mt-1">

                    <div class="mt-40">
                        <table style="width:100%" class="user-view-table">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="fw-bolder bg-gray p10 text-center text-light bg-dark"> Product Information</td>
                                </tr>
                                <tr>

                                    <th>Product Name</th>
                                    <td>{{ isset($product)? $product->product_name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Product Description</th>
                                    <td>{{ isset($product)?$product->product_description : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Product Image</th>
                                    <td>
                                        
                                        @foreach(explode(',',$product->product_images ) as $img) 
                                            <img src="{{ asset($img) }}" alt="Image" width="100">
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="fw-bolder bg-gray p10 text-center text-light bg-dark">Organize</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ isset($product)?$product->category : '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Tags</th>
                                    <td>{{ isset($product)?$product->tags : '' }}</td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="fw-bolder bg-gray p10 text-center text-light bg-dark">Organize</td>
                                </tr>
                                <tr>
                                    <th>Pricing</th>
                                    <td>₹{{ isset($product)?$product->sale_price : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Stocks</th>
                                    <td>{{ isset($product)?$product->stock :'' }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="fw-bolder bg-gray p10 text-center bg-dark text-light">Varients</td>
                                </tr>
                                <tr>
                                    <th>Brand</th>
                                    <td>
                                        @foreach($product->product_variants as $brand)
                                            {{ $brand->brand }}
                                        @endforeach
                                    </td>
                                </tr>

                                <tr>
                                    <th>SKU</th>
                                    <td>
                                        @foreach($product->product_variants as $product)
                                            {{ $product->sku }}
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!--end main content-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <!-- Jquery links -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
    <script src="{{ asset('js/headers/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/headers/dataTables.bootstrap5.min.js') }}"></script>
    <!-- js link file -->
    <script src="{{ asset('js/frontend/add_to_product.js') }}"></script>
    <!-- sweet alert -->
    <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
    <script>
        < /body> < /
        html >
