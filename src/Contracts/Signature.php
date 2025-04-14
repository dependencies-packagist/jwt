<?php

namespace Token\JWT\Contracts;

interface Signature
{
    public function hash(): string;
}
