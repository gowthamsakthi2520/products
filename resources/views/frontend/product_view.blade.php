
<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trader product</title>
    <meta name="base_url" content="{{url('/')}}" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
     <link rel="stylesheet" href="{{asset('css/frontend/bootstrap-tables.min.css')}}">
     <link rel="stylesheet" href="{{asset('css/frontend/dataTables.bootstrap5.min.css')}}">
     <link rel="stylesheet" href="{{asset('css/frontend/icons.css')}}" >
     <link rel="stylesheet" href="{{asset('css/frontend/bootstrap.min.css.map')}}" >
     <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
     <!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
<body>
<div class="card mt-4">
          <div class="card-body">
            <div class="product-table">
              <div class="table-responsive white-space-nowrap">
                 <table id="productList" class="table table-bordered align-middle"  style="width:100%" >
                  <thead class="table-light">
                    <tr>
                      <th>S.no</th>
                      <th>Product Name</th>
                      <th>Sale Price</th>
                      <th>Category</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                   </thead>
                   <tbody>
                   

                   </tbody>
                 </table>
              </div>
            </div>
          </div>
        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


<!-- Jquery links -->
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
<script src="{{asset('js/headers/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/headers/dataTables.bootstrap5.min.js')}}"></script>
<!-- js link file -->
<script src="{{asset('js/frontend/add_to_product.js')}}"></script>
<!-- sweet alert -->
<script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
<script>
  $.ajaxSetup({
    headers:{
      'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
  });
</script>
<script>
  
$(document).ready(function() {

var reporttables =  $('#productList').DataTable({
  "order": [[ 0, "desc" ]],
      "serverSide": true,
       "stateSave": true,
      'processing': true,
      oLanguage: {sProcessing: '<div class="lds-css"><div style="width:100%;height:100%" class="lds-eclipse"><div></div><p>Please wait while we are processing your request.</p></div></div>' },
  "ajax": {
    'type': 'GET',
    'url': '{{ route("product_table") }}',
    "data": function(d){
     d.searchdata = d.search.value
    }
  },
  searching: true,
  "iDisplayLength": 10,
  "columnDefs": [
  {
    "targets": 0,
    data: 'index',
  },
  {
    "targets": 1,
    orderable: false,
    "render": function ( data, type, row, meta ) {
      return '<div class="d-flex align-items-center gap-3"><div class="product-box"><img src="../public/'+row.product_img[0]+'" alt="" width="100" height="100"></div><div class="product-info"><a href="{{route('product_reads','')}}'+'/'+row.id+'" class="product-title btn">'+row.product_name+'</a><p class="mb-0 product-category">Category : '+row.category+'</p></div></div>';
    }
  },
  {
    "targets": 2,
    orderable: false,
    "render": function ( data, type, row, meta ) {
     return row.sale_price;

    }
  },
  {
    "targets": 3,
    orderable: false,
    "render": function ( data, type, row, meta ) {
     return row.category;

    }
  },
  {
    "targets": 4,
    orderable: false,
    "render": function ( data, type, row, meta ) {
     return row.date;

    }
  },
  {
    "targets": 5,
    orderable: false,
    "render": function ( data, type, row, meta ) {
      
      return '<a href="{{route('product_reads','')}}'+'/'+row.id+'"><button class="btn btn-sm btn-light border" type="button"><i class="bi bi-eye-fill text-primary"></i></button></a><a href="cart/'+row.id+'/edit"><button class="btn btn-sm btn-light border" type="button"><i class="bi bi-pencil-square text-warning"></i></button></a><a><button class="btn btn-sm btn-light border" onclick="deleteOrder('+row.id+')"type="button"><span class="bi bi-trash text-danger"></span></button></a>';

    }
  }
  ],
  rowId: 'id'
});
});

// delete for sweet alert

function deleteOrder(id) {

swal({
  title: "Are you sure?",
  text: "Confirm to delete this Product?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes, delete it!",
  cancelButtonText: "No, cancel plx!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm){
  if (isConfirm) {
    var token = $('meta[name="csrf-token"]').attr("content");
    var formData = new FormData();
    formData.append("_token", "{{ csrf_token() }}");
    formData.append("id", id);
    $.ajax({
      url: "{{ route('add_product.destroy','') }}"+"/"+id,
      data: formData,
      type: 'DELETE',
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (res) {
        if (res) {
          swal("Deleted!", "Your Product has been deleted.", "success");
          $('#productList').DataTable().ajax.reload();
        } else {
          swal("Product Delete Failed", "Please try again. :)", "error");
        }
      }
    });

  } else {
  swal("Cancelled", "Cancelled", "error");
  }
});
}
</script>
</body>
</html>