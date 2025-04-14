<?php

namespace Token\JWT\Exceptions;

use RuntimeException;
use Token\JWT\Contracts\JSONWebTokenException;

final class ConstraintViolationException extends RuntimeException implements JSONWebTokenException
{
}
