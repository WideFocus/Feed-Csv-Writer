<?php
/**
 * Copyright WideFocus. See LICENSE.txt.
 * https://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests;

use League\Csv\Writer;
use WideFocus\Feed\CsvWriter\CsvWriterParameters;
use WideFocus\Feed\CsvWriter\CsvWriterParametersInterface;

/**
 * @coversDefaultClass \WideFocus\Feed\CsvWriter\CsvWriterParameters
 */
class CsvWriterParametersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param CsvWriterParametersInterface $parameters
     * @param string                       $parameterName
     * @param string                       $getter
     * @param mixed                        $value
     *
     * @return void
     *
     * @dataProvider dataProvider
     *
     * @covers ::getDestination
     * @covers ::isIncludeHeader
     * @covers ::getDelimiter
     * @covers ::getEnclosure
     * @covers ::getEscape
     * @covers ::getNewline
     * @covers ::getBom
     */
    public function testSettersAndGetters(
        CsvWriterParametersInterface $parameters,
        string $parameterName,
        string $getter,
        $value
    ) {
        $parameters = $parameters->with($parameterName, $value);
        $this->assertEquals($value, $parameters->$getter());
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        $parameters = new CsvWriterParameters();
        return [
            'destination'    => [$parameters, 'destination', 'getDestination', 'local://test.csv'],
            'include_header' => [$parameters, 'include_header', 'isIncludeHeader', true],
            'delimiter'      => [$parameters, 'delimiter', 'getDelimiter', "\t"],
            'enclosure'      => [$parameters, 'enclosure', 'getEnclosure', "|"],
            'escape'         => [$parameters, 'escape', 'getEscape', '='],
            'newline'        => [$parameters, 'newline', 'getNewline', "\r\n"],
            'bom'            => [$parameters, 'bom', 'getBom', Writer::BOM_UTF32_BE]
        ];
    }
}
