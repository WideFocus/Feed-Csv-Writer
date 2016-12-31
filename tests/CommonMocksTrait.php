<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests;

use ArrayAccess;
use League\Csv\Writer;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use PHPUnit_Framework_MockObject_MockObject;
use WideFocus\Feed\CsvWriter\CsvWriterLayoutInterface;
use WideFocus\Feed\CsvWriter\LeagueCsv\LeagueCsvWriterFactoryInterface;
use WideFocus\Feed\Writer\WriterField\LabelExtractorInterface;
use WideFocus\Feed\Writer\WriterField\ValueExtractorInterface;
use WideFocus\Feed\Writer\WriterField\WriterFieldInterface;
use WideFocus\Feed\Writer\WriterInterface;

trait CommonMocksTrait
{
    /**
     * @return FilesystemInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createFilesystemMock(): FilesystemInterface
    {
        return $this->createMock(FilesystemInterface::class);
    }

    /**
     * @return MountManager|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMountManagerMock(): MountManager
    {
        return $this->createMock(MountManager::class);
    }

    /**
     * @return Writer|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createLeagueCsvWriterMock(): Writer
    {
        return $this->createMock(Writer::class);
    }

    /**
     * @return LeagueCsvWriterFactoryInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createLeagueCsvWriterFactoryMock(): LeagueCsvWriterFactoryInterface
    {
        return $this->createMock(LeagueCsvWriterFactoryInterface::class);
    }

    /**
     * @return CsvWriterLayoutInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createCsvWriterLayoutMock(): CsvWriterLayoutInterface
    {
        return $this->createMock(CsvWriterLayoutInterface::class);
    }

    /**
     * @return WriterInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createWriterMock(): WriterInterface
    {
        return $this->createMock(WriterInterface::class);
    }

    /**
     * @return WriterFieldInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createWriterFieldMock(): WriterFieldInterface
    {
        return $this->createMock(WriterFieldInterface::class);
    }

    /**
     * @return LabelExtractorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createLabelExtractorMock(): LabelExtractorInterface
    {
        return $this->createMock(LabelExtractorInterface::class);
    }

    /**
     * @return ValueExtractorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createValueExtractorMock(): ValueExtractorInterface
    {
        return $this->createMock(ValueExtractorInterface::class);
    }

    /**
     * @return ArrayAccess|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createFeedItemMock(): ArrayAccess
    {
        return $this->createMock(ArrayAccess::class);
    }

    /**
     * @param string $originalClassName
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    abstract protected function createMock($originalClassName);  // @codingStandardsIgnoreLine
}
