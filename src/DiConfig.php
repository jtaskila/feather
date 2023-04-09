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
            ContentType::JSON => '\Feather\Http\Content\Parsers\Json'
        ],
    ],
    \Feather\Database\Data\Credentials::class => [
        'host' => 'localhost',
        'database' => 'feather',
        'username' => 'root',
        'password' => ''
    ],
    \Feather\Console\Cli::class => [
        'commands' => [
            'version' => \Feather\Console\Commands\Version::class,
            'db:migrate' => \Feather\Console\Commands\DatabaseMigrate::class,
        ]
    ]
];
