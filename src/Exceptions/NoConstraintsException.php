<?php

namespace Token\JWT\Exceptions;

use RuntimeException;
use Token\JWT\Contracts\JSONWebTokenException;

final class NoConstraintsException extends RuntimeException implements JSONWebTokenException
{
}
