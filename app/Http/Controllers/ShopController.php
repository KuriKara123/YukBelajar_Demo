<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size', 12);

        $order = $request->query('order', -1);
        $o_column = 'id';
        $o_order = 'DESC';

        switch ($order) {
            case 1:
                $o_column = 'created_at';
                $o_order = 'DESC';
                break;
            case 2:
                $o_column = 'created_at';
                $o_order = 'ASC';
                break;
            case 3:
                $o_column = 'regular_price';
                $o_order = 'ASC';
                break;
            case 4:
                $o_column = 'regular_price';
                $o_order = 'DESC';
                break;
        }

        $f_brands = $request->query('brands', '');
        $f_categories = $request->query('categories', '');
        $min_price = $request->query('min', 1);
        $max_price = $request->query('max', 500000);

        $brands = Brand::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();

        $products = Product::query();

        if (!empty($f_brands)) {
            $products->whereIn('brand_id', explode(',', $f_brands));
        }

        if (!empty($f_categories)) {
            $products->whereIn('category_id', explode(',', $f_categories));
        }

        $products->where(function ($query) use ($min_price, $max_price) {
            $query->whereBetween('regular_price', [$min_price, $max_price])
                  ->orWhereBetween('sale_price', [$min_price, $max_price]);
        });

        $products = $products->orderBy($o_column, $o_order)->paginate($size);

        return view('shop', [
            'products' => $products,
            'size' => $size,
            'order' => $order,
            'brands' => $brands,
            'f_brands' => $f_brands,
            'categories' => $categories,
            'f_categories' => $f_categories,
            'min_price' => $min_price,
            'max_price' => $max_price
        ]);
    }

    public function product_details($product_slug){
        $product = Product::where('slug',$product_slug)->first();
        $rproducts = Product::where('slug','<>',$product_slug)->get()->take(8);
        return view('details',compact('product','rproducts'));
    }
}
