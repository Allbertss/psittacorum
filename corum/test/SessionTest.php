<?php

namespace allbertss\psittacorum\test;

use allbertss\psittacorum\session\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    protected function setUp(): void
    {
        unset($_SESSION);
    }

    public function test_set_and_get_flash(): void
    {
        $session = new Session();

        $session->setFlash('success', 'Success message');
        $session->setFlash('error', 'Error message');

        $this->assertTrue($session->hasFlash('success'));
        $this->assertTrue($session->hasFlash('error'));

        $this->assertEquals(['Success message'], $session->getFlash('success'));
        $this->assertEquals(['Error message'], $session->getFlash('error'));

        $this->assertEquals([], $session->getFlash('warning'));
    }
}