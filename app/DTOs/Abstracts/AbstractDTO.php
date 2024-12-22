<?php

namespace App\Abstracts;

use App\Contracts\DataTransferObject;

abstract class AbstractDTO implements DataTransferObject
{
    public function jsonSerialize(): array
    {
        return [];
    }
}
