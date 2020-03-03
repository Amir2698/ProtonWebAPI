<?php

use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace

//include productsProc.php file
include __DIR__ . '/commands.php';

//read table products
$app->get('/products', function (Request $request, Response $response, array $arg){
  $data = getAllProducts($this->db);
  return $this->response->withJson(array('data' => $data), 200);
});

//request table products by condition
//search by name
$app->get('/name/[{name}]', function ($request, $response, $args){
  $Name = $args['name'];

$data = getName($this->db,$Name);
if (empty($data)) {
  return $this->response->withJson(array('error' => 'no data'), 404);
}
 return $this->response->withJson(array('data' => $data), 200);
});

//search by id
$app->get('/products/[{id}]', function ($request, $response, $args){
    $Id = $args['id'];
   if (!is_numeric($Id)) {
      return $this->response->withJson(array('error' => 'numeric parameter required'), 422);
   }
  $data = getProducts($this->db,$Id);
  if (empty($data)) {
    return $this->response->withJson(array('error' => 'no data'), 404);
 }
   return $this->response->withJson(array('data' => $data), 200);
});

//add products
$app->post('/products/add', function ($request, $response, $args) {
  $form_data = $request->getParsedBody();
  $data = createProducts($this->db, $form_data);
  if ($data <= 0) {
    return $this->response->withJson(array('error' => 'add data fail'), 500);
  }
  return $this->response->withJson(array('add data' => 'success'), 200);
});

//put table products
$app->put('/products/put/[{id}]', function ($request,  $response,  $args){
  $productId = $args['id'];
  $date = date("Y-m-j h:i:s");
  
 if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
 }
  $form_dat=$request->getParsedBody();
  
$data=updateProduct($this->db,$form_dat,$productId,$date);

if ($data <=0)
return $this->response->withJson(array('data' => 'successfully updated'), 200);
});

//delete products
$app->delete('/productsdel/[{id}]', function ($request, $response, $args){
  $Id = $args['id'];
 if (!is_numeric($Id)) {
    return $this->response->withJson(array('error' => 'numeric parameter required'), 422);
 }
$data = deleteProducts($this->db,$Id);
if (empty($data)) {
  return $this->response->withJson(array('error' => 'no data'), 200);
}
 return $this->response->withJson(array('data' => "dah delete relax lah"), 200);
});
