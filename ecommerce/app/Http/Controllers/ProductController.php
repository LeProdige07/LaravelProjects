<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    //
    public function addproduct()
    {
        $categories = Category::all()->pluck('category_name', 'category_name');

        return view('admin.addproduct')->with('categories', $categories);
    }
    public function products()
    {
        $products = Product::all();

        return view('admin.products')->with('products', $products);
    }
    public function saveproduct(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'product_price' => 'required',
            'product_category' => 'required',
            'product_image' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('product_image')) {
            //nom de l'image avec extension
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
            //nom  du fichier
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //extension
            $ext = $request->file('product_image')->getClientOriginalExtension();
            //nom de l'image to store
            $fileNameToStrore = $filename . '_' . time() . '.' . $ext;
            //upload image et creation du dossier de stockage
            $path = $request->file('product_image')->storeAs('public/product_images', $fileNameToStrore);
        } else {
            $fileNameToStrore = 'noimage.jpg';
        }


        $product = new Product();
        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');
        $product->product_image = $fileNameToStrore;
        $product->status = 1;

        $product->save();
        return back()->with('status', 'Le produit a ete enregistre avec succes !!');
    }

    public function edit_product($id)
    {
        $product = Product::find($id);

        $categories = Category::all()->pluck('category_name', 'category_name');
        return view('admin.editproduct')->with('categories', $categories)->with('product', $product);
    }
    public function updateproduct(Request $request)
    {

        $this->validate($request, [
            'product_name' => 'required',
            'product_price' => 'required',
            'product_category' => 'required',
            'product_image' => 'image|nullable|max:1999'
        ]);

        $product = Product::find($request->input('id'));
        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');

        if ($request->hasFile('product_image')) {
            //nom de l'image avec extension
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
            //nom  du fichier
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //extension
            $ext = $request->file('product_image')->getClientOriginalExtension();
            //nom de l'image to store
            $fileNameToStrore = $filename . '_' . time() . '.' . $ext;
            //upload image et creation du dossier de stockage
            $path = $request->file('product_image')->storeAs('public/product_images', $fileNameToStrore);

            if ($product->product_image != 'noimage.jpg') {
                Storage::delete('public/products_images/' . $product->product_image);
            }

            $product->product_image = $fileNameToStrore;
        }

        $product->update();

        return redirect('/products')->with('status', 'Le produit a ete modifie avec succes !!');
    }
    public function delete_product($id)
    {
        $product = Product::find($id);

        if ($product->product_image != 'noimage.jpg') {
            Storage::delete('public/products_images/' . $product->product_image);
        }

        $product->delete();

        return back()->with('status', 'Le produit a ete supprime avec succes !!');
    }

    public function activer_product($id)
    {

        $product = Product::find($id);

        $product->status = 1;

        $product->save();

        return back();
    }
    public function desactiver_product($id)
    {

        $product = Product::find($id);

        $product->status = 0;

        $product->save();

        return back();
    }
    public function select_by_cat($category_name)
    {
        $products = Product::all()->where('product_category', $category_name)->where('status', 1);
        $categories = Category::all();
        return view('client.shop', compact('products', 'categories'));
    }

}
