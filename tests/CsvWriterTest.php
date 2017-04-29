<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests;

use ArrayAccess;
use League\Csv\Writer;
use League\Flysystem\FilesystemInterface;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use WideFocus\Feed\CsvWriter\CsvWriter;
use WideFocus\Feed\Writer\WriterFieldInterface;

/**
 * @coversDefaultClass \WideFocus\Feed\CsvWriter\CsvWriter
 */
class CsvWriterTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(
            CsvWriter::class,
            new CsvWriter(
                $this->createMock(Writer::class),
                $this->createMock(FilesystemInterface::class),
                'test.csv',
                true
            )
        );
    }

    /**
     * @param bool $includeHeaders
     *
     * @return void
     *
     * @dataProvider includeHeadersDataProvider
     *
     * @covers ::initialize
     */
    public function testInitialize(bool $includeHeaders)
    {
        $fields = [
            $this->createConfiguredMock(
                WriterFieldInterface::class,
                ['getLabel' => 'Foo']
            ),
            $this->createConfiguredMock(
                WriterFieldInterface::class,
                ['getLabel' => 'Bar']
            )
        ];

        $backend = $this->createMock(Writer::class);
        if ($includeHeaders) {
            $backend->expects($this->once())
                ->method('insertOne')
                ->with(['Foo', 'Bar']);
        } else {
            $backend->expects($this->never())
                ->method('insertOne');
        }

        $writer = new CsvWriter(
            $backend,
            $this->createMock(FilesystemInterface::class),
            'test.csv',
            $includeHeaders,
            ...$fields
        );

        $method = new ReflectionMethod(CsvWriter::class, 'initialize');
        $method->setAccessible(true);
        $method->invoke($writer);
    }

    /**
     * @return array
     */
    public function includeHeadersDataProvider(): array
    {
        return [
            [true],
            [false]
        ];
    }

    /**
     * @return void
     *
     * @dataProvider includeHeadersDataProvider
     *
     * @covers ::writeItem
     */
    public function testWriteItem()
    {
        $fields = [
            $this->createConfiguredMock(
                WriterFieldInterface::class,
                ['getValue' => 'FooValue']
            ),
            $this->createConfiguredMock(
                WriterFieldInterface::class,
                ['getValue' => 'BarValue']
            )
        ];

        $backend = $this->createMock(Writer::class);
        $backend->expects($this->once())
            ->method('insertOne')
            ->with(['FooValue', 'BarValue']);

        $writer = new CsvWriter(
            $backend,
            $this->createMock(FilesystemInterface::class),
            'test.csv',
            true,
            ...$fields
        );

        $method = new ReflectionMethod(CsvWriter::class, 'writeItem');
        $method->setAccessible(true);
        $method->invoke($writer, $this->createMock(ArrayAccess::class));
    }

    /**
     * @return void
     *
     * @covers ::finish
     */
    public function testFinish()
    {
        $backend = $this->createMock(Writer::class);
        $backend->expects($this->once())
            ->method('__toString')
            ->willReturn('{file contents}');

        $filesystem = $this->createMock(FilesystemInterface::class);
        $filesystem->expects($this->once())
            ->method('put')
            ->with('test.csv', '{file contents}');

        $writer = new CsvWriter(
            $backend,
            $filesystem,
            'test.csv',
            true
        );

        $method = new ReflectionMethod(CsvWriter::class, 'finish');
        $method->setAccessible(true);
        $method->invoke($writer);
    }
}
