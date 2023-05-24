<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use File;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductVariant;
use Response;
use Session;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $categories=Category::orderBy('id','desc')->where('status','active')->get();
      return view('frontend.products.add_products',['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validate = $request->validate([
            'product_name'=>'required',
            'product_description'=>'required',
            'product_images' => 'required',
            'regular_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required',
            'category'=>'required',
            'collection'=>'',
            'tags'=>'required',
        ]);

         $request->validate([
            'brands' => 'required',
            'sku' => 'required',
            'var_price'=>'required'
        ]);
        
       
        try {
            DB::beginTransaction();
            $files = [];

            if ($request->hasfile('product_images')) {

                foreach ($request->file('product_images') as $file) {

                    $name = time() . rand(1, 50) . '.' . $file->extension();

                    $file->move(public_path('product_images'), $name);
                    $files[] = 'product_images/' . $name;

                }

            }
            $validate['product_images'] = implode(',', $files);
            $product = Products::create($validate); 
            $brands=$request->brands;
            $sku=$request->sku;
            $var_price=$request->var_price;
            
            for($i=0;$i<count($request->brands);$i++){   
              ProductVariant::create(['product_id' => $product->id,'brand'=>$brands[$i],'sku'=>$sku[$i],'price'=>$var_price[$i]]);
            }
          
            DB::commit();
            $msg = "Product added successfully";
            return redirect('/create')->with(['success' => $msg]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }


    /**
     * Session Card blade view.
     */
    public function cart_details()
    {
    //    $carts = Session::get('cart',[]);
       return view('cart.cart_session');
    }

    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { 

        try{
            $product_count=Products::where('id',$id)->count();
            if($product_count > 0){
            $product = Products::find($id);
            $product->delete();
            return response()->json(['status'=>true,'msg'=>'success'],200);
            }
            else{
                return response()->json(['status'=>true,'msg' => 'error'],200);
            }
        }
        catch(\Exception $e){
            return back()->with('error',$e->getMessage())->withInput();
        }
    }
}
