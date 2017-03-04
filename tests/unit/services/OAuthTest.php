<?php

namespace tests\unit\services;

use api\modules\api\v1\models\AccessToken;
use api\modules\api\v1\models\factories\GrantTypeFactory;
use api\modules\api\v1\models\GrantType;
use api\modules\api\v1\models\strategies\ClientCredentialStrategy;
use \api\modules\api\v1\services\OAuth;
use yii\web\Request;

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

        $this->service = new OAuth();
    }

    public function testCreateAcessToken()
    {
        $this->requestMock->expects($this->once())
            ->method('getBodyParam')
            ->with('grant_type', null)
            ->willReturn(GrantType::CLIENT_CREDENTIALS);

        $this->factoryMock->expects($this->once())
            ->method('getClientCredentials')
            ->willReturn($this->clientCredentialStrategyMock);

        $this->clientCredentialStrategyMock->expects($this->once())
            ->method('generate')
            ->willReturn($this->accessTokenMock);

        $result = $this->service->createAccessToken($this->requestMock, $this->factoryMock);

        $this->assertInstanceOf(AccessToken::class, $result);
    }

    /**
     * @expectedException \yii\base\Exception
     */
    public function testCreateAcessTokenWithWrongGrant()
    {
        $this->requestMock->expects($this->once())
            ->method('getBodyParam')
            ->with('grant_type', null)
            ->willReturn('');

        $this->service->createAccessToken($this->requestMock, $this->factoryMock);
    }

}
