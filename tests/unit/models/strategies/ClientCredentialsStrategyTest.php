<?php

namespace tests\unit\moidels\strategies;

use api\modules\api\v1\models\AccessToken;
use api\modules\api\v1\models\ClientCredentials;
use api\modules\api\v1\models\GrantType;
use api\modules\api\v1\models\repository\AccessTokenRepository;
use api\modules\api\v1\models\repository\ClientCredentialsRepository;
use api\modules\api\v1\models\strategies\ClientCredentialStrategy;
use yii\web\Request;

class ClientCredentialsStrategy extends \PHPUnit_Framework_TestCase
{
    /** @var ClientCredentialStrategy */
    protected $strategy;

    /** @var  Request | \PHPUnit_Framework_MockObject_MockObject */
    protected $requestMock;

    /** @var  ClientCredentialsRepository | \PHPUnit_Framework_MockObject_MockObject */
    protected $clientCredentialsRepositoryMock;

    /** @var  AccessTokenRepository | \PHPUnit_Framework_MockObject_MockObject */
    protected $accessTokenRepositoryMock;

    /** @var  ClientCredentials | \PHPUnit_Framework_MockObject_MockObject */
    protected $clientCredentialsModelMock;

    /** @var  AccessToken | \PHPUnit_Framework_MockObject_MockObject */
    protected $accessTokenMock;

    public function setUp()
    {
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->getMock();

        $this->accessTokenRepositoryMock = $this->getMockBuilder(AccessTokenRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientCredentialsRepositoryMock = $this->getMockBuilder(ClientCredentialsRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientCredentialsModelMock = $this->getMockBuilder(ClientCredentials::class)
            ->getMock();

        $this->accessTokenMock = $this->getMockBuilder(AccessToken::class)
            ->getMock();

        $this->strategy = new ClientCredentialStrategy(
            $this->requestMock,
            $this->accessTokenRepositoryMock,
            $this->clientCredentialsRepositoryMock
        );
    }

    /**
     * @expectedException \api\modules\api\v1\exceptions\ClientNotFound
     */
    public function testGenerateWithInvalidCredentials()
    {
        $this->clientCredentialsRepositoryMock->expects($this->once())
            ->method('findByClientCredentials')
            ->willReturn(null);

        $this->strategy->generate();
    }

    public function testGenerateWithValidCredentials()
    {
        $this->requestMock->expects($this->at(0))
            ->method('getBodyParam')
            ->with('client_id', null)
            ->willReturn('client');

        $this->requestMock->expects($this->at(1))
            ->method('getBodyParam')
            ->with('client_secret', null)
            ->willReturn('secret');

        $this->clientCredentialsModelMock->expects($this->once())
            ->method('__get')
            ->will($this->returnValueMap([
                ['id', 123]
            ]));

        $this->clientCredentialsRepositoryMock->expects($this->once())
            ->method('findByClientCredentials')
            ->with('client', 'secret')
            ->willReturn($this->clientCredentialsModelMock);

        $this->accessTokenRepositoryMock->expects($this->once())
            ->method('generate')
            ->with(123, null, ['whole_world'], GrantType::CLIENT_CREDENTIALS)
            ->willReturn($this->accessTokenMock);

        $result = $this->strategy->generate();
        $this->assertInstanceOf(AccessToken::class, $result);
    }
}