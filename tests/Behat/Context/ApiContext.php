<?php

declare(strict_types=1);

namespace Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Tests\CreatesApplication;
use Exception;

/**
 * Behat context for managing API-related scenarios.
 *
 * This context provides step definitions for:
 * - Making API requests
 * - Verifying API responses
 *
 * It handles the interaction with the API endpoints
 * for acceptance testing purposes.
 */
final class ApiContext implements Context
{
    use CreatesApplication, MakesHttpRequests;

    private $response;
    private $app;

    public function __construct()
    {
        $this->app = $this->createApplication();
    }

    /**
     * @When I send a GET request to :url
     */
    public function iSendAGetRequestTo($path): void
    {
        $this->response = $this->json('GET', $path);
    }

    /**
     * @When I send a :method request to :url with body:
     */
    public function iSendARequestToWithBody(string $method, string $url, PyStringNode $body): void
    {
        $json = json_decode($body->getRaw(), true, 512, JSON_THROW_ON_ERROR);

        $this->response = $this->json(strtoupper($method), $url, $json);
    }

    /**
     * @Then the response status code should be :statusCode
     */
    public function theResponseStatusCodeShouldBe(int $statusCode): void
    {
        if ($this->response->getStatusCode() !== $statusCode) {
            throw new Exception(
                sprintf(
                    'Expected status code %d but got %d. Response: %s',
                    $statusCode,
                    $this->response->getStatusCode(),
                    $this->response->getContent()
                )
            );
        }
    }

    /**
     * @Then the JSON should be equal to:
     */
    public function theJsonShouldBeEqualTo(PyStringNode $expectedJson): void
    {
        $expected = json_decode($expectedJson->getRaw(), true, 512, JSON_THROW_ON_ERROR);
        $actual = $this->response->json();

        if ($expected !== $actual) {
            throw new \Exception(
                sprintf(
                    'Expected JSON %s but got %s',
                    json_encode($expected, JSON_PRETTY_PRINT),
                    json_encode($actual, JSON_PRETTY_PRINT)
                )
            );
        }
    }
}
