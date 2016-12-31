<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests;

use PHPUnit_Framework_TestCase;
use WideFocus\Feed\CsvWriter\CsvWriter;
use WideFocus\Feed\Writer\WriterInterface;

/**
 * @coversDefaultClass \WideFocus\Feed\CsvWriter\CsvWriter
 */
class CsvWriterTest extends PHPUnit_Framework_TestCase
{
    use CommonMocksTrait;
    use ProtectedMethodTrait;

    /**
     * @return WriterInterface
     *
     * @covers ::__construct
     */
    public function testConstructor(): WriterInterface
    {
        return new CsvWriter(
            $this->createLeagueCsvWriterMock(),
            $this->createFilesystemMock(),
            $this->createLabelExtractorMock(),
            $this->createValueExtractorMock(),
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
     * @covers ::getBackend
     * @covers ::getLabelExtractor
     * @covers ::isIncludeHeader
     */
    public function testInitialize(bool $includeHeaders)
    {
        $backend        = $this->createLeagueCsvWriterMock();
        $labelExtractor = $this->createLabelExtractorMock();

        $labels = ['Foo', 'Bar'];
        $fields = [
            $this->createWriterFieldMock(),
            $this->createWriterFieldMock()
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
            $this->createFilesystemMock(),
            $labelExtractor,
            $this->createValueExtractorMock(),
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
     * @covers ::getValueExtractor
     */
    public function testWriteItem()
    {
        $backend        = $this->createLeagueCsvWriterMock();
        $valueExtractor = $this->createValueExtractorMock();

        $values = ['foo', 'bar'];
        $item   = $this->createFeedItemMock();
        $fields = [
            $this->createWriterFieldMock(),
            $this->createWriterFieldMock()
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
            $this->createFilesystemMock(),
            $this->createLabelExtractorMock(),
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
     * @covers ::getFilesystem
     * @covers ::getPath
     */
    public function testFinish()
    {
        $backend    = $this->createLeagueCsvWriterMock();
        $filesystem = $this->createFilesystemMock();

        $backend->expects($this->once())
            ->method('__toString')
            ->willReturn('{file contents}');

        $filesystem->expects($this->once())
            ->method('put')
            ->with('test.csv', '{file contents}');

        $writer = new CsvWriter(
            $backend,
            $filesystem,
            $this->createLabelExtractorMock(),
            $this->createValueExtractorMock(),
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
}
