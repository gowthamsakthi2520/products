<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trader product</title>
    <meta name="base_url" content="{{url('/')}}" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/frontend/main.css')}}">
  </head>
<body>
<div class="container">
    
<nav>
<div class="nav nav-tabs mt-5" id="nav-tab">
@foreach($categories as $key => $category)

<button class="nav-link {{$key == 0 ?'active' : '' }} product_lists" id="" data-bs-toggle="tab" 
data-category_id="{{$category->id}}" data-bs-target="#{{$category->slug}}" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">{{$category->name}}</button>

@endforeach
    <div class="row product_show">

    </div>
  </div>
</nav>
</div>

<div class="card" style="width: 18rem;">

  <div class="card-body">
    <h5 class="card-title">Cart Details</h5>
  </div>
  <ul class=" container">
    <div class="row">

        <div class="col cart_detail_view">
            @include('cart.cart_session')
        </div>
    </div>
  </ul>
</div>
<div  class="checkout_render">
@include('cart.price_list_total')
</div>


</body>
</html>
<!-- bootstrap link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<!-- Jquery links -->
<script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
<script src="{{ asset('js/frontend/add_to_product.js') }}"></script>



<script>



</script>