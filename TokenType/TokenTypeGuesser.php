<?php

declare(strict_types=1);

namespace OAuth2Framework\Component\Core\TokenType;

use OAuth2Framework\Component\AuthorizationEndpoint\AuthorizationRequest\AuthorizationRequest;

class TokenTypeGuesser
{
    public function __construct(
        private TokenTypeManager $tokenTypeManager,
        private bool $tokenTypeParameterAllowed
    ) {
    }

    public function find(AuthorizationRequest $authorization): TokenType
    {
        if (! $this->tokenTypeParameterAllowed || ! $authorization->hasQueryParam('token_type')) {
            return $this->tokenTypeManager->getDefault();
        }

        return $this->tokenTypeManager->get($authorization->getQueryParam('token_type'));
    }
}
