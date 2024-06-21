<?php

namespace App\DataTransferObjects;

interface DataTransferObject
{
    public static function fromArray(array $data): static;

    public function toArray(): array;
}
