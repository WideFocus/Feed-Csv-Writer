<?php
/**
 * Copyright WideFocus. See LICENSE.txt.
 * https://www.widefocus.net
 */
namespace WideFocus\Feed\CsvWriter;

use WideFocus\Parameters\ParameterBag;

/**
 * Contains the parameters used by a CSV writer.
 */
class CsvWriterParameters extends ParameterBag implements CsvWriterParametersInterface
{
    /**
     * Get the destination.
     *
     * @return string
     */
    public function getDestination(): string
    {
        return $this->get('destination');
    }

    /**
     * Whether to include the header.
     *
     * @return bool
     */
    public function isIncludeHeader(): bool
    {
        return (bool) $this->get('include_header');
    }

    /**
     * Get the delimiter.
     *
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->get('delimiter');
    }

    /**
     * Get the enclosure.
     *
     * @return string
     */
    public function getEnclosure(): string
    {
        return $this->get('enclosure');
    }

    /**
     * Get the escape.
     *
     * @return string
     */
    public function getEscape(): string
    {
        return $this->get('escape');
    }

    /**
     * Get the newline.
     *
     * @return string
     */
    public function getNewline(): string
    {
        return $this->get('newline');
    }

    /**
     * Get the BOM.
     *
     * @return string
     */
    public function getBom(): string
    {
        return $this->get('bom');
    }
}
