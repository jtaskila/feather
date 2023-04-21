<?php declare(strict_types=1);

namespace Feather\Api\Exceptions;

/**
 * All exceptions based on ApiException are considered "user" safe. 
 * 
 * A specific response is returned if an ApiException is thrown.
 */
class ApiException extends \Exception
{

}