<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request){
        $keyword = $request->get('search');
        $perPage = 5;
        if(!empty($keyword)){
            $products = Product::where('name','LIKE',"%$keyword%")
                ->orWhere('category','LIKE',"%$keyword%")
                ->latest()->paginate($perPage);
        }
        else{
            $products = Product::latest()->paginate($perPage);
        };
        return view('products.index',['products'=>$products])->with('i',(request()->input('page',1)-1 )*5);
    }
    public function create(){
        $product ="Create product";
        return view('products.create',['product'=>$product]);
    }
    public function store(Request $request){
        $request->validate([
            'name'  => 'required',
            'image'  => 'required | image | mimes:jpg,png,jpeg,svg | max:2028',
            'description'  => 'required',
            'category'  => 'required',
            'price'  => 'required',
        ]);

        $product =new Product;

        //déplace le fichier téléchargé vers un répertoire spécifié sur le serveur en le renommant avec le nom généré
        $file_name = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'),$file_name);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->category = $request->category;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->image = $file_name;

        $product->save();

        return redirect()->route('products.index')->with('Success','Product Added Successfully');
    }
    public function edit($id){
        $product = Product::findOrFail($id);
        return view('products.edit',['product'=>$product]);
    }
    public function update(Request $request, Product $product){
        $request->validate([
            'name'  => 'required',

        ]);
        $file_name = $request->hidden_prod_img;
        if($request->image != ''){
            $file_name = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'),$file_name);
        }
        $product = Product::find($request->hidden_id);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->category = $request->category;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->image = $file_name;

        $product->save();
        return redirect()->route('products.index')->with('Success','Product updated successfully');
    }
    public function destroy($id){
        $product = Product::findOrFail($id);
        $image_path = public_path()."/images/";
        $image = $image_path. $product->image;
        if(file_exists($image)){
            @unlink($image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('Success','Product deleted successfully');
    }
}
