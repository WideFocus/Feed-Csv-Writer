<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */
namespace WideFocus\Feed\CsvWriter;

use WideFocus\Feed\Writer\WriterParametersInterface;

/**
 * Contains the parameters used by a CSV writer.
 */
interface CsvWriterParametersInterface extends WriterParametersInterface
{
    /**
     * Get the destination.
     *
     * @return string
     */
    public function getDestination(): string;

    /**
     * Whether to include the header.
     *
     * @return bool
     */
    public function isIncludeHeader(): bool;

    /**
     * Get the delimiter.
     *
     * @return string
     */
    public function getDelimiter(): string;

    /**
     * Get the enclosure.
     *
     * @return string
     */
    public function getEnclosure(): string;

    /**
     * Get the escape.
     *
     * @return string
     */
    public function getEscape(): string;

    /**
     * Get the newline.
     *
     * @return string
     */
    public function getNewline(): string;

    /**
     * Get the BOM.
     *
     * @return string
     */
    public function getBom(): string;
}
