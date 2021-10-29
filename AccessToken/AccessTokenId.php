<?php

declare(strict_types=1);

namespace OAuth2Framework\Component\Core\AccessToken;

use Stringable;

class AccessTokenId implements Stringable
{
    public function __construct(
        private string $value
    ) {
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
