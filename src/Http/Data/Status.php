<?php declare(strict_types=1);

namespace Feather\Http\Data;

interface Status
{
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const NOT_ALLOWED_METHOD = 405;
    const OK = 200;
    const INTERNAL_SERVER_ERROR = 500;
}
