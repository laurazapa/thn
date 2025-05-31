<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Infrastructure\Service\UuidGenerator;

use Src\Shared\Common\Infrastructure\Service\UuidGenerator\LaravelUuidGenerator;
use Tests\TestCase;

/**
 * Test suite for the LaravelUuidGenerator.
 * 
 * This test suite verifies the behavior of the LaravelUuidGenerator when:
 * - Generating valid UUIDs
 * - Ensuring UUID format compliance
 * - Generating unique UUIDs across multiple calls
 */
class LaravelUuidGeneratorTest extends TestCase
{
    private LaravelUuidGenerator $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new LaravelUuidGenerator();
    }

    public function test_when_generate_is_called_then_returns_valid_uuid(): void
    {
        $uuid = $this->sut->generate();

        self::assertIsString($uuid);
        self::assertEquals(36, strlen($uuid));
        self::assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $uuid
        );
    }

    public function test_when_generate_is_called_multiple_times_then_returns_different_uuids(): void
    {
        $uuid1 = $this->sut->generate();
        $uuid2 = $this->sut->generate();
        $uuid3 = $this->sut->generate();

        self::assertNotEquals($uuid1, $uuid2);
        self::assertNotEquals($uuid2, $uuid3);
        self::assertNotEquals($uuid1, $uuid3);
    }
} 