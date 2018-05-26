<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace OAuth2Framework\Component\Core\Util;

use Psr\Http\Message\ServerRequestInterface;
use League\Uri\QueryParser;

class RequestBodyParser
{
    public static function parseJson(ServerRequestInterface $request): array
    {
        if (!$request->hasHeader('Content-Type') || !in_array('application/json', $request->getHeader('Content-Type'))) {
            throw new \InvalidArgumentException('Unsupported request body content type.');
        }
        if (is_array($request->getParsedBody()) && !empty($request->getParsedBody())) {
            return $request->getParsedBody();
        }

        $body = $request->getBody()->getContents();
        $json = json_decode($body, true);

        if (!is_array($json)) {
            throw new \InvalidArgumentException('Invalid body');
        }

        return $json;
    }

    public static function parseFormUrlEncoded(ServerRequestInterface $request): array
    {
        if (!$request->hasHeader('Content-Type') || !in_array('application/x-www-form-urlencoded', $request->getHeader('Content-Type'))) {
            throw new \InvalidArgumentException('Unsupported request body content type.');
        }
        if (is_array($request->getParsedBody()) && !empty($request->getParsedBody())) {
            return $request->getParsedBody();
        }

        $body = $request->getBody()->getContents();

        return (new QueryParser())->parse($body, '&', QueryParser::RFC1738_ENCODING);
    }
}