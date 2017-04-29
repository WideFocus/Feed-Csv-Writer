<?php
/**
 * Copyright WideFocus. See LICENSE.txt.
 * https://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\LeagueCsv;

use League\Csv\Writer;
use SplTempFileObject;
use WideFocus\Feed\CsvWriter\CsvWriterParametersInterface;
use WideFocus\Parameters\ParameterBagInterface;

class LeagueCsvWriterFactory implements LeagueCsvWriterFactoryInterface
{
    /**
     * Create a CSV writer based a writer parameters.
     *
     * @param ParameterBagInterface $parameters
     *
     * @return Writer
     */
    public function create(ParameterBagInterface $parameters): Writer
    {
        $writer = Writer::createFromFileObject(new SplTempFileObject());

        $writer
            ->setDelimiter($parameters->get('delimiter', ','))
            ->setEnclosure($parameters->get('enclosure', '"'))
            ->setNewline($parameters->get('newline', "\n"))
            ->setEscape($parameters->get('escape', '\\'))
            ->setOutputBOM($parameters->get('bom', ''));

        return $writer;
    }
}