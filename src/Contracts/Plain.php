<?php

namespace Token\JWT\Contracts;

interface Plain extends Token
{
    public function claims(): DataSet;

    public function signature(): Signature;

    public function payload(): string;
}
