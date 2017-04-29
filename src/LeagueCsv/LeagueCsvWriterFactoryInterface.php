<?php
/**
 * Copyright WideFocus. See LICENSE.txt.
 * https://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\LeagueCsv;

use League\Csv\Writer;
use WideFocus\Parameters\ParameterBagInterface;

interface LeagueCsvWriterFactoryInterface
{
    /**
     * Create a CSV writer based a writer parameters.
     *
     * @param ParameterBagInterface $parameters
     *
     * @return Writer
     */
    public function create(ParameterBagInterface $parameters): Writer;
}
