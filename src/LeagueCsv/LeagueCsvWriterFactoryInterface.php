<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\LeagueCsv;

use League\Csv\Writer;
use WideFocus\Feed\CsvWriter\CsvWriterParametersInterface;

interface LeagueCsvWriterFactoryInterface
{
    /**
     * Create a CSV writer based a writer parameters.
     *
     * @param CsvWriterParametersInterface $parameters
     *
     * @return Writer
     */
    public function createWriter(CsvWriterParametersInterface $parameters): Writer;
}