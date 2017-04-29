<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests\LeagueCsv;


use League\Csv\Writer;
use WideFocus\Feed\CsvWriter\LeagueCsv\LeagueCsvWriterFactory;
use WideFocus\Parameters\ParameterBagInterface;

/**
 * @coversDefaultClass \WideFocus\Feed\CsvWriter\LeagueCsv\LeagueCsvWriterFactory
 */
class LeagueCsvWriterFactoryTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @return void
     *
     * @covers ::create
     */
    public function testCreate()
    {
        $parameters = $this->createMock(ParameterBagInterface::class);
        $parameters
            ->expects($this->any())
            ->method('get')
            ->willReturnArgument(1);

        $factory = new LeagueCsvWriterFactory();
        $writer  = $factory->create($parameters);

        $this->assertInstanceOf(Writer::class, $writer);
        $this->assertEquals(',', $writer->getDelimiter());
        $this->assertEquals('"', $writer->getEnclosure());
        $this->assertEquals("\n", $writer->getNewline());
        $this->assertEquals('\\', $writer->getEscape());
        $this->assertEquals('', $writer->getOutputBOM());
    }
}
