// isNumber Function for input value

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charcode = (evt.which) ? evt.which : evt.keycode;
    if (charcode > 31 && (charcode < 48 || charcode > 57)) {
        return false;
    }
    return true;
}


// products adding for add rows and remove rows

$(document).on('click', '.add_row', function () {
    var html = "";
    html += '<div class="row g-3" id="inputFormRow">';
    html += '<div class="col-12">';
    html += '<input type="text" class="form-control" id="Brand" name="brands[]" placeholder="Brand" value="">';
    html += '<span class="text-danger brands"></span>';
    html += '</div>';
    html += '<div class="col-12">';
    html += '<input type="text" class="form-control" id="SKU" name="sku[]" placeholder="SKU" value="">';
    html += '<span class="text-danger sku"></span>';
    html += '</div>';
    html += '<div class="col-12">';
    html += '<label for="price" class="form-label fw-bold">Price</label>';
    html += '<input type="text" class="form-control" id="var_price" name="var_price[]" placeholder="Price" value="">';
    html += '<span class="text-danger var_price"></span>';
    html += '</div>';
    html += '<div class="input-group-append col-4">';
    html += '<button id="removeRow" type="button" class="btn btn-danger ">Remove</button>';
    html += '</div>';
    $('.add_new_row').append(html);

});
// remove row
$(document).on('click', '#removeRow', function () {
    $(this).closest('#inputFormRow').remove();
});

// products list

$(document).on('click', '.product_lists', function () {
    var category_id = $(this).data('category_id');
    var token = $('meta[name="csrf-token"]').attr('content');
    var path = $('meta[name="base_url"]').attr('content') + '/product_lists';

    $.ajax({
        url: path,
        method: 'GET',
        data: {
            _token: token,
            category_id: category_id
        },
        success: function (data) {
            var product = "";
            var x = 0;
            console.log(data.variant_ids);
            console.log(data.brands);
            for (var i = 0; i < data.products.length; i++) {
                var image = data.products[i].product_images;
                var product_images = image.split(',');
                var product_qty = 1;
                product += '<div class="col-md-4 col-6"><div class="product-section mb-4"> <div class="row"><div class="col-md-4 d-flex align-items-center justify-content-center"><div class="product-img">';

                product += '<img src="' + data.products[i].product_images + '" alt=""></div></div><div class="col-md-8"><h5>' + data.products[i].product_name + '</h5> <div class="price"><h6 class="mb-0 " id="price_list_view'+data.products[i].id+'">₹' + data.products[i].variant_price + ' </h6><h6><span>₹<del>' + data.products[i].regular_price + '</del></span></h6> </div><div class="qty-container mt-3"><button class="qty-btn-minus btn-primary btn-light qty-btn" data-type="decrement" data-id=' + data.products[i].id + '  type="button" >-</button><input type="text" name="qty" min=1 onkeypress="return isNumber(event)" value="' + product_qty + '" class="input-qty input-qty' + data.products[i].id + '"/><button class="qty-btn-plus btn-light qty-btn btn-primary" data-type="increment" data-id=' + data.products[i].id + ' type="button" >+</button></div></div><div class="offer-section"> 5 BOX</div>';

                product += '<select ><option>Select Brand</option>';
                for (var x = 0; x < data.brands.length; x++) {
                    for (var y = 0; y < data.brands[x].length; y++) {
                        if (data.products[i].id == data.brands[x][y].product_id)
                            product += '<option class="price_list_show"value="' + data.brands[x][y].brand + '"  data-variant_price_pid=' +data.brands[x][y].id+ '>' + data.brands[x][y].brand + '</option>';
                    }
                }
                product += '</select>';

                product += '<div class="mt-3 text-center"><button class="btn btn-primary add_to_cart" data-product_id=' + data.products[i].id + '>Add to cart</button></div></div></div></div>';

                $('.product_show').html(product);

            }

        }
    });
});


// value increment decrement

$(document).on("click", ".qty-btn", function () {
    var product_id = $(this).data('id');
    var product_qty = $('.input-qty' + product_id).val();
    if ($(this).data('type') == "increment") {
        $('.input-qty' + product_id).val(Number(product_qty) + 1);
        $('.input-qty-hidden' + product_id).val(Number(product_qty) + 1);
    } else {

        if (Number(product_qty) <= 1) {
            return false;
        }
        $('.input-qty' + product_id).val(Number(product_qty) - 1);
        $('.input-qty-hidden' + product_id).val(Number(product_qty) - 1);
    }
})


// add to cart click button for ajax call
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).on('click', '.add_to_cart', function () {

    var product_id = $(this).data('product_id');
    var product_qty = $('.input-qty' + product_id).val();
    var token = $('meta[name="csrf-token"]').attr('content');
    var path = $('meta[name="base_url"]').attr('content') + '/add_to_cart';

    $.ajax({
        url: path,
        method: 'POST',
        data: {
            _token: token,
            product_qty: product_qty,
            product_id: product_id
        },
        success: function (data) {

            $('.cart_detail_view').html(data.cart_table_render);
            $('.cart_count').html(data.cart_count);
            $('.sub_amt').html(data.sub_amt);
            $('.offer_amt').html(data.offer_amt);
            $('.checkout_render').html(data.checkout_render);

        }
    });

});



// cart product delete 

$(document).on('click', '.cart_del', function () {
    var product_id = $(this).data('id');
    console.log(product_id);
    var path = $('meta[name="base_url"]').attr('content') + '/cart_session_delete';
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: path,
        method: "POST",
        data: {
            _token: token,
            product_id: product_id
        },
        success: function (data) {
            $('.cart_detail_view').html(data.session_unset_render);
            $('.checkout_render').html(data.total_amt_unset_render);
        }
    });
});



// product price variant lists

// $(document).on('change','.price_list_show',function(){
//  alert('hi');
//     var price_product_id=$(this).data('variant_price_pid');
//     var path=$('meta[name="base_url"]').attr('content')+'/product_lists';
//     var token = $('meta[name="csrf-token"]').attr('content');
//     console.log(price_product_id);
//     $.ajax({
//         url:path,
//         method:'GET',
//         data:{_token:token,price_product_id:price_product_id},
//         success:function(data){

//         }
//     });
// });

$(document).on('change', 'select', function () {
    var selected = $(this).find('option:selected');
    var variant_id = selected.data('variant_price_pid');
    
    var path = $('meta[name="base_url"]').attr('content') + '/product_lists';
    var token = $('meta[name="csrf-token"]').attr('content');
    // alert(variant_id);
    $.ajax({
        url: path,
        method: 'GET',
        data: {
            _token: token,variant_id:variant_id
        },
        success: function (data) {
            var product_id = data.price_list.product_id;
          $('#price_list_view'+product_id).html('₹. '+data.price_list.price);


        }
    });
});
