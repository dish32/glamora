<?php
session_start();  //Allows to retrieving & storing data in cart accross the multiple pages 

if ($_SERVER["REQUEST_METHOD"] === "POST") //checking request method is POST
{
    //Gets the data sent by cart.js addToCart(product)
    //Use ?? (null coalescing operator) for avoid undefined index errors
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $image = $_POST['image'] ?? '';

    if (!isset($_SESSION['cart'])) 
    {
        $_SESSION['cart'] = [];
    }

    // Start a loop for check exisitng items in the cart
    $foundtheitem = false;
    foreach ($_SESSION['cart'] as &$items) 
    {
        if ($items['id'] == $id) //The Item ID match for item already in the cart
        {
            $items['quantity'] += 1;  //above condition true the user allows to update the quantity
            $foundtheitem = true; //Set true to skip adding it again later
            break;
        }
    }

    if (!$foundtheitem)   //The item was not found in the cart add new entry to the cart with quantity set to 01
    {
        $_SESSION['cart'][] = 
        [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'quantity' => 1
        ];
    }

    echo json_encode(['status' => 'Accomplishment!', 'message' => 'Product is Added to the Cart Page...!']);
}