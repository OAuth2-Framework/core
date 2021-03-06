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

namespace OAuth2Framework\Component\Core\TokenType;

use OAuth2Framework\Component\Core\AccessToken\AccessToken;
use Psr\Http\Message\ServerRequestInterface;

interface TokenType
{
    /**
     * This function prepares token type additional information to be added to the token returned to the client.
     * A possible result for the MAC access token type:
     *  {
     *      "kid":"22BIjxU93h/IgwEb4zCRu5WF37s=",
     *      "mac_key":"adijq39jdlaska9asud",
     *      "mac_algorithm":"hmac-sha-256"
     *  }.
     */
    public function getAdditionalInformation(): array;

    /**
     * The name of the token type (e.g. Bearer, MAC, POP...).
     */
    public function name(): string;

    /**
     * The scheme of the token type.
     * This information is sent on authentication responses (HTTP code 401).
     */
    public function getScheme(): string;

    /**
     * This method tries to find a token in the request.
     * If needed, additional credentials values can be set.
     */
    public function find(ServerRequestInterface $request, array &$additionalCredentialValues): ?string;

    /**
     * This methods verifies the request is valid with the specified token.
     */
    public function isRequestValid(AccessToken $token, ServerRequestInterface $request, array $additionalCredentialValues): bool;
}
