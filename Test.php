<?php

require "Database/MySQL.php";
require "Repository/EstoqueRepository.php";
require "Helpers/GenerateTestCasesHelper.php";


use database\MySQL;
use Helpers\GenerateTestCasesHelper;
use PHPUnit\Framework\TestCase;
use repository\EstoqueRepository;

class Test extends TestCase
{

    public function test()
    {
        $testCases  = (new GenerateTestCasesHelper())->generateTestData(1000);

        $databaseConnection = MySQL::getInstance();
        $db = $databaseConnection->getConnection();

        $estoqueRepository = new EstoqueRepository($db);

        $produtos = json_encode($testCases);

        $this->assertTrue($estoqueRepository->atualizarEstoque($produtos));
    }
}
