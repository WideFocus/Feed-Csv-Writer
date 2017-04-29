<?php
/**
 * Copyright WideFocus. See LICENSE.txt.
 * https://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use WideFocus\Feed\CsvWriter\LeagueCsv\LeagueCsvWriterFactoryInterface;
use WideFocus\Feed\Writer\Builder\WriterFactoryInterface;
use WideFocus\Feed\Writer\WriterFieldInterface;
use WideFocus\Feed\Writer\WriterInterface;
use WideFocus\Parameters\ParameterBagInterface;

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
     * @param ParameterBagInterface  $parameters
     * @param WriterFieldInterface[] ...$fields
     *
     * @return WriterInterface
     */
    public function create(
        ParameterBagInterface $parameters,
        WriterFieldInterface ...$fields
    ): WriterInterface {
        $destination = $parameters->get('destination', 'tmp://feed.csv');
        return new CsvWriter(
            $this->backendFactory->create($parameters),
            $this->getFilesystem($destination),
            $this->getDestinationPath($destination),
            $parameters->get('include_header', true),
            ...$fields
        );
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
