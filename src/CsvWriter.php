<?php
/**
 * Copyright WideFocus. See LICENSE.txt.
 * https://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter;

use ArrayAccess;
use League\Csv\Writer;
use League\Flysystem\FilesystemInterface;
use WideFocus\Feed\Writer\ExtractFieldLabelsTrait;
use WideFocus\Feed\Writer\ExtractFieldValuesTrait;
use WideFocus\Feed\Writer\WriterFieldInterface;
use WideFocus\Feed\Writer\WriterInterface;
use WideFocus\Feed\Writer\WriterTrait;

/**
 * Writes CSV feeds.
 */
class CsvWriter implements WriterInterface
{
    use ExtractFieldLabelsTrait;
    use ExtractFieldValuesTrait;
    use WriterTrait;

    /**
     * @var Writer
     */
    private $backend;

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $includeHeader;

    /**
     * @var WriterFieldInterface[]
     */
    private $fields;

    /**
     * Constructor.
     *
     * @param Writer                 $backend
     * @param FilesystemInterface    $filesystem
     * @param string                 $path
     * @param bool                   $includeHeader
     * @param WriterFieldInterface[] ...$fields
     */
    public function __construct(
        Writer $backend,
        FilesystemInterface $filesystem,
        string $path,
        bool $includeHeader,
        WriterFieldInterface ...$fields
    ) {
        $this->backend       = $backend;
        $this->filesystem    = $filesystem;
        $this->path          = $path;
        $this->includeHeader = $includeHeader;
        $this->fields        = $fields;
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
                $this->extractFieldLabels(...$this->fields)
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
            $this->extractFieldValues($item, ...$this->fields)
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
