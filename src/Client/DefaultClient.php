<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Client;

use GuzzleHttp\Psr7\InflateStream;
use Inspirum\Balikobot\Client\Request\CarrierType;
use Inspirum\Balikobot\Client\Request\Method;
use Inspirum\Balikobot\Client\Request\Version;
use Inspirum\Balikobot\Client\Response\Validator;
use Inspirum\Balikobot\Exception\BadRequestException;
use JsonException;
use Psr\Http\Message\StreamInterface;
use Throwable;
use function json_decode;
use function sprintf;
use function str_replace;
use function trim;
use const JSON_THROW_ON_ERROR;

final class DefaultClient implements Client
{
    public function __construct(
        private Requester $requester,
        private Validator $validator,
    ) {
    }

    /** @inheritDoc */
    public function call(
        Version $version,
        ?CarrierType $carrier,
        Method $request,
        array $data = [],
        string $path = '',
        bool $shouldHaveStatus = true,
        bool $gzip = false,
    ): array {
        $url = $this->resolveUrl($version->getValue(), $carrier?->getValue(), $request->getValue(), $path, $gzip);

        $response = $this->requester->request($url, $data);

        $statusCode    = $response->getStatusCode();
        $contents      = $this->getContents($response->getBody(), $gzip);
        $parsedContent = $this->parseContents($contents, $statusCode < 300);

        $this->validateResponse($statusCode, $parsedContent, $shouldHaveStatus);

        return $parsedContent;
    }

    private function resolveUrl(string $version, ?string $carrier, string $request, string $path, bool $gzip): string
    {
        $url = sprintf('%s/%s/%s', $carrier, $request, $path);
        $url = trim(str_replace('//', '/', $url), '/');

        if ($gzip) {
            $url = sprintf('%s?gzip=1', $url);
        }

        return sprintf('%s/%s', $version, $url);
    }

    /**
     * @return array<string,mixed>
     *
     * @throws \Inspirum\Balikobot\Exception\Exception
     */
    private function parseContents(string $content, bool $throwOnError): array
    {
        try {
            return json_decode($content, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            if ($throwOnError) {
                throw new BadRequestException([], 400, $exception, 'Cannot parse response data');
            }

            return [];
        }
    }

    private function getContents(StreamInterface $stream, bool $gzip): string
    {
        if ($gzip === false) {
            return $stream->getContents();
        }

        try {
            $inflateStream = new InflateStream($stream);

            return $inflateStream->getContents();
        } catch (Throwable) {
            $stream->rewind();

            return $stream->getContents();
        }
    }

    /**
     * @param array<string,mixed> $response
     *
     * @throws \Inspirum\Balikobot\Exception\Exception
     */
    private function validateResponse(int $statusCode, array $response, bool $shouldHaveStatus): void
    {
        $this->validator->validateStatus($statusCode, $response);

        $this->validator->validateResponseStatus($response, null, $shouldHaveStatus);
    }
}
