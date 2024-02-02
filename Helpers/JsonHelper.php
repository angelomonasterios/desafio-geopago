<?php

namespace Helpers;

use InvalidArgumentException;

class JsonHelper
{

    public function convertJsonToArray(string $products): array
    {
        $decoded = json_decode($products, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Unable to decode JSON: ' . json_last_error_msg());
        }

        return $decoded;
    }
}