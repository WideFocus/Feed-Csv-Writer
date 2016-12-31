<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests\LeagueCsv;

use League\Csv\Writer;
use WideFocus\Feed\CsvWriter\CsvWriterLayoutInterface;
use WideFocus\Feed\CsvWriter\LeagueCsv\LeagueCsvWriterFactory;
use WideFocus\Feed\CsvWriter\Tests\CommonMocksTrait;

/**
 * @coversDefaultClass \WideFocus\Feed\CsvWriter\LeagueCsv\LeagueCsvWriterFactory
 */
class LeagueCsvWriterFactoryTest extends \PHPUnit_Framework_TestCase
{
    use CommonMocksTrait;

    /**
     * @param CsvWriterLayoutInterface $layout
     * @param array                    $writerValues
     *
     * @return Writer
     *
     * @dataProvider dataProvider
     *
     * @covers ::createWriter
     */
    public function testCreateWriter(CsvWriterLayoutInterface $layout, array $writerValues): Writer
    {
        $factory = new LeagueCsvWriterFactory();
        $writer  = $factory->createWriter($layout);
        foreach ($writerValues as $getter => $value) {
            $this->assertEquals($writer->$getter(), $value);
        }
        return $writer;
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        $writerValues = [
            'getDelimiter' => "\t",
            'getEnclosure' => '|',
            'getEscape'    => '=',
            'getNewline'   => "\r\n",
            'getOutputBOM' => Writer::BOM_UTF32_BE
        ];

        $layoutValues = [
            'getDelimiter' => "\t",
            'getEnclosure' => '|',
            'getEscape'    => '=',
            'getNewline'   => "\r\n",
            'getBom'       => Writer::BOM_UTF32_BE
        ];

        $layout = $this->createCsvWriterLayoutMock();
        foreach ($layoutValues as $getter => $value) {
            $layout->expects($this->once())
                ->method($getter)
                ->willReturn($value);
        }

        return [
            [
                $layout,
                $writerValues
            ]
        ];
    }
}
