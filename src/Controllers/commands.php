<?php

//get all products
function getAllProducts($db)
{
    $sql = 'SELECT * FROM products';
    $stmt = $db->prepare ($sql);
    $stmt ->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//get product by name
function getName($db, $carName)
{
$sql = 'SELECT * FROM products WHERE name = :name';
$stmt = $db->prepare ($sql);
$name = $carName;
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//add product
function createProducts($db,$form_data){
    $sql = 'INSERT INTO products (`id`, `name`, `description`, `price`, `category`) VALUES (:id, :name, :description, :price, :category)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $form_data['id']);
    $stmt->bindParam(':name', $form_data['name']);
    $stmt->bindParam(':description', $form_data['description']);
    $stmt->bindParam(':price', $form_data['price']);
    $stmt->bindParam(':category', $form_data['category']);
    $stmt->execute();
    return $db->lastInsertID(); //Insert last number 
}

//update product by id
function updateProduct($db,$form_dat,$productId,$date) {
    $sql = 'UPDATE products SET name = :name , description = :description , price = :price , category = :category , created = :created , modified = :modified ';
    $sql .=' WHERE id = :id';

    $stmt = $db->prepare ($sql);
    $id = (int)$productId;
    $mod = $date;

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $form_dat['name']);
    $stmt->bindParam(':description', $form_dat['description']);
    $stmt->bindParam(':price', floatval($form_dat['price']));
    $stmt->bindParam(':category', intval($form_dat['category']));
    $stmt->bindParam(':created', $mod , PDO::PARAM_STR);
    $stmt->bindParam(':modified', $mod , PDO::PARAM_STR);
    $stmt->execute();
}

function deleteProducts($db, $Id)
{
$sql = 'DELETE FROM products WHERE id = :id'; 
$stmt = $db->prepare ($sql);
$id = (int) $Id;
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
}
