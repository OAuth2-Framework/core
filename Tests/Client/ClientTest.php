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

namespace OAuth2Framework\Component\Core\Tests\Client;

use OAuth2Framework\Component\Core\Client\Client;
use OAuth2Framework\Component\Core\Client\ClientId;
use OAuth2Framework\Component\Core\DataBag\DataBag;
use OAuth2Framework\Component\Core\UserAccount\UserAccountId;
use PHPUnit\Framework\TestCase;

/**
 * @group ClientCredentials
 */
final class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function iCanCreateAClientId()
    {
        $clientId = new ClientId('CLIENT_ID');

        static::assertInstanceOf(ClientId::class, $clientId);
        static::assertEquals('CLIENT_ID', $clientId->getValue());
        static::assertEquals('"CLIENT_ID"', \json_encode($clientId, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    /**
     * @test
     */
    public function iCanCreateAClient()
    {
        $client = Client::createEmpty();
        $client = $client->create(
            new ClientId('CLIENT_ID'),
            new DataBag([
            ]),
            new UserAccountId('USER_ACCOUNT_ID')
        );
        $client = $client->withParameters(new DataBag([
            'token_endpoint_auth_method' => 'none',
        ]));
        $client = $client->withOwnerId(new UserAccountId('NEW_USER_ACCOUNT_ID'));
        $client = $client->markAsDeleted();

        static::assertInstanceOf(Client::class, $client);
        static::assertTrue($client->isPublic());
        static::assertTrue($client->isDeleted());
        static::assertEquals('{"$schema":"https://oauth2-framework.spomky-labs.com/schemas/model/client/1.0/schema","type":"OAuth2Framework\\\\Component\\\\Core\\\\Client\\\\Client","client_id":"CLIENT_ID","owner_id":"NEW_USER_ACCOUNT_ID","parameters":{"token_endpoint_auth_method":"none","client_id":"CLIENT_ID"},"is_deleted":true}', \json_encode($client, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
