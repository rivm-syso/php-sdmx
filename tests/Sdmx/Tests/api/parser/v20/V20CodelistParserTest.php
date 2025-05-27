<?php

namespace Sdmx\Tests\api\parser\v20;


use PHPUnit\Framework\TestCase;
use Sdmx\api\parser\CodelistParser;
use Sdmx\api\parser\ParserUtils;
use Sdmx\api\parser\v20\V20CodelistParser;
use SimpleXMLElement;


class V20CodelistParserTest extends TestCase
{
    /**
     * @var CodelistParser $parser ;
     */
    private $parser;

    protected function setUp():void
    {
        $this->parser = new V20CodelistParser();
    }

    public function testParseCodelistNode()
    {
        $xml = new SimpleXMLElement(ParserUtils::removeNamespaces(V20ParserFixtures::getDataStructure()));
        $nodes = $xml->xpath('//CodeList');
        $codelist = $this->parser->parseCodesFromNode($nodes[0]);

        $this->assertNotNull($codelist);
        $this->assertEquals(58, count($codelist));

        $this->assertEquals($codelist['AUS'], 'Australia');
        $this->assertEquals($codelist['NAFTA'], 'NAFTA');
    }

    public function testParseCodelist()
    {
        $codelist = $this->parser->parseCodes(V20ParserFixtures::getDataStructure());

        $this->assertNotNull($codelist);
        $this->assertEquals(58, count($codelist));

        $this->assertEquals($codelist['AUS'], 'Australia');
        $this->assertEquals($codelist['NAFTA'], 'NAFTA');
    }
}
