<?php
    namespace Model\Product;

    function getData()
    {
        $products = file_get_contents("data/product.json");
        return json_decode($products);
    }
    function getAll()
    {
        return getData()->listProduct;
    }
    
    function getOne($id)
    {
        $products = getData();
        $result = array_filter($products->listProduct, function ($user) use ($id) {
            return $user->id == $id;
        });
        return array_shift($result);
    }
    
    function create($product)
    {
        $products = getData();
    
        $product->id = ++$products->id;
        $products->listProduct[] = $product;
        file_put_contents("data/product.json", json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    
    function update($product)
    {
        $products = getData();
        $key = array_search($product->id, array_column($products->listProduct, 'id'));
        if ($key !== false) {
            $products->listProduct = array_replace($products->listProduct, array($key => $product));
            file_put_contents("data/product.json", json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return true;
        } else {
            return false;
        }
    }
    
    function delete($id)
    {
        $products = getData();
        $before = count($products->listProduct);
    
        $products->listProduct = array_filter($products->listProduct, function ($product) use ($id) {
            return $product->id != $id;
        });
        if($before == count($products->listProduct) +1){
            file_put_contents("data/product.json", json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return true;
        }else{
            return false;
        }
    }