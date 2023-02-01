<?php

namespace App\Exception;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class Error404 extends Exception implements JsonSerializable
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    #[ArrayShape(['status' => "int", 'error' => "string", 'message' => "string"])]
    public function jsonSerialize(): array
    {
        return array(
            'status' => 404,
            'error' => "Not Found",
            'message' => $this->getMessage()
        );
    }
}