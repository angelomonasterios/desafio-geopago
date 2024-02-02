<?php

namespace repository;

use PDO;

class ProductRespository
{

    private EstoqueRepository $estoqueRepository;

    public function __construct(EstoqueRepository $estoqueRepository)
    {
        $this->estoqueRepository = $estoqueRepository;
    }

    public function createProducts(array $productsToCreate): void
    {
        foreach ($productsToCreate as $product) {
            $values[] = "('{$product['produto']}', '{$product['quantidade']}', '{$product['cor']}', '{$product['tamanho']}', '{$product['deposito']}', '{$product['data_disponibilidade']}')";
        }
        $values = implode(',', $values);
        $sql = "INSERT INTO estoque (produto, quantidade, cor, tamanho, deposito, data_disponibilidade) VALUES {$values};";
        $this->estoqueRepository->getDb()->exec($sql);
    }

    public function shouldUpdateProduct(string $existingDate, string $newDate): bool
    {
        return strtotime($newDate) > strtotime($existingDate);
    }

    public function updateProducts(array $productsToUpdate): void
    {
        foreach ($productsToUpdate as $id => $productDetails) {
            $updates[] = "WHEN {$id} THEN '{$productDetails['quantidade']}'";
        }
        $ids = implode(',', array_keys($productsToUpdate));
        $updates = implode(' ', $updates);
        $sql = "UPDATE estoque SET quantidade = CASE id {$updates} END WHERE id IN ({$ids});";
        $this->estoqueRepository->getDb()->exec($sql);
    }

    public function getProductId(string $produto): ?array
    {
        $stmt = $this->estoqueRepository->getDb()->prepare(EstoqueRepository::SQL_SELECT_PRODUCT);
        $stmt->bindParam(':produto', $produto);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result ?: null;
    }
}