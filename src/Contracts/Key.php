<?php

namespace Token\JWT\Contracts;

interface Key
{
    public function contents(): string;

    public function passphrase(): string;
}
