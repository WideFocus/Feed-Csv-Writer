<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\LeagueCsv;

use League\Csv\Writer;
use SplTempFileObject;
use WideFocus\Feed\CsvWriter\CsvWriterLayoutInterface;

class LeagueCsvWriterFactory implements LeagueCsvWriterFactoryInterface
{
    /**
     * Create a CSV writer based a writer layout.
     *
     * @param CsvWriterLayoutInterface $writerLayout
     *
     * @return Writer
     */
    public function createWriter(CsvWriterLayoutInterface $writerLayout): Writer
    {
        $writer = Writer::createFromFileObject(new SplTempFileObject());

        $writer
            ->setDelimiter($writerLayout->getDelimiter())
            ->setEnclosure($writerLayout->getEnclosure())
            ->setNewline($writerLayout->getNewline())
            ->setEscape($writerLayout->getEscape())
            ->setOutputBOM($writerLayout->getBom());

        return $writer;
    }
}