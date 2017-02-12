<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\LeagueCsv;

use League\Csv\Writer;
use SplTempFileObject;
use WideFocus\Feed\CsvWriter\CsvWriterParametersInterface;

class LeagueCsvWriterFactory implements LeagueCsvWriterFactoryInterface
{
    /**
     * Create a CSV writer based a writer parameters.
     *
     * @param CsvWriterParametersInterface $parameters
     *
     * @return Writer
     */
    public function createWriter(CsvWriterParametersInterface $parameters): Writer
    {
        $writer = Writer::createFromFileObject(new SplTempFileObject());

        $writer
            ->setDelimiter($parameters->getDelimiter())
            ->setEnclosure($parameters->getEnclosure())
            ->setNewline($parameters->getNewline())
            ->setEscape($parameters->getEscape())
            ->setOutputBOM($parameters->getBom());

        return $writer;
    }
}