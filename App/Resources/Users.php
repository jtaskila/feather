<?php declare(strict_types=1);

namespace App\Resources;

use Feather\Api\Exceptions\ApiInputException;
use Feather\Http\Request;
use Feather\Http\Response;
use Feather\Http\ResponseFactory;
use Feather\Resources\Resource;

class Users extends Resource
{
    private ResponseFactory $responseFactory;
    private Request $request;

    public function __construct(
        ResponseFactory $responseFactory,
        Request $request 
    ) {
        parent::__construct($responseFactory);
        $this->responseFactory = $responseFactory;  
        $this->request = $request;
    }

    public function get(): Response
    {
        $userId = (int)$this->request->getParam('id');

        if (!$userId) {
            throw new ApiInputException('User ID is missing');
        }

        $user = $this->userRepository->get($userId);

        $response = $this->responseFactory->create();
        $response->setItem($user);

        return $response;
    }

    public function post(): Response 
    {
        $data = $this->io->use(UserInput::class, $request->getData());

        if (!$data->validate()) {
            throw new ApiInputException("Bad request");
        }

        try {
            $user = new User();
            $user->populate($data->getData());
            $id = $this->userRepository->save($user);
        } catch (\Exception) {
            throw new ApiUnableToSaveException("Entity could not be saved");
        }

        $response = $this->responseFactory->create(203);
        $response->setData('user_id' => $id);

        return $response;
    }
}