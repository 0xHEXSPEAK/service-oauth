<?php

namespace tests\unit\moidels\strategies;

use api\modules\api\v1\models\AccessToken;
use api\modules\api\v1\models\repository\AccessTokenRepository;
use api\modules\api\v1\models\repository\UserRepository;
use api\modules\api\v1\models\strategies\PasswordStrategy;
use api\modules\api\v1\models\User;
use yii\web\Request;

class PasswordStrategyTest extends \PHPUnit_Framework_TestCase
{
    /** @var PasswordStrategy */
    protected $strategy;

    /** @var  Request | \PHPUnit_Framework_MockObject_MockObject */
    protected $requestMock;

    /** @var  UserRepository | \PHPUnit_Framework_MockObject_MockObject */
    protected $userRepositoryMock;

    /** @var  AccessTokenRepository | \PHPUnit_Framework_MockObject_MockObject */
    protected $accessTokenRepositoryMock;

    /** @var  User | \PHPUnit_Framework_MockObject_MockObject */
    protected $userModelMock;

    /** @var  AccessToken | \PHPUnit_Framework_MockObject_MockObject */
    protected $accessTokenMock;

    public function setUp()
    {
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->getMock();

        $this->accessTokenRepositoryMock = $this->getMockBuilder(AccessTokenRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userRepositoryMock = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userModelMock = $this->getMockBuilder(User::class)
            ->getMock();

        $this->accessTokenMock = $this->getMockBuilder(AccessToken::class)
            ->getMock();

        $this->strategy = new PasswordStrategy(
            $this->requestMock,
            $this->accessTokenRepositoryMock,
            $this->userRepositoryMock
        );
    }

    /**
     * @expectedException \api\modules\api\v1\exceptions\UserNotFound
     */
    public function testGenerateWithInvalidCredentials()
    {
        $this->userRepositoryMock->expects($this->once())
            ->method('findByUserCredentials')
            ->willReturn(null);

        $this->strategy->generate();
    }

    public function testGenerateWithValidCredentials()
    {
        $this->requestMock->expects($this->at(0))
            ->method('getBodyParam')
            ->with('username', null)
            ->willReturn('user');

        $this->requestMock->expects($this->at(1))
            ->method('getBodyParam')
            ->with('password', null)
            ->willReturn('pass');

        $this->userModelMock->expects($this->once())
            ->method('__get')
            ->will($this->returnValueMap([
                ['id', 123]
            ]));

        $this->userRepositoryMock->expects($this->once())
            ->method('findByUserCredentials')
            ->with('user', 'pass')
            ->willReturn($this->userModelMock);

        $this->accessTokenRepositoryMock->expects($this->once())
            ->method('generate')
            ->with(null, 123, ['whole_world'], 'password')
            ->willReturn($this->accessTokenMock);

        $result = $this->strategy->generate();
        $this->assertInstanceOf(AccessToken::class, $result);
    }
}