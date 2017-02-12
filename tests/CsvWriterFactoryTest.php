<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests;

use League\Csv\Writer;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use WideFocus\Feed\CsvWriter\CsvWriterFactory;
use WideFocus\Feed\CsvWriter\CsvWriterParametersInterface;
use WideFocus\Feed\CsvWriter\LeagueCsv\LeagueCsvWriterFactoryInterface;
use WideFocus\Feed\Writer\WriterFactoryInterface;
use WideFocus\Feed\Writer\Field\WriterFieldInterface;
use WideFocus\Feed\Writer\WriterInterface;

/**
 * @coversDefaultClass \WideFocus\Feed\CsvWriter\CsvWriterFactory
 */
class CsvWriterFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return WriterFactoryInterface
     *
     * @covers ::__construct
     */
    public function testConstructor(): WriterFactoryInterface
    {
        $backendFactory = $this->createMock(LeagueCsvWriterFactoryInterface::class);
        $mountManager   = $this->createMock(MountManager::class);
        
        return new CsvWriterFactory($backendFactory, $mountManager);
    }

    /**
     * @param WriterFieldInterface[]                                               $fields
     * @param CsvWriterParametersInterface|PHPUnit_Framework_MockObject_MockObject $layout
     *
     * @return WriterInterface
     *
     * @dataProvider argumentsDataProvider
     *
     * @covers ::createWriter
     * @covers ::getFilesystem
     * @covers ::getDestinationPath
     */
    public function testCreateWriter(array $fields, CsvWriterParametersInterface $layout): WriterInterface
    {
        $backendFactory = $this->createMock(LeagueCsvWriterFactoryInterface::class);
        $mountManager   = $this->createMock(MountManager::class);

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
            ->willReturn($this->createMock(FilesystemInterface::class));

        $backendFactory->expects($this->once())
            ->method('createWriter')
            ->with($layout)
            ->willReturn($this->createMock(Writer::class));

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
                    $this->createMock(WriterFieldInterface::class),
                    $this->createMock(WriterFieldInterface::class)
                ],
                $this->createMock(CsvWriterParametersInterface::class)
            ]
        ];
    }
}
