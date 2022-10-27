<?php 
/**
 * This file is the Feather's main Dependency injection configuration
 * It is applied when the container is initialized. Configurations 
 * applied after initialization may overwrite this.
 */

use Feather\Http\Data\ContentType;

return [
    \Feather\Api::class => [
        'version' => '0.0.1',
    ],
    \Feather\Http\Content\Parser::class => [
        'parsers' => [
            ContentType::JSON => '\Feather\Http\Content\Parsers\Json',
            ContentType::FORM => '\Feather\Http\Content\Parsers\Form',
            ContentType::MULTIPART => '\Feather\Http\Content\Parsers\Multipart',
        ],
    ],    
];
