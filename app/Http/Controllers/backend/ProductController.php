<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use Session;
use DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {


    // Session::forget('cart',[]);
    $products = Products::all();
    $categories = Category::all();
    $carts = Session::get('cart', []);
    $cart_count = count($carts);
    $sub_amt = 0;
    $offer_amt = 0;
    foreach ($carts as $cart) {
      $sub_amt += $cart['price'] * $cart['product_qty'];
    }


    return view('backend.cart', compact('products', 'categories', 'carts', 'cart_count', 'sub_amt', 'offer_amt'))->render();
  }


  public function product_lists(Request $request)
  {

    // dd($variant_ids);
    $products = Products::where('category', $request->category_id)->get();
    // ProductVariant brand column get in select column fill
    $brands = [];
    foreach ($products as $product) {
      $brands[] = ProductVariant::where('product_id', $product->id)->get();


    }
    //  variants price list get for ProductVariant table
    foreach ($products as $product) {

      $product_variant_price = ProductVariant::where('product_id', $product->id)->orderBy('id', 'desc')->first();

      $product->variant_price = $product_variant_price->price;

    }
    // dd($products);
    //request-> product id get product variant price list
    $price_list = ProductVariant::where('id', $request->variant_id)->first();
    // dd($price_list);
    return Response()->json(['products' => $products, 'brands' => $brands, 'price_list' => $price_list]);

  }





  public function add_to_carts(Request $request)
  {

    $products = Products::find($request->product_id);

    $New_cart_array = [
      'product_id' => $request->product_id,
      'product_qty' => $request->product_qty,
      'product_name' => $products->product_name,
      'price' => $products->sale_price,
      'status' => 'active'
    ];

    $cartArray = Session::get('cart', []);

    if (!empty($cartArray[$request->product_id])) {
      $cartArray[$request->product_id]['product_qty'] = $request->product_qty;
    } else {
      $cartArray[$request->product_id] = $New_cart_array;
    }
    Session::put('cart', $cartArray);

    $carts = Session::get('cart', []);
    $cart_count = count($carts);
    $sub_amt = 0;
    $offer_amt = 0;
    $total_amt = "";
    foreach ($carts as $cart) {
      $sub_amt += $cart['price'] * $cart['product_qty'];
    }
    $cart_table_render = view('cart.cart_session', ['carts' => $carts, 'cart_count' => $cart_count])->render();
    $checkout_render = view('cart.price_list_total', ['carts' => $carts, 'sub_amt' => $sub_amt, 'offer_amt' => $offer_amt])->render();

    return response()->json(['cart_table_render' => $cart_table_render, 'sub_amt' => $sub_amt, 'offer_amt' => $offer_amt, 'checkout_render' => $checkout_render]);
  }





  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    try {
      return view('frontend.product_view');
    } catch (\Exception $e) {
      return back()->with('error', $e->getMessage());
    }
  }

  //products view page for function

  public function product_read(string $id)
  {
    try {

      $product = Products::where('id', $id)->first();

      return view('frontend.products.product_read', compact('product'));
    } catch (\Exception $e) {
      return back()->with('error', $e->getMessage())->withInput();
    }
  }

  public function product_table_view(Request $request)
  {

    try {

      $category = Products::select('*');
      $categorycount = Products::select('*');

      if (isset($request->searchdata) && $request->searchdata != '') {
        $category->where('name', 'like', '%' . $request->searchdata . '%')->orWhere('price', 'like', '%' . $request->searchdata . '%')->orWhere('category', 'like', '%' . $request->searchdata . '%')->orWhere('date', 'like', '%' . $request->searchdata . '%');
        $categorycount->where('name', 'like', '%' . $request->searchdata . '%')->orWhere('price', 'like', '%' . $request->searchdata . '%')->orWhere('category', 'like', '%' . $request->searchdata . '%')->orWhere('date', 'like', '%' . $request->searchdata . '%');
      }

      $totalcount = $categorycount->get();
      $totalcount = count($totalcount);

      $allemp = $category->orderBy('id', 'desc')->take($request->length)->skip($request->start)->get();

      $arr = array();
      $i = $request->start + 1;
      foreach ($allemp as $val) {

        $var['id'] = $val->id;
        $var['product_name'] = (isset($val->product_name)) ? $val->product_name : '';
        $var['product_img'] = (isset($val->product_images)) ? explode(',', $val->product_images) : '';
        $var['sale_price'] = (isset($val->sale_price)) ? $val->sale_price : '';
        $var['category'] = (isset($val->category_name->name)) ? $val->category_name->name : '';
        $var['date'] = (isset($val->created_at)) ? $val->created_at->todatestring() : '';

        $var['index'] = $i++;
        array_push($arr, $var);
      }

      $data['draw'] = $request->draw;
      $data['recordsTotal'] = $totalcount;
      $data['recordsFiltered'] = $totalcount;
      $data['data'] = $arr;

      return json_encode($data);

    } catch (\Exception $e) {
      return back()->with('error', $e->getMessage())->withInput();
    }

  }
  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    try {


      $product = Products::where('id', $id)->first();
      $category = Category::where('status', 'active')->get();

      return view('frontend.products.product_edit', compact('product', 'category'));
    } catch (\Exception $e) {
      return back()->with('error', $e->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {

   
    $validate = $request->validate([
      'product_name' => 'required',
      'product_description' => 'required',
      'regular_price' => 'required',
      'sale_price' => 'required',
      'stock' => 'required',
      'category' => 'required',
      'collection' => '',
      'tags' => 'required',
  ]);
  $request->validate([
      'brands' => 'required',
      'sku' => 'required',
      'price'=>'required'
  ]);
    try {
      $products = Products::find($id);
      DB::beginTransaction();

      $Files = [];
      if ($request->hasfile('product_images')) {
        foreach ($request->file('product_images') as $file) {
          $name = time() . rand(1, 50) . '.' . $file->extension();
          $file->move(public_path('product_images'), $name);
          $Files[] = 'product_images/' . $name;
        }
      }
      $validate['product_images']= implode(',', $Files);
      //previous image delete
      $image = $products->product_images;
      $remove = ltrim($image, 'product_images/');
      if (File::exists(public_path('product_images' . $remove))) {

        File::delete(public_path('product_images' . $remove));
      }
      //product update
     
      $products->update($validate);

      //variant update
      $products_count = ProductVariant::where('product_id',$id)->count();
      $product_values_get = ProductVariant::where('product_id',$id)->get();
       dd($request->brands);
      //  dd($request->sku);
      //  dd($request->price);
       for($i=0; $i < count($request->brands); $i++){
        
         if($products_count == count($request->brands)){
          
          ProductVariant::where('id', $request->variant_id[$i])->update(['brand' => $request->brands[$i], 'sku' => $request->sku[$i],'price'=>$request->price[$i]]);
         }
       }
      DB::commit();
      $msg = "Updated Successfully ";
      return response()->json(['status'=>'success','msg'=>'Updated Successfully'],200);
    } catch (\Exception $e) {
      return back()->with('error', $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {

    try {
      // $products = Products::where('id',$request->product_id);
      // $products=$request->product_id;

      $carts = Session::get('cart', []);
      unset($carts[$request->product_id]);
      Session::put('cart', $carts);
      // $newCart_sessions=Session::get('cart',[]);

      $sub_amt = 0;
      $offer_amt = 0;
      foreach ($carts as $cart) {
        $sub_amt += $cart['price'] * $cart['product_qty'];
      }
      $session_unset_render = view('cart.cart_session', ['carts' => $carts])->render();
      $total_amt_unset_render = view('cart.price_list_total', ['carts' => $carts, 'sub_amt' => $sub_amt, 'offer_amt' => $offer_amt])->render();

      return response()->json(['session_unset_render' => $session_unset_render, 'total_amt_unset_render' => $total_amt_unset_render]);


    } catch (\Exception $e) {
      return back()->with('error', $e->getMessage())->withInput();
    }

  }



}