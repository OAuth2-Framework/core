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

namespace OAuth2Framework\Component\Core\Message\Factory;

use OAuth2Framework\Component\ClientAuthentication\AuthenticationMethodManager;
use Psr\Http\Message\ResponseInterface;

final class AuthenticateResponseForClientFactory extends OAuth2ResponseFactory
{
    /**
     * @var AuthenticationMethodManager
     */
    private $authenticationMethodManager;

    /**
     * AuthenticateResponseForClientFactory constructor.
     *
     * @param AuthenticationMethodManager $authenticationMethodManager
     */
    public function __construct(AuthenticationMethodManager $authenticationMethodManager)
    {
        $this->authenticationMethodManager = $authenticationMethodManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedCode(): int
    {
        return 401;
    }

    /**
     * {@inheritdoc}
     */
    public function createResponse(array $data, ResponseInterface $response): ResponseInterface
    {
        $response = $response->withStatus(
            $this->getSupportedCode()
        );

        $schemes = $this->authenticationMethodManager->getSchemes($data);
        $headers = [
            'Cache-Control' => 'no-store, private',
            'Pragma' => 'no-cache',
            'WWW-Authenticate' => $schemes,
        ];
        $response = $this->updateHeaders($headers, $response);

        return $response;
    }
}
