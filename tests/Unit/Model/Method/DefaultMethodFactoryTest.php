<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Tests\Unit\Model\Method;

use Inspirum\Balikobot\Model\Method\DefaultMethod;
use Inspirum\Balikobot\Model\Method\DefaultMethodCollection;
use Inspirum\Balikobot\Model\Method\DefaultMethodFactory;
use Inspirum\Balikobot\Tests\Unit\BaseTestCase;
use Throwable;
use function get_class;

final class DefaultMethodFactoryTest extends BaseTestCase
{
    /**
     * @param array<string,mixed>                                          $data
     * @param \Inspirum\Balikobot\Model\Method\MethodCollection|\Throwable $result
     *
     * @dataProvider providesTestCreateCollection
     */
    public function testCreateCollection(array $data, $result): void
    {
        if ($result instanceof Throwable) {
            $this->expectException(get_class($result));
            $this->expectExceptionMessage($result->getMessage());
        }

        $factory = $this->newDefaultMethodFactory();

        $collection = $factory->createCollection($data);

        self::assertEquals($result, $collection);
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public function providesTestCreateCollection(): iterable
    {
        yield 'valid' => [
            'data'    => [
                [
                    'method'   => 'ADD',
                    'endpoint' => 'https://api.balikobot.cz/zasilkovna/add',
                ],
                [
                    'method'   => 'TRACKSTATUS',
                    'endpoint' => 'https://api.balikobot.cz/zasilkovna/trackstatus',
                ],
            ],
            'result'  =>  new DefaultMethodCollection([
                new DefaultMethod('ADD'),
                new DefaultMethod('TRACKSTATUS'),
            ]),
        ];
    }

    private function newDefaultMethodFactory(): DefaultMethodFactory
    {
        return new DefaultMethodFactory();
    }
}
