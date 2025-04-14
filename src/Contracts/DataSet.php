<?php

namespace Token\JWT\Contracts;

interface DataSet
{
    public function get(string $name, mixed $default = null): mixed;

    public function has(string $name): bool;

    public function all(): array;

    public function toString(): string;
}
