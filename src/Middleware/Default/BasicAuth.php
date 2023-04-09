<?php declare(strict_types=1);

namespace Feather\Middleware\Default;

use Feather\Core\FeatherDi;
use Feather\Http\Data\Status;
use Feather\Http\Request;
use Feather\Http\Response;
use Feather\Http\ResponseFactory;
use Feather\Middleware\MiddlewareInterface;

class BasicAuth implements MiddlewareInterface
{
    private ResponseFactory $responseFactory;
    private string $realm = 'Basic auth';
    private ?string $user = null;
    private ?string $passwd = null;

    public function __construct(
        ResponseFactory $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    public function run(Request $request): ?Response
    {
        $user = $_SERVER['PHP_AUTH_USER'] ?? null;
        $passwd = $_SERVER['PHP_AUTH_PW'] ?? null;

        if (!$this->validateCredentials($user, $passwd)) {
            $response = $this->responseFactory->create(Status::UNAUTHORIZED);
            $response->addHeader('WWW-Authenticate', 'Basic realm="' . $this->realm . '"');
            $response->setBody(\json_encode([
                'error' => 'Unauthorized'
            ]));
            
            return $response;
        }

        return null;
    }   

    private function validateCredentials(?string $user, ?string $passwd): bool 
    {
        if (!$user || !$passwd) {
            return false;
        }

        if ($user === $this->user && $passwd === $this->passwd) {
            return true;
        }

        return false;
    }

    public function setRealm(string $realm): BasicAuth 
    {
        $this->realm = $realm;
        
        return $this;
    }

    public function setUser(string $user): BasicAuth 
    {
        $this->user = $user;

        return $this;
    }

    public function setPassword(string $passwd): BasicAuth 
    {
        $this->passwd = $passwd;
        
        return $this;
    }
}