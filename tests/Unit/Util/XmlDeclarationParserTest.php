<?php
/**
 * Copyright (c) 2018-2019 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2018-2019 Contributors
 *
 * http://opensource.org/licenses/Apache2.0
 */

declare(strict_types=1);

namespace TextEncoder\Test\Unit\Util;

use TextEncoder\Test\Unit\AbstractTestCase;
use TextEncoder\Util\XmlDeclarationParser;

class XmlDeclarationParserTest extends AbstractTestCase
{
    public function xmlProvider()
    {
        $files = \glob(__DIR__ . '/fixtures/*.xml');

        foreach ($files as $file) {
            yield [\file_get_contents($file)];
        }
    }

    /**
     * @dataProvider xmlProvider
     */
    public function testDeclaration(string $xml): void
    {
        $parser = new XmlDeclarationParser($xml);
        $parser->parse();

        static::assertSame('utf-8', $parser->encodingValue());
    }
}
