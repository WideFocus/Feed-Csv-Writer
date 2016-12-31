<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter;

use ArrayAccess;
use League\Csv\Writer;
use League\Flysystem\FilesystemInterface;
use WideFocus\Feed\Writer\AbstractWriter;
use WideFocus\Feed\Writer\WriterField\LabelExtractorInterface;
use WideFocus\Feed\Writer\WriterField\ValueExtractorInterface;

/**
 * Writes CSV feeds.
 */
class CsvWriter extends AbstractWriter
{
    /**
     * @var Writer
     */
    private $backend;

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @var LabelExtractorInterface
     */
    private $labelExtractor;

    /**
     * @var ValueExtractorInterface
     */
    private $valueExtractor;

    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $includeHeader;

    /**
     * Constructor.
     *
     * @param Writer                  $backend
     * @param FilesystemInterface     $filesystem
     * @param LabelExtractorInterface $labelExtractor
     * @param ValueExtractorInterface $valueExtractor
     * @param string                  $path
     * @param bool                    $includeHeader
     */
    public function __construct(
        Writer $backend,
        FilesystemInterface $filesystem,
        LabelExtractorInterface $labelExtractor,
        ValueExtractorInterface $valueExtractor,
        string $path,
        bool $includeHeader
    ) {
        $this->backend        = $backend;
        $this->filesystem     = $filesystem;
        $this->labelExtractor = $labelExtractor;
        $this->valueExtractor = $valueExtractor;
        $this->path           = $path;
        $this->includeHeader  = $includeHeader;
    }

    /**
     * Initialize the feed.
     *
     * @return void
     */
    protected function initialize()
    {
        if ($this->isIncludeHeader()) {
            $this->getBackend()->insertOne(
                $this->getLabelExtractor()->extract(
                    $this->getFields()
                )
            );
        }
    }

    /**
     * Write an item to the feed.
     *
     * @param ArrayAccess $item
     *
     * @return void
     */
    protected function writeItem(ArrayAccess $item)
    {
        $this->getBackend()->insertOne(
            $this->getValueExtractor()->extract(
                $this->getFields(),
                $item
            )
        );
    }

    /**
     * Finish the feed.
     *
     * @return void
     */
    protected function finish()
    {
        $this->getFilesystem()->put(
            $this->getPath(),
            (string)$this->getBackend()
        );
    }

    /**
     * Get the backend.
     *
     * @return Writer
     */
    protected function getBackend(): Writer
    {
        return $this->backend;
    }

    /**
     * Get the filesystem.
     *
     * @return FilesystemInterface
     */
    protected function getFilesystem(): FilesystemInterface
    {
        return $this->filesystem;
    }

    /**
     * Get the label extractor.
     *
     * @return LabelExtractorInterface
     */
    protected function getLabelExtractor(): LabelExtractorInterface
    {
        return $this->labelExtractor;
    }

    /**
     * Get the value extractor.
     *
     * @return ValueExtractorInterface
     */
    protected function getValueExtractor(): ValueExtractorInterface
    {
        return $this->valueExtractor;
    }

    /**
     * Get the path.
     *
     * @return string
     */
    protected function getPath(): string
    {
        return $this->path;
    }

    /**
     * Whether to include the header.
     *
     * @return bool
     */
    protected function isIncludeHeader(): bool
    {
        return $this->includeHeader;
    }
}
