<?php

namespace tests\unit\services;

use yii\web\Request;
use api\modules\api\v1\services\OAuth;
use api\modules\api\v1\models\GrantType;
use api\modules\api\v1\models\AccessToken;
use api\modules\api\v1\models\factories\GrantTypeFactory;
use api\modules\api\v1\models\repository\ScopeRepository;
use api\modules\api\v1\models\strategies\ClientCredentialStrategy;
use api\modules\api\v1\models\strategies\PasswordStrategy;

class OAuthTest extends \PHPUnit_Framework_TestCase
{
    /** @var  OAuth */
    protected $service;

    /** @var  Request | \PHPUnit_Framework_MockObject_MockObject */
    protected $requestMock;

    /** @var  GrantTypeFactory | \PHPUnit_Framework_MockObject_MockObject */
    protected $factoryMock;

    /** @var  AccessToken | \PHPUnit_Framework_MockObject_MockObject */
    protected $accessTokenMock;

    /** @var  ClientCredentialStrategy | \PHPUnit_Framework_MockObject_MockObject */
    protected $clientCredentialStrategyMock;

    /** @var  PasswordStrategy | \PHPUnit_Framework_MockObject_MockObject */
    protected $passwordStrategyMock;

    /** @var  ScopeRepository | \PHPUnit_Framework_MockObject_MockObject */
    protected $scopesRepositoryMock;

    public function setUp()
    {
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(GrantTypeFactory::class)
            ->getMock();

        $this->accessTokenMock = $this->getMockBuilder(AccessToken::class)
            ->getMock();

        $this->clientCredentialStrategyMock = $this->getMockBuilder(ClientCredentialStrategy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->passwordStrategyMock = $this->getMockBuilder(PasswordStrategy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->scopesRepositoryMock = $this->getMockBuilder(ScopeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new OAuth();
    }

    public function testCreateClientCredentialsToken()
    {
        $this->requestMock->expects($this->at(1))
            ->method('getBodyParam')
            ->with('grant_type', null)
            ->willReturn(GrantType::CLIENT_CREDENTIALS);

        $this->scopesRepositoryMock->expects($this->once())
            ->method('findAllowed')
            ->willReturn($this->isType('object'));

        $this->scopesRepositoryMock->expects($this->once())
            ->method('collect')
            ->with($this->isType('object'))
            ->willReturn([]);

        $this->factoryMock->expects($this->once())
            ->method('getClientCredentials')
            ->willReturn($this->clientCredentialStrategyMock);

        $this->clientCredentialStrategyMock->expects($this->once())
            ->method('generate')
            ->willReturn($this->accessTokenMock);

        $result = $this->service->createAccessToken(
            $this->requestMock,
            $this->factoryMock,
            $this->scopesRepositoryMock
        );

        $this->assertInstanceOf(AccessToken::class, $result);
    }

    public function testCreatePasswordToken()
    {
        $this->requestMock->expects($this->at(1))
            ->method('getBodyParam')
            ->with('grant_type', null)
            ->willReturn(GrantType::PASSWORD);

        $this->scopesRepositoryMock->expects($this->once())
            ->method('findAllowed')
            ->willReturn($this->isType('object'));

        $this->scopesRepositoryMock->expects($this->once())
            ->method('collect')
            ->with($this->isType('object'))
            ->willReturn([]);

        $this->factoryMock->expects($this->once())
            ->method('getPassword')
            ->willReturn($this->passwordStrategyMock);

        $this->passwordStrategyMock->expects($this->once())
            ->method('generate')
            ->willReturn($this->accessTokenMock);

        $result = $this->service->createAccessToken(
            $this->requestMock,
            $this->factoryMock,
            $this->scopesRepositoryMock
        );

        $this->assertInstanceOf(AccessToken::class, $result);
    }

    /**
     * @expectedException \yii\base\Exception
     */
    public function testCreateAccessTokenWithWrongGrant()
    {
        $this->requestMock->expects($this->at(1))
            ->method('getBodyParam')
            ->with('grant_type', null)
            ->willReturn('');

        $this->service->createAccessToken(
            $this->requestMock,
            $this->factoryMock,
            $this->scopesRepositoryMock
        );
    }

}
