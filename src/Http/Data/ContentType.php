<?php declare(strict_types=1);

namespace Feather\Http\Data;

interface ContentType
{
    const MULTIPART = 'multipart/form-data';
    const FORM  = 'application/x-www-form-urlencoded';
    const JSON  = 'application/json';
    const XML   = 'application/xml';
    const PDF   = 'application/pdf';
    const PLAIN = 'text/plain';
    const HTML  = 'text/html';
}
