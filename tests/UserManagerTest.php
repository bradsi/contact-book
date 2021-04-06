<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Bradsi\Models\UserManager;

class UserManagerTest extends TestCase {
    private UserManager $um;

    protected function setUp(): void {
        $this->um = new UserManager();
    }

    public function testLoginWithoutEmail() {
        $email = null;
        $pwd = "dafdkjfhaklgef";
        $result = $this->um->loginUser($email, $pwd);

        $this->assertEquals('Please fill out the form completely.', $result);
    }

    public function testLoginWithoutPassword() {
        $email = "email@example.com";
        $pwd = null;
        $result = $this->um->loginUser($email, $pwd);

        $this->assertEquals('Please fill out the form completely.', $result);
    }

    public function testLoginWithInvalidEmail() {
        $email = "user";
        $pwd = "dafdkjfhaklgef";
        $result = $this->um->loginUser($email, $pwd);

        $this->assertEquals('Email provided is invalid.', $result);
    }

    public function testLoginWithWrongEmail() {
        $email = "demo@demo.com";
        $pwd = "dafdkjfhaklgef";
        $result = $this->um->loginUser($email, $pwd);

        $this->assertEquals('No account linked to the email provided.', $result);
    }

    public function testLoginWithIncorrectPassword() {
        $email = "demo@example.com";
        $pwd = "dafdkjfhaklgef";
        $result = $this->um->loginUser($email, $pwd);

        $this->assertEquals('Password incorrect.', $result);
    }

}