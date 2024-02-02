<?php
namespace Helpers;

class GenerateTestCasesHelper
{
    public function generateTestData(int $quantity): array
    {
        $testData = [];
        $productTemplate = [
            "produto" => "11.01.0568",
            "cor" => "08",
            "tamanho" => "P",
            "deposito" => "DEP1",
            "data_disponibilidade" => "2023-05-01",
            "quantidade" => 10
        ];
        $tamanhoOptions = ["P", "M", "G", "GG"];
        $depositoOptions = ["DEP1", "DEP2", "DEP3", "DEP4", "DEP5"];
        // generate 1000 test products
        for ($i = 0; $i < $quantity; $i++) {
            $chance = rand(0, 100); // generate a random number between 0 and 100
            if ($chance < 10 && count($testData) > 0) { // 10% chance to add duplicate
                $random_index = array_rand($testData);
                $testData[] = $testData[$random_index];
                continue;
            }
            $newProduct = $productTemplate;
            $newProduct["produto"] = "11.01." . str_pad((string)$i, 4, "0", STR_PAD_LEFT); // pad number with zeros
            $newProduct["cor"] = str_pad((string)rand(1, 20), 2, "0", STR_PAD_LEFT); // random color from 01 to 20
            $newProduct["tamanho"] = $tamanhoOptions[array_rand($tamanhoOptions)]; // random size
            $newProduct["deposito"] = $depositoOptions[array_rand($depositoOptions)]; // random deposit
            $newProduct["quantidade"] = rand(1, 100); // random quantity from 1 to 100
            $testData[] = $newProduct;
        }
        return $testData;
    }

}