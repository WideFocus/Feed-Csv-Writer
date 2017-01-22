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
use WideFocus\Feed\Writer\Field\LabelExtractorInterface;
use WideFocus\Feed\Writer\Field\ValueExtractorInterface;

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
        if ($this->includeHeader) {
            $this->backend->insertOne(
                $this->labelExtractor->extract(
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
        $this->backend->insertOne(
            $this->valueExtractor->extract(
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
        $this->filesystem->put(
            $this->path,
            (string)$this->backend
        );
    }
}
