<?php declare(strict_types=1);

namespace Feather\Http\Data;

interface Method
{
    const GET     = 'GET';
    const POST    = 'POST';
    const PUT     = 'PUT';
    const DELETE  = 'DELETE';
    const OPTIONS = 'OPTIONS';
    const HEAD    = 'HEAD';
    const CONNECT = 'CONNECT';
    const TRACE   = 'TRACE';
    const PATCH   = 'PATCH';
}
