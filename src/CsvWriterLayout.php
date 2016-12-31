<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */
namespace WideFocus\Feed\CsvWriter;

/**
 * Contains the layout used by a CSV writer.
 */
class CsvWriterLayout implements CsvWriterLayoutInterface
{
    /**
     * @var string
     */
    private $destination;

    /**
     * @var bool
     */
    private $includeHeader;

    /**
     * @var string
     */
    private $delimiter = ',';

    /**
     * @var string
     */
    private $enclosure = '"';

    /**
     * @var string
     */
    private $escape = '\\';

    /**
     * @var string
     */
    private $newline = PHP_EOL;

    /**
     * @var string
     */
    private $bom = '';

    /**
     * Get the destination.
     *
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * Set the destination.
     *
     * @param string $destination
     *
     * @return CsvWriterLayoutInterface
     */
    public function setDestination(string $destination): CsvWriterLayoutInterface
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * Whether to include the header.
     *
     * @return bool
     */
    public function isIncludeHeader(): bool
    {
        return $this->includeHeader;
    }

    /**
     * Set whether to include the header.
     *
     * @param bool $includeHeader
     *
     * @return CsvWriterLayoutInterface
     */
    public function setIncludeHeader(bool $includeHeader): CsvWriterLayoutInterface
    {
        $this->includeHeader = $includeHeader;
        return $this;
    }

    /**
     * Get the delimiter.
     *
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * Set the delimiter.
     *
     * @param string $delimiter
     *
     * @return CsvWriterLayoutInterface
     */
    public function setDelimiter(string $delimiter): CsvWriterLayoutInterface
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    /**
     * Get the enclosure.
     *
     * @return string
     */
    public function getEnclosure(): string
    {
        return $this->enclosure;
    }

    /**
     * Set the enclosure.
     *
     * @param string $enclosure
     *
     * @return CsvWriterLayoutInterface
     */
    public function setEnclosure(string $enclosure): CsvWriterLayoutInterface
    {
        $this->enclosure = $enclosure;
        return $this;
    }

    /**
     * Get the escape.
     *
     * @return string
     */
    public function getEscape(): string
    {
        return $this->escape;
    }

    /**
     * Set the escape.
     *
     * @param string $escape
     *
     * @return CsvWriterLayoutInterface
     */
    public function setEscape(string $escape): CsvWriterLayoutInterface
    {
        $this->escape = $escape;
        return $this;
    }

    /**
     * Get the newline.
     *
     * @return string
     */
    public function getNewline(): string
    {
        return $this->newline;
    }

    /**
     * Set the newline.
     *
     * @param string $newline
     *
     * @return CsvWriterLayoutInterface
     */
    public function setNewline(string $newline): CsvWriterLayoutInterface
    {
        $this->newline = $newline;
        return $this;
    }

    /**
     * Get the BOM.
     *
     * @return string
     */
    public function getBom(): string
    {
        return $this->bom;
    }

    /**
     * Set the BOM.
     *
     * @param string $bom
     *
     * @return CsvWriterLayoutInterface
     */
    public function setBom(string $bom): CsvWriterLayoutInterface
    {
        $this->bom = $bom;
        return $this;
    }
}
