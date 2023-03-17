<?php

namespace Controller;

include("./Model/product.model.php");


class ProductController
{
    function getAll()
    {
        echo json_encode(\Model\Product\getAll());
    }

    function getOne($id)
    {
        echo json_encode(\Model\Product\getOne($id));
    }

    function create()
    {
        $product = new \stdClass();
        $product->name = $_POST["name"];
        $product->price = $_POST["price"];
        \Model\Product\create($product);
        echo '{"message":"Produit créé"}';
    }

    function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        $product = new \stdClass();
        $product->id = $id;
        $product->name = $data->name;
        $product->price = $data->price;
        if (\Model\Product\update($product)) {
            echo '{"message":"Produit mis à jour"}';
        } else {
            return '{"message":"Produit non trouvé"}';
        }
    }

    function delete($id)
    {
        if (\Model\Product\delete($id)) {
            echo '{"message":"Produit supprimé"}';
        } else {
            return '{"message":"Produit non trouvé"}';
        }
    }
}