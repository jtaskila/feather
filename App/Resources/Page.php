<?php declare(strict_types=1);

namespace App\Resources;

use Feather\Http\Data\ContentType;
use Feather\Http\Response;
use Feather\Http\ResponseFactory;
use Feather\Resources\Resource;
use Feather\Templates\Template;

class Page extends Resource
{
    private Template $template;

    public function __construct(
        ResponseFactory $responseFactory,
        Template $template
    ) {
        $this->template = $template;
        parent::__construct($responseFactory);
    }

    public function get(): Response
    {
        $response = $this->responseFactory->create();
        $response->setContentType(ContentType::HTML);
        $response->setBody($this->template->toHtml());

        return $response;
    }
}