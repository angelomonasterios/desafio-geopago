<?php

namespace repository;
require 'IRepository.php';
require 'ProductRespository.php';
require  'Helpers/JsonHelper.php';

use Exception;
use Helpers\JsonHelper;
use PDO;
use PDOException;


class EstoqueRepository implements IRepository
{
    private PDO $db;

    const SQL_SELECT_PRODUCT = 'SELECT id, data_disponibilidade FROM estoque WHERE produto = :produto';
    private ProductRespository $productRespository;
    private JsonHelper $jsonHelper;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->productRespository = new ProductRespository($this);
        $this->jsonHelper = new JsonHelper();
    }

    /**
     * @param string $produtos
     * @return bool
     * @throws Exception
     *  clase responsable por o delete e update sendo a unica a ser obrigada a implementar pelo
     * repository
     */
    public function atualizarEstoque(string $produtos): bool
    {
        try {
            $this->db->beginTransaction();

            $cleanList = $this->cleanProductList($produtos);

            $productsToUpdate = [];
            $productsToCreate = [];

            foreach ($cleanList as $product) {
                $productId = $this->getProductId($product['produto']);

                if ($productId) {
                    $productsToUpdate[$productId['id']] = $product;
                } else {
                    $productsToCreate[] = $product;
                }
            }

            if (!empty($productsToUpdate)) {
                $this->updateProducts($productsToUpdate);
            }

            if (!empty($productsToCreate)) {
                $this->createProducts($productsToCreate);
            }

            $this->db->commit();
        } catch (PDOException $exception) {
            $this->db->rollBack();
            throw new Exception('Database connection error: ' . $exception->getMessage());
            return false;
        } catch (Exception $exception) {
            $this->db->rollBack();
            throw new Exception('Error: ' . $exception->getMessage());
            return false;
        }

        return true;

    }

    private function convertJsonToArray(string $products): array
    {
        return $this->jsonHelper->convertJsonToArray($products);
    }

    private function cleanProductList(string $products): array
    {
        $listProduct = $this->convertJsonToArray($products);
        $cleanList = [];

        foreach ($listProduct as $product) {
            $productId = $this->getProductId($product['produto']);

            if (!$productId || $this->shouldUpdateProduct($productId['data_disponibilidade'], $product['data_disponibilidade'])) {
                $cleanList[$product['produto']] = $product;
            }
        }

        return $cleanList;
    }

    private function getProductId(string $produto): ?array
    {
        return $this->productRespository->getProductId($produto);
    }

    private function shouldUpdateProduct(string $existingDate, string $newDate): bool
    {
        return $this->productRespository->shouldUpdateProduct($existingDate, $newDate);
    }

    private function updateProducts(array $productsToUpdate): void
    {
        $this->productRespository->updateProducts($productsToUpdate);
    }

    private function createProducts(array $productsToCreate): void
    {
        $this->productRespository->createProducts($productsToCreate);
    }

    /**
     * @return PDO
     */
    public function getDb(): PDO
    {
        return $this->db;
    }
}