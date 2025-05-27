<?php

namespace Sdmx\Tests\api\parser\v21;

use PHPUnit\Framework\TestCase;
use Sdmx\api\entities\Dataflow;
use Sdmx\api\parser\DataflowParser;
use Sdmx\api\parser\v21\V21DataflowParser;

class V21DataflowParserTest extends TestCase
{
    /**
     * @var DataflowParser $parser
     */
    private $parser;

    public function testParseDataflowList()
    {
        $result = $this->parser->parse(V21ParserFixtures::getDataflow());

        $this->assertNotNull($result);
        $this->assertEquals(2, count($result));

        $this->checkFlow($result[0], 'CE', '1.0', 'UNESCO', 'Cultural employment');
        $this->checkFlow($result[1], 'DEM_ECO', '1.0', 'UNESCO', 'Demographic and socio-economic indicators');
    }

    public function testParseDataflowWithoutName()
    {
        $result = $this->parser->parse(V21ParserFixtures::getDataflow('1'));

        $this->assertNotNull($result);
        $this->assertEquals(1, count($result));

        $this->checkFlow($result[0], 'CE', '1.0', 'UNESCO', NULL);
    }

    public function testParseDataflowWithoutDsd()
    {
        $result = $this->parser->parse(V21ParserFixtures::getDataflow('2'));

        $this->assertNotNull($result);
        $this->assertEquals(1, count($result));

        $this->checkFlow($result[0], 'CE', '1.0', 'UNESCO', 'Cultural employment', false);
    }

    private function checkFlow(Dataflow $dataflow, $id, $version, $agency, $name, $hasDsd = true)
    {
        $this->assertEquals($id, $dataflow->getId());
        $this->assertEquals($version, $dataflow->getVersion());
        $this->assertEquals($agency, $dataflow->getAgency());
        $this->assertEquals($name, $dataflow->getName());

        $dsdIdentifier = $dataflow->getDsdIdentifier();
        if($hasDsd){
            $this->assertEquals($id, $dsdIdentifier->getId());
            $this->assertEquals($version, $dsdIdentifier->getVersion());
            $this->assertEquals($agency, $dsdIdentifier->getAgency());
        } else {
            $this->assertNull($dsdIdentifier);
        }

    }

    protected function setUp():void
    {
        $this->parser = new V21DataflowParser();
    }


}
