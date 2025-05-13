<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductHistory;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function ProductsList(Request $request)
    {
        $products = Product::where('state', 'published');

        if ($request->get('data')['query']) {
            $products->where('name', 'LIKE', '%' . $request->get('data')['query'] . '%');
        }

        if ($request->get('data')['stock']) {
            $products->where('stock', '>=', $request->get('data')['stock']);
        }

        return $products->orderBy('price', 'DESC')
            ->get()
            ->toArray();
    }

    public function UpdateProduct(Request $request)
    {
        $product = Product::where('id', $request->get('product_id'))
            ->first();

        if ($product->price != $request->get('data')['price']) {
            ProductHistory::create([
                'product_id' => $product->id,
                'old_price'  => $product->price,
                'new_price'  => $request->get('data')['price']
            ]);
        }

        $product->update($request->get('data'));

        return json_encode(['response' => 'success']);
    }

    public function RemoveProduct(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        Product::where('id', $request->get('product_id'))
            ->update([
                'state' => 'deleted'
            ]);

        return json_encode(['response' => 'success']);
    }

    public function ProductPriceHistory(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        return ProductHistory::where('product_id', $request->get('product_id'))
            ->orderBy('created_at', 'ASC')
            ->get()
            ->toArray();
    }
}
