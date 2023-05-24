<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trader product</title>
    <meta name="base_url" content="{{url('/')}}" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
<div class="container mt-5" style="width:500px;">
<form  enctype="multipart/form-data"  id="add_products"> 
         
       @csrf
             <div class="mb-4">
               <h5 class="mb-3">Product Title</h5>
               <input type="text" name="product_name" id="product_name" class="form-control" placeholder="write title here...." value="{{old('product_name')}}">
               <span class="text-danger product_name"></span>

            </div>
            <div class="mb-4">
              <h5 class="mb-3">Product Description</h5>
              <textarea class="form-control" name="product_description" id="product_description" cols="4" rows="6" placeholder="write a description here..">{{old('product_description')}}</textarea>
             <span class="text-danger product_description"></span>
            </div>
            <div class="mb-4">
             <h5 class="mb-3">Display images</h5>
             <input type="file" name="product_images[]" class="form-control" id="product_images" accept=".jpg, .png, image/jpeg, image/png" multiple>
             <span class="text-danger product_images"></span>
           </div>
           <div class="mb-4">
             <h5 class="mb-3">Inventory</h5>
                     <div class="row g-3">
                       <div class="col-12 col-lg-6">
                         <h6 class="mb-2">Regular price</h6>
                         <input class="form-control" type="text" name="regular_price" id="regular_price" value="{{old('regular_price')}}" placeholder="₹₹₹">
                         <span class="text-danger regular_price"></span>
                       </div>
                       <div class="col-12 col-lg-6">
                         <h6 class="mb-2">Sale price</h6>
                         <input class="form-control" type="text" name="sale_price" id="sale_price" value="{{old('sale_price')}}" placeholder="₹₹₹">
                         <span class="text-danger sale_price"></span>
                       </div>
                     </div>
                   </div>

                     <h6 class="mb-3">Add to Stock</h6>
                     <div class="row g-3">
                       <div class="col-sm-7">
                         <input class="form-control" type="number" placeholder="Quantity" value="{{old('stock')}}" name="stock" id="stock">
                       <span class="text-danger stock"></span>
                       </div>
                       <!-- <div class="col-sm">
                         <button class="btn btn-outline-primary"><i class="bi bi-check2 me-2"></i>Confirm</button>
                       </div> -->
                     </div>

 
       <div class="card">
         <div class="card-body">
            <h5 class="mb-3">Organize</h5>
               <div class="row g-3">
                   <div class="col-12">
                     <label for="AddCategory" class="form-label fw-bold">Category</label>
                     <select class="form-select" id="AddCategory" name="category">
                                <option value="">Select Category</option>
                                @foreach($categories as $c)
                                <option value="{{$c->id}}" {{old('category') == $c->id ? 'selected' : ''}}>{{$c->name}}</option>
                                @endforeach
                              </select>
                     <span class="text-danger category"></span>
                   </div>
                   <div class="col-12">
                     <label for="Collection" class="form-label fw-bold">Collection</label>
                     <input type="text" class="form-control" id="Collection" name="collection" placeholder="Collection" value="{{old('collection')}}">
                    <span class="text-danger collection"></span>
                   </div>
                   <div class="col-12">
                     <label for="Tags" class="form-label fw-bold">Tags</label>
                     <input type="text" class="form-control" id="Tags" name="tags" placeholder="Tags" value="{{old('tags')}}" data-role="tagsinput" >
                     <span class="text-danger tags"></span>
                   </div>
         <div class="card">
           <div class="card-body">
             <h5 class="mb-3">Variants</h5>
             <div class="row g-3 " id="inputFormRow">
               <div class="col-12">
                 <label for="Brand" class="form-label fw-bold">Brand</label>
                 <input type="text" class="form-control" id="Brand" name="brands[]" placeholder="Brand" value="{{old('brands')}}">
                 <span class="text-danger brands"></span>
                </div>
               <div class="col-12">
                 <label for="SKU" class="form-label fw-bold">SKU</label>
                 <input type="text" class="form-control" id="SKU" name="sku[]" placeholder="SKU" value="{{old('sku')}}">
                 <span class="text-danger sku"></span>
                </div> 
                <div class="col-12">
                 <label for="price" class="form-label fw-bold">Price</label>
                 <input type="text" class="form-control" id="var_price" name="var_price[]" placeholder="Price" value="{{old('price')}}">
                 <span class="text-danger var_price"></span>
                </div>  
                <div class="row g-3 add_new_row"></div>
                <div class="col-12">
                  <button type="button" class="btn btn-success add_row">Add</button>

                </div>
                <div class="card">
         <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
             <button type="submit"  class="btn btn-primary px-4 publish_btn">Publish</button>
            </div>
         </div>
       </div>       
</form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


<!-- Jquery links -->
<script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
<!-- js link file -->
<script src="{{asset('js/frontend/add_to_product.js')}}"></script>
<!-- Sweet alert link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $.ajaxSetup({
    headers:{
      'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
  });
</script>
<script>
$('#add_products').submit(function(e){
  e.preventDefault();
  var path = $('meta[name="base_url"]').attr('content')+'/add_product.store';
  var form = $('#add_products')[0];
  var formData = new FormData(form);
  console.log(formData);
  $.ajax({
    url:"{{route('add_product.store')}}",
    method:'POST',
    data:formData,
    processData:false,
    contentType:false,
    success:function(data){
     swal("Added!","Product Has Been Added Successfully!","success");
     $('#add_products')[0].reset();
    },
    error:function(xhr){
    $('.err').html('');
    $.each(xhr.responseJSON.errors,function(key,value){
      $('.'+key).append('<div class="text-danger err">'+value+'</div>');
    });
    }
  });

})
</script>

</body>
</html>
