<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */
namespace WideFocus\Feed\CsvWriter;

use WideFocus\Feed\Writer\WriterLayoutInterface;

/**
 * Contains the layout used by a CSV writer.
 */
interface CsvWriterLayoutInterface extends WriterLayoutInterface
{
    /**
     * Get the destination.
     *
     * @return string
     */
    public function getDestination(): string;

    /**
     * Set the destination.
     *
     * @param string $destination
     *
     * @return CsvWriterLayoutInterface
     */
    public function setDestination(string $destination): CsvWriterLayoutInterface;

    /**
     * Whether to include the header.
     *
     * @return bool
     */
    public function isIncludeHeader(): bool;

    /**
     * Set whether to include the header.
     *
     * @param bool $includeHeader
     *
     * @return CsvWriterLayoutInterface
     */
    public function setIncludeHeader(bool $includeHeader): CsvWriterLayoutInterface;

    /**
     * Get the delimiter.
     *
     * @return string
     */
    public function getDelimiter(): string;

    /**
     * Set the delimiter.
     *
     * @param string $delimiter
     *
     * @return CsvWriterLayoutInterface
     */
    public function setDelimiter(string $delimiter): CsvWriterLayoutInterface;

    /**
     * Get the enclosure.
     *
     * @return string
     */
    public function getEnclosure(): string;

    /**
     * Set the enclosure.
     *
     * @param string $enclosure
     *
     * @return CsvWriterLayoutInterface
     */
    public function setEnclosure(string $enclosure): CsvWriterLayoutInterface;

    /**
     * Get the escape.
     *
     * @return string
     */
    public function getEscape(): string;

    /**
     * Set the escape.
     *
     * @param string $escape
     *
     * @return CsvWriterLayoutInterface
     */
    public function setEscape(string $escape): CsvWriterLayoutInterface;

    /**
     * Get the newline.
     *
     * @return string
     */
    public function getNewline(): string;

    /**
     * Set the newline.
     *
     * @param string $newline
     *
     * @return CsvWriterLayoutInterface
     */
    public function setNewline(string $newline): CsvWriterLayoutInterface;

    /**
     * Get the BOM.
     *
     * @return string
     */
    public function getBom(): string;

    /**
     * Set the BOM.
     *
     * @param string $bom
     *
     * @return CsvWriterLayoutInterface
     */
    public function setBom(string $bom): CsvWriterLayoutInterface;
}
