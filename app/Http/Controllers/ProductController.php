<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return response()->json($product, 200);
    }

    public function delete(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }

    public function uploadProducts(Request $request)
    {
        if (!$file = $request->file('csv')) {
            return response()->json(null, 500);
        }

        $filename = $file->getRealPath();
        $csv_file = file($filename);
        $headers = str_getcsv($csv_file[0]);
        $products = [];
        $existing_products = DB::table('products')->pluck('id', 'sku')->all();
        foreach ($csv_file as $i => $line) {
            if ($i !== 0) {
                $data = [];
                $product_fields = str_getcsv($line);

                foreach ($product_fields as $key => $value) {
                    $data[$headers[$key]] = $value;
                }

                $data = $this->buildData($data);
                if (isset($existing_products[$data['sku']])) {
                    $product = Product::find($existing_products[$data['sku']]);
                    $product->update($data);
                } else {
                    $product = Product::create($data);
                }

                $products[] = $product;
            }
        }

        return response()->json($products, 200);
    }

    public function buildData($data): array
    {
        if (isset($data['availability']) && $data['availability'] === 'TRUE') {
            $data['availability'] = 1;
        } elseif(isset($data['availability']) && $data['availability'] === 'FALSE') {
            $data['availability'] = 0;
        }

        return [
            'sku' => isset($data['sku']) ? $data['sku'] : '',
            'title' => isset($data['title']) ? $data['title'] : '',
            'price' => isset($data['price']) ? (float) $data['title'] : 0.00,
            'description' => isset($data['description']) ? $data['description'] : '',
            'availability' => isset($data['availability']) ? (bool) $data['availability'] : 0,
            'color' => isset($data['color']) ? $data['color'] : '',
            'diminsions' => isset($data['diminsions']) ? $data['diminsions'] : ''
        ];
    }
}
