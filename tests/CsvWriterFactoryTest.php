<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests;

use League\Csv\Writer;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use PHPUnit\Framework\TestCase;
use WideFocus\Feed\CsvWriter\CsvWriter;
use WideFocus\Feed\CsvWriter\CsvWriterFactory;
use WideFocus\Feed\CsvWriter\LeagueCsv\LeagueCsvWriterFactoryInterface;
use WideFocus\Parameters\ParameterBagInterface;

/**
 * @coversDefaultClass \WideFocus\Feed\CsvWriter\CsvWriterFactory
 */
class CsvWriterFactoryTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(
            CsvWriterFactory::class,
            new CsvWriterFactory(
                $this->createMock(LeagueCsvWriterFactoryInterface::class),
                $this->createMock(MountManager::class)
            )
        );
    }

    /**
     * @return void
     *
     * @covers ::create
     * @covers ::getFilesystem
     * @covers ::getDestinationPath
     */
    public function testCreate()
    {
        $parameters = $this->createMock(ParameterBagInterface::class);
        $parameters
            ->expects($this->any())
            ->method('get')
            ->willReturnArgument(1);

        $mountManager = $this->createMock(MountManager::class);
        $mountManager->expects($this->any())
            ->method('filterPrefix')
            ->with(['tmp://feed.csv'])
            ->willReturn(['tmp', ['feed.csv']]);

        $mountManager->expects($this->once())
            ->method('getFilesystem')
            ->with('tmp')
            ->willReturn($this->createMock(FilesystemInterface::class));

        $backendFactory = $this->createMock(LeagueCsvWriterFactoryInterface::class);
        $backendFactory->expects($this->once())
            ->method('create')
            ->with($parameters)
            ->willReturn($this->createMock(Writer::class));

        $factory = new CsvWriterFactory($backendFactory, $mountManager);
        $this->assertInstanceOf(
            CsvWriter::class,
            $factory->create($parameters)
        );
    }
}
