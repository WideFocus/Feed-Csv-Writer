<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\LeagueCsv;


use League\Csv\Writer;
use WideFocus\Feed\CsvWriter\CsvWriterLayoutInterface;

interface LeagueCsvWriterFactoryInterface
{
    /**
     * Create a CSV writer based a writer layout.
     *
     * @param CsvWriterLayoutInterface $writerLayout
     *
     * @return Writer
     */
    public function createWriter(CsvWriterLayoutInterface $writerLayout): Writer;
}