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

namespace OAuth2Framework\Component\Core\Client\Event;

use OAuth2Framework\Component\Core\Client\ClientId;
use OAuth2Framework\Component\Core\Domain\DomainObject;
use OAuth2Framework\Component\Core\Event\Event;
use OAuth2Framework\Component\Core\Id\Id;
use OAuth2Framework\Component\Core\UserAccount\UserAccountId;

class ClientOwnerChangedEvent extends Event
{
    /**
     * @var ClientId
     */
    private $clientId;

    /**
     * @var UserAccountId
     */
    private $newOwnerId;

    /**
     * ClientOwnerChangedEvent constructor.
     */
    protected function __construct(ClientId $clientId, UserAccountId $newOwnerId)
    {
        $this->clientId = $clientId;
        $this->newOwnerId = $newOwnerId;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSchema(): string
    {
        return 'https://oauth2-framework.spomky-labs.com/schemas/events/client/owner-changed/1.0/schema';
    }

    /**
     * @return ClientOwnerChangedEvent
     */
    public static function create(ClientId $clientId, UserAccountId $newOwnerId): self
    {
        return new self($clientId, $newOwnerId);
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromJson(\stdClass $json): DomainObject
    {
        $clientId = new ClientId($json->domain_id);
        $userAccountId = null === $json->payload->new_owner_id ? null : new UserAccountId($json->payload->new_owner_id);

        return new self(
            $clientId,
            $userAccountId
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDomainId(): Id
    {
        return $this->getClientId();
    }

    public function getClientId(): ClientId
    {
        return $this->clientId;
    }

    public function getNewOwnerId(): UserAccountId
    {
        return $this->newOwnerId;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayload()
    {
        return (object) [
            'new_owner_id' => $this->newOwnerId->getValue(),
        ];
    }
}
