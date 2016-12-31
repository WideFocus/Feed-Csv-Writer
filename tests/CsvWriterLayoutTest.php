<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests;

use League\Csv\Writer;
use WideFocus\Feed\CsvWriter\CsvWriterLayout;
use WideFocus\Feed\CsvWriter\CsvWriterLayoutInterface;

/**
 * @coversDefaultClass \WideFocus\Feed\CsvWriter\CsvWriterLayout
 */
class CsvWriterLayoutTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param CsvWriterLayoutInterface $layout
     * @param string                   $setter
     * @param string                   $getter
     * @param mixed                    $value
     *
     * @return void
     *
     * @dataProvider dataProvider
     *
     * @covers ::getDestination
     * @covers ::setDestination
     * @covers ::isIncludeHeader
     * @covers ::setIncludeHeader
     * @covers ::getDelimiter
     * @covers ::setDelimiter
     * @covers ::getEnclosure
     * @covers ::setEnclosure
     * @covers ::getEscape
     * @covers ::setEscape
     * @covers ::getNewline
     * @covers ::setNewline
     * @covers ::getBom
     * @covers ::setBom
     */
    public function testSettersAndGetters(
        CsvWriterLayoutInterface $layout,
        string $setter,
        string $getter,
        $value
    ) {
        $layout->$setter($value);
        $this->assertEquals($value, $layout->$getter());
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        $layout = new CsvWriterLayout();
        return [
            'destination'    => [$layout, 'setDestination', 'getDestination', 'local://test.csv'],
            'include_header' => [$layout, 'setIncludeHeader', 'isIncludeHeader', true],
            'delimiter'      => [$layout, 'setDelimiter', 'getDelimiter', "\t"],
            'enclosure'      => [$layout, 'setEnclosure', 'getEnclosure', "|"],
            'escape'         => [$layout, 'setEscape', 'getEscape', '='],
            'newline'        => [$layout, 'setNewline', 'getNewline', "\r\n"],
            'bom'            => [$layout, 'setBom', 'getBom', Writer::BOM_UTF32_BE]
        ];
    }
}
