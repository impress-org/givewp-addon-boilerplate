<?php

namespace GiveAddon\Tests\Unit\Domain;

use Exception;
use Give\Tests\TestCase;
use Give\Tests\TestTraits\RefreshDatabase;
use WPDieException;

class TestSamples extends TestCase
{
    use RefreshDatabase;

    /**
     * @unreleased
     *
     * @throws Exception
     */
    public function testExpectException()
    {
        $this->expectException(WPDieException::class);

        wp_die();
    }

    /**
     * @unreleased
     */
    public function testAssertTrue()
    {
        $this->assertTrue(true);
    }

    /**
     * @unreleased
     */
    public function testAssertEquals()
    {
        $this->assertEquals(true, true);
    }
}
