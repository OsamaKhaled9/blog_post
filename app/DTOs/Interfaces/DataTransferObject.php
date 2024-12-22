<?php

namespace App\Contracts;

interface DataTransferObject
{
    public function jsonSerialize(): array;
}
