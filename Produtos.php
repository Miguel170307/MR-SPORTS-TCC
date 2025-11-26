<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/Produto.php';
include_once '../controllers/ProdutoController.php';

$database = new Database();
$db = $database->getConnection();

$requestMethod = $_SERVER["REQUEST_METHOD"];
$produtoId = isset($_GET['id']) ? $_GET['id'] : null;

$controller = new ProdutoController($db, $requestMethod, $produtoId);
$controller->processRequest();
?>
