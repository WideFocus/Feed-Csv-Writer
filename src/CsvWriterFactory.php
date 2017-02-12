<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use WideFocus\Feed\CsvWriter\LeagueCsv\LeagueCsvWriterFactoryInterface;
use WideFocus\Feed\Writer\WriterFactoryInterface;
use WideFocus\Feed\Writer\Field\LabelExtractor;
use WideFocus\Feed\Writer\Field\ValueExtractor;
use WideFocus\Feed\Writer\Field\WriterFieldInterface;
use WideFocus\Feed\Writer\WriterInterface;
use WideFocus\Feed\Writer\WriterParametersInterface;

class CsvWriterFactory implements WriterFactoryInterface
{
    /**
     * @var LeagueCsvWriterFactoryInterface
     */
    private $backendFactory;

    /**
     * @var MountManager
     */
    private $mountManager;

    /**
     * Constructor.
     *
     * @param LeagueCsvWriterFactoryInterface $backendFactory
     * @param MountManager                    $mountManager
     */
    public function __construct(
        LeagueCsvWriterFactoryInterface $backendFactory,
        MountManager $mountManager
    ) {
        $this->backendFactory = $backendFactory;
        $this->mountManager   = $mountManager;
    }

    /**
     * Create a writer.
     *
     * @param WriterFieldInterface[]    $fields
     * @param WriterParametersInterface $parameters
     *
     * @return WriterInterface
     */
    public function createWriter(
        array $fields,
        WriterParametersInterface $parameters
    ): WriterInterface {
        /** @var CsvWriterParametersInterface $parameters */
        $backend        = $this->backendFactory->createWriter($parameters);
        $filesystem     = $this->getFilesystem($parameters->getDestination());
        $path           = $this->getDestinationPath($parameters->getDestination());
        $includeHeader  = $parameters->isIncludeHeader();
        $labelExtractor = new LabelExtractor();
        $valueExtractor = new ValueExtractor();

        $writer = new CsvWriter(
            $backend,
            $filesystem,
            $labelExtractor,
            $valueExtractor,
            $path,
            $includeHeader
        );

        $writer->setFields($fields);
        return $writer;
    }

    /**
     * Get the filesystem.
     *
     * @param string $destination
     *
     * @return FilesystemInterface
     */
    protected function getFilesystem(string $destination): FilesystemInterface
    {
        list($prefix) = $this->mountManager
            ->filterPrefix([$destination]);

        return $this->mountManager->getFilesystem($prefix);
    }

    /**
     * Get the destination path.
     *
     * @param string $destination
     *
     * @return string
     */
    protected function getDestinationPath(string $destination): string
    {
        list(, $arguments) = $this->mountManager
            ->filterPrefix([$destination]);

        return array_shift($arguments);
    }
}
