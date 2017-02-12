<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests;

use League\Csv\Writer;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use PHPUnit_Framework_TestCase;
use WideFocus\Feed\CsvWriter\CsvWriterFactory;
use WideFocus\Feed\CsvWriter\CsvWriterParametersInterface;
use WideFocus\Feed\CsvWriter\LeagueCsv\LeagueCsvWriterFactoryInterface;
use WideFocus\Feed\Writer\WriterFactoryInterface;
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
     * @return WriterInterface
     *
     * @covers ::createWriter
     * @covers ::getFilesystem
     * @covers ::getDestinationPath
     */
    public function testCreateWriter(): WriterInterface
    {
        $parameters = $this->createMock(CsvWriterParametersInterface::class);
        $parameters->expects($this->any())
            ->method('getDestination')
            ->willReturn('local://test.csv');

        $mountManager   = $this->createMock(MountManager::class);
        $mountManager->expects($this->any())
            ->method('filterPrefix')
            ->with(['local://test.csv'])
            ->willReturn(['local', ['test.csv']]);

        $mountManager->expects($this->once())
            ->method('getFilesystem')
            ->with('local')
            ->willReturn($this->createMock(FilesystemInterface::class));

        $backendFactory = $this->createMock(LeagueCsvWriterFactoryInterface::class);
        $backendFactory->expects($this->once())
            ->method('createWriter')
            ->with($parameters)
            ->willReturn($this->createMock(Writer::class));

        $factory = new CsvWriterFactory($backendFactory, $mountManager);
        return $factory->createWriter($parameters);
    }
}
