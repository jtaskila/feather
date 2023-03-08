<?php declare(strict_types=1);

namespace Feather\Middleware;

use Feather\Http\Request;
use Feather\Http\Response;

interface MiddlewareInterface
{
    public function run(Request $request): ?Response;
}