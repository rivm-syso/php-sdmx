<?php

namespace Sdmx\Tests\api\parser\v21;


use PHPUnit\Framework\TestCase;
use Sdmx\api\parser\CodelistParser;
use Sdmx\api\parser\ParserUtils;
use Sdmx\api\parser\v21\V21CodelistParser;


class V21CodelistParserTest extends TestCase
{
    /**
     * @var CodelistParser $codelistParser
     */
    private $codelistParser;

    public function testParseCodelistNode()
    {
        $data = new \SimpleXMLElement(ParserUtils::removeNamespaces(V21ParserFixtures::getCodelist()));
        $node = $data->xpath('//Structure/Structures/Codelists/Codelist')[0];
        $codelist = $this->codelistParser->parseCodesFromNode($node);

        $this->assertSame('Zero', $codelist['0']);
        $this->assertSame('Fifteen', $codelist['15']);
    }

    public function testParseCodelistResponse()
    {
        $codelist = $this->codelistParser->parseCodes(V21ParserFixtures::getCodelist());

        $this->assertSame('Zero', $codelist['0']);
        $this->assertSame('Fifteen', $codelist['15']);
    }

    protected function setUp():void
    {
        $this->codelistParser = new V21CodelistParser();
    }

}
