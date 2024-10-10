<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Exception;
use PHPUnit\Framework\Assert;

final class AppContext extends MinkContext implements Context
{
    /**
     * @Then the response should be a valid JSON
     * @throws Exception
     */
    public function theResponseShouldBeAJson(): void
    {
        $this->decodeJsonFromResponse();
    }

    /**
     * @Then the JSON response should contain :suggestion
     * @throws Exception
     */
    public function theJsonResponseShouldContain(string $suggestion): void
    {
        $json = $this->decodeJsonFromResponse();

        Assert::assertContains(
            $suggestion,
            $json,
            sprintf('Response JSON does not contain the suggestion "%s"', $suggestion)
        );
    }

    /**
     * @throws Exception
     */
    private function decodeJsonFromResponse(): array
    {
        $response = $this->getSession()->getPage()->getContent();
        $json = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Response is not a valid JSON: ' . json_last_error_msg());
        }

        return $json;
    }

    /**
     * @Given /^the JSON response should have the following keys:$/
     * @throws Exception
     */
    public function theJSONResponseShouldHaveKeys(TableNode $table): void
    {
        $keys = $table->getColumn(0);
        $json = $this->decodeJsonFromResponse();

        foreach ($keys as $key) {
            Assert::assertArrayHasKey(
                $key,
                $json,
                sprintf('Response JSON does not contain the key "%s"', $key)
            );
        }
    }
}