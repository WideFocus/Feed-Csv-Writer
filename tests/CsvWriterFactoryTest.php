<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use WideFocus\Feed\CsvWriter\CsvWriterFactory;
use WideFocus\Feed\Writer\WriterFactoryInterface;
use WideFocus\Feed\Writer\WriterField\WriterFieldInterface;
use WideFocus\Feed\Writer\WriterInterface;
use WideFocus\Feed\Writer\WriterLayoutInterface;

/**
 * @coversDefaultClass \WideFocus\Feed\CsvWriter\CsvWriterFactory
 */
class CsvWriterFactoryTest extends PHPUnit_Framework_TestCase
{
    use CommonMocksTrait;

    /**
     * @return WriterFactoryInterface
     *
     * @covers ::__construct
     */
    public function testConstructor(): WriterFactoryInterface
    {
        $backendFactory = $this->createLeagueCsvWriterFactoryMock();
        $mountManager   = $this->createMountManagerMock();
        
        return new CsvWriterFactory($backendFactory, $mountManager);
    }

    /**
     * @param WriterFieldInterface[]                                        $fields
     * @param WriterLayoutInterface|PHPUnit_Framework_MockObject_MockObject $layout
     *
     * @return WriterInterface
     *
     * @dataProvider argumentsDataProvider
     *
     * @covers ::createWriter
     * @covers ::getFilesystem
     * @covers ::getDestinationPath
     */
    public function testCreateWriter(array $fields, WriterLayoutInterface $layout): WriterInterface
    {
        $backendFactory = $this->createLeagueCsvWriterFactoryMock();
        $mountManager   = $this->createMountManagerMock();

        $layout->expects($this->any())
            ->method('getDestination')
            ->willReturn('local://test.csv');

        $mountManager->expects($this->any())
            ->method('filterPrefix')
            ->with(['local://test.csv'])
            ->willReturn(['local', ['test.csv']]);

        $mountManager->expects($this->once())
            ->method('getFilesystem')
            ->with('local')
            ->willReturn($this->createFilesystemMock());

        $backendFactory->expects($this->once())
            ->method('createWriter')
            ->with($layout)
            ->willReturn($this->createLeagueCsvWriterMock());

        $factory = new CsvWriterFactory($backendFactory, $mountManager);
        return $factory->createWriter($fields, $layout);
    }

    /**
     * @return array
     */
    public function argumentsDataProvider(): array
    {
        return [
            [
                [
                    $this->createWriterFieldMock(),
                    $this->createWriterFieldMock()
                ],
                $this->createCsvWriterLayoutMock()
            ]
        ];
    }
}
