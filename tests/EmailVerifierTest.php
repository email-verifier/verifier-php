<?php

use PHPUnit\Framework\TestCase;
use EmailVerifier\EmailVerifier;
use InvalidArgumentException;

class EmailVerifierTest extends TestCase
{
    private EmailVerifier $verifier;

    protected function setUp(): void
    {
        $this->verifier = new EmailVerifier('test_token');
    }

    public function testConstructorThrowsExceptionOnEmptyToken()
    {
        $this->expectException(InvalidArgumentException::class);
        new EmailVerifier('');
    }

    public function testVerifyEmailThrowsExceptionOnInvalidEmail()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->verifier->verifyEmail('invalid-email');
    }

    public function testVerifyEmailWithValidEmail()
    {
        // Spy on the EmailVerifier class
        $spy = $this->getMockBuilder(EmailVerifier::class)
            ->setConstructorArgs(['test_token'])
            ->onlyMethods(['makeRequest'])
            ->getMock();

        // Mock makeRequest to return a valid response
        $spy->method('makeRequest')
            ->willReturn(['status' => 'valid']);

        // Call the verifyEmail method and assert
        $result = $spy->verifyEmail('test@example.com');
        $this->assertSame('valid', $result);
    }

    public function testVerifyEmailWithDetails()
    {
        // Spy on the EmailVerifier class
        $spy = $this->getMockBuilder(EmailVerifier::class)
            ->setConstructorArgs(['test_token'])
            ->onlyMethods(['makeRequest'])
            ->getMock();

        $expectedResponse = [
            'status' => 'valid',
            'domain' => 'example.com',
            'is_disposable' => false,
            'is_role_account' => false
        ];

        // Mock makeRequest to return the detailed response
        $spy->method('makeRequest')
            ->willReturn($expectedResponse);

        // Call the verifyEmail method with details flag
        $result = $spy->verifyEmail('test@example.com', true);
        $this->assertEquals($expectedResponse, $result);
    }
}
