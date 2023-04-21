<?php declare(strict_types=1);

namespace Feather\Api\Exceptions;

/**
 * Exception which indicates that the request was bad
 * 
 * HTTP 400 will be returned by default
 */
class ApiInputException extends ApiException
{

}