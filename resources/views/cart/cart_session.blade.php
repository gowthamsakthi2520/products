<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trader product</title>
    <meta name="base_url" content="{{url('/')}}" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
   <!-- bootstrap icon link -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    
  </head>
<body>

@if(!empty($carts))
  @if($carts  > 0 )
    @foreach($carts as $cart)

       <div class="col mt-4 ext-center">
       <span class="dot text-center text-light">{{$cart['product_qty']}}</span>
        <h6>{{$cart['product_name']}}</h6>
        <h6>{{$cart['price']}}</h6>
        <button class="btn btn-danger cart_del" data-id="{{$cart['product_id']}}"><span  class="bi bi-trash " style="font-size:10px" ></span></button>
       </div>
    @endforeach
  @else
    <h3>No Record Founds</h3>
   @endif
@endif


</body>
</html>
<!-- bootstrap link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<!-- Jquery links -->
<script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
