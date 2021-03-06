<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2019 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace OAuth2Framework\Component\Core\Message\Factory;

use function Safe\json_encode;
use Psr\Http\Message\ResponseInterface;

abstract class OAuth2ResponseFactory implements ResponseFactory
{
    public function createResponse(array $data, ResponseInterface $response): ResponseInterface
    {
        $response = $response->withStatus(
            $this->getSupportedCode()
        );
        $this->updateBody($data, $response);
        $headers = $this->getDefaultHeaders();

        return $this->updateHeaders($headers, $response);
    }

    public function updateBody(array $data, ResponseInterface $response): void
    {
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public function updateHeaders(array $headers, ResponseInterface $response): ResponseInterface
    {
        foreach ($headers as $header => $value) {
            $response = $response->withHeader($header, $value);
        }

        return $response;
    }

    protected function getDefaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json; charset=UTF-8',
            'Cache-Control' => 'no-store, private',
            'Pragma' => 'no-cache',
        ];
    }
}
