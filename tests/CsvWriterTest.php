<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests;

use ArrayAccess;
use League\Csv\Writer;
use League\Flysystem\FilesystemInterface;
use PHPUnit_Framework_TestCase;
use ReflectionMethod;
use WideFocus\Feed\CsvWriter\CsvWriter;
use WideFocus\Feed\Writer\Field\LabelExtractorInterface;
use WideFocus\Feed\Writer\Field\ValueExtractorInterface;
use WideFocus\Feed\Writer\Field\WriterFieldInterface;
use WideFocus\Feed\Writer\WriterInterface;

/**
 * @coversDefaultClass \WideFocus\Feed\CsvWriter\CsvWriter
 */
class CsvWriterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return WriterInterface
     *
     * @covers ::__construct
     */
    public function testConstructor(): WriterInterface
    {
        return new CsvWriter(
            $this->createMock(Writer::class),
            $this->createMock(FilesystemInterface::class),
            $this->createMock(LabelExtractorInterface::class),
            $this->createMock(ValueExtractorInterface::class),
            'test.csv',
            true
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
        $backend        = $this->createMock(Writer::class);
        $labelExtractor = $this->createMock(LabelExtractorInterface::class);

        $labels = ['Foo', 'Bar'];
        $fields = [
            $this->createMock(WriterFieldInterface::class),
            $this->createMock(WriterFieldInterface::class)
        ];


        if ($includeHeaders) {
            $labelExtractor->expects($this->once())
                ->method('extract')
                ->with($fields)
                ->willReturn($labels);

            $backend->expects($this->once())
                ->method('insertOne')
                ->with($labels);
        }

        $writer = new CsvWriter(
            $backend,
            $this->createMock(FilesystemInterface::class),
            $labelExtractor,
            $this->createMock(ValueExtractorInterface::class),
            'test.csv',
            true
        );
        $writer->setFields($fields);

        $method = $this->getProtectedMethod(CsvWriter::class, 'initialize');
        $method->invoke($writer);
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
        $backend        = $this->createMock(Writer::class);
        $valueExtractor = $this->createMock(ValueExtractorInterface::class);

        $values = ['foo', 'bar'];
        $item   = $this->createMock(ArrayAccess::class);
        $fields = [
            $this->createMock(WriterFieldInterface::class),
            $this->createMock(WriterFieldInterface::class)
        ];

        $valueExtractor->expects($this->once())
            ->method('extract')
            ->with($fields, $item)
            ->willReturn($values);

        $backend->expects($this->once())
            ->method('insertOne')
            ->with($values);

        $writer = new CsvWriter(
            $backend,
            $this->createMock(FilesystemInterface::class),
            $this->createMock(LabelExtractorInterface::class),
            $valueExtractor,
            'test.csv',
            true
        );
        $writer->setFields($fields);

        $method = $this->getProtectedMethod(CsvWriter::class, 'writeItem');
        $method->invoke($writer, $item);
    }

    /**
     * @return void
     *
     * @covers ::finish
     */
    public function testFinish()
    {
        $backend    = $this->createMock(Writer::class);
        $filesystem = $this->createMock(FilesystemInterface::class);

        $backend->expects($this->once())
            ->method('__toString')
            ->willReturn('{file contents}');

        $filesystem->expects($this->once())
            ->method('put')
            ->with('test.csv', '{file contents}');

        $writer = new CsvWriter(
            $backend,
            $filesystem,
            $this->createMock(LabelExtractorInterface::class),
            $this->createMock(ValueExtractorInterface::class),
            'test.csv',
            true
        );

        $method = $this->getProtectedMethod(CsvWriter::class, 'finish');
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
     * Get an accessible reflection of a protected method.
     *
     * @param string $class
     * @param string $method
     *
     * @return ReflectionMethod
     */
    protected function getProtectedMethod(string $class, string $method): ReflectionMethod
    {
        $reflection = new ReflectionMethod($class, $method);
        $reflection->setAccessible(true);
        return $reflection;
    }
}
