<?php
require "Database/MySQL.php";
require "Repository/EstoqueRepository.php";

use database\MySQL;
use repository\EstoqueRepository;

$databaseConnection = MySQL::getInstance();
$db = $databaseConnection->getConnection();

$estoqueRepository = new EstoqueRepository($db);

$produtos = file_get_contents('test1.json');

try {
    $estoqueRepository->atualizarEstoque($produtos);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
