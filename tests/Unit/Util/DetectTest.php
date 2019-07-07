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
use TextEncoder\Util\Detect;
use TextEncoder\Util\Encode;

class DetectTest extends AbstractTestCase
{
    //--------------------------------------------------------------------------
    // Parse XML Prologue

    public function testEncoding01(): void
    {
        $xml    = \file_get_contents(__DIR__ . '/fixtures/encoding-01.xml');
        $detect = new Detect($xml);

        static::assertSame('euc-jp', $detect->getXmlPrologue());
    }

    public function testEncoding01translate(): void
    {
        $xml    = \file_get_contents(__DIR__ . '/fixtures/encoding-01.xml');
        $detect = new Detect($xml);

        static::assertSame('EUC-JP', Encode::normalize($detect->getXmlPrologue()));
    }

    public function testEncoding02(): void
    {
        $xml    = \file_get_contents(__DIR__ . '/fixtures/encoding-02.xml');
        $detect = new Detect($xml);

        static::assertSame('ISO-8859-1', $detect->getXmlPrologue());
    }

    public function testEncoding02translate(): void
    {
        $xml    = \file_get_contents(__DIR__ . '/fixtures/encoding-02.xml');
        $detect = new Detect($xml);

        static::assertSame('windows-1252', Encode::normalize($detect->getXmlPrologue()));
    }

    public function testEncoding03(): void
    {
        $xml    = \file_get_contents(__DIR__ . '/fixtures/encoding-03.xml');
        $detect = new Detect($xml);

        static::assertSame('utf-8', $detect->getXmlPrologue());
    }

    public function testEncoding03translate(): void
    {
        $xml    = \file_get_contents(__DIR__ . '/fixtures/encoding-03.xml');
        $detect = new Detect($xml);

        static::assertSame('UTF-8', Encode::normalize($detect->getXmlPrologue()));
    }

    public function testNoPrologue01(): void
    {
        $xml    = \file_get_contents(__DIR__ . '/fixtures/no-prologue-01.xml');
        $detect = new Detect($xml);

        static::assertNull($detect->getXmlPrologue());
    }

    public function testRoot01(): void
    {
        $xml    = \file_get_contents(__DIR__ . '/fixtures/root-01.xml');
        $detect = new Detect($xml);

        static::assertNull($detect->getXmlPrologue());
    }

    public function testSpaces01(): void
    {
        $xml    = \file_get_contents(__DIR__ . '/fixtures/spaces-01.xml');
        $detect = new Detect($xml);

        static::assertSame('utf-8', $detect->getXmlPrologue());
    }

    public function testStandalone01(): void
    {
        $xml    = \file_get_contents(__DIR__ . '/fixtures/standalone-01.xml');
        $detect = new Detect($xml);

        static::assertNull($detect->getXmlPrologue());
    }

    //--------------------------------------------------------------------------
    // Detect UTF-32

    public function testDetectUtf32BeBom(): void
    {
        $xml = "\x00\x00\xFE\xFF" . '<?xml version="1.0"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-32BE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf32BeNoBom(): void
    {
        $xml = "\x00\x00\x00\x3C\x00\x00\x00\x3F\x00\x00\x00\x78\x00\x00\x00\x6D\x00\x00\x00\x6C" .
            '<?xml version="1.0"?><feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-32BE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf32BeNoBom2(): void
    {
        $xml = "\x00\x00\x00\x3C\x00\x00\x00\x3F\x00\x00\x00\x78\x00\x00\x00\x6D\x00\x00\x00\x6C" .
            '<?xml version="1.0"?><feed xmlns="http://www.w3.org/2005/Atom">' .
            "\x00\x00\x00\x3F\x00\x00\x00\x3E" .
            '</feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-32BE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf32BeBoth(): void
    {
        $xml = "\x00\x00\xFE\xFF" . '<?xml version="1.0" encoding="UTF-32BE"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-32BE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf32Be(): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-32BE"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-32BE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf32LeBom(): void
    {
        $xml = "\xFF\xFE\x00\x00" . '<?xml version="1.0"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-32LE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf32LeNoBom(): void
    {
        $xml = "\x3C\x00\x00\x00\x3F\x00\x00\x00\x78\x00\x00\x00\x6D\x00\x00\x00\x6C\x00\x00\x00" .
            '<?xml version="1.0"?><feed xmlns="http://www.w3.org/2005/Atom">' .
            "\x3F\x00\x00\x00\x3E\x00\x00\x00" .
            '</feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-32LE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf32LeBoth(): void
    {
        $xml = "\xFF\xFE\x00\x00" . '<?xml version="1.0" encoding="UTF-32LE"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-32LE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf32Le(): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-32LE"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-32LE', $detect->detectXmlEncodings()[0]);
    }

    //--------------------------------------------------------------------------
    // Detect UTF-16

    public function testDetectUtf16BeBom(): void
    {
        $xml = "\xFE\xFF" . '<?xml version="1.0"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-16BE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf16BeBoth(): void
    {
        $xml = "\xFE\xFF" . '<?xml version="1.0" encoding="UTF-16BE"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-16BE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf16Be(): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-16BE"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-16BE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf16LeBom(): void
    {
        $xml = "\xFF\xFE" . '<?xml version="1.0"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-16LE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf16LeBoth(): void
    {
        $xml = "\xFF\xFE" . '<?xml version="1.0" encoding="UTF-16LE"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-16LE', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf16Le(): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-16LE"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-16LE', $detect->detectXmlEncodings()[0]);
    }

    //--------------------------------------------------------------------------
    // Detect UTF-8

    public function testDetectUtf8Bom(): void
    {
        $xml = "\xEF\xBB\xBF" . '<?xml version="1.0"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-8', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf8Both(): void
    {
        $xml = "\xEF\xBB\xBF" . '<?xml version="1.0" encoding="UTF-8"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-8', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf8(): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-8', $detect->detectXmlEncodings()[0]);
    }

    public function testDetectUtf8NoIndicators(): void
    {
        $xml = '<?xml version="1.0"?>
            <feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $detect = new Detect($xml);

        static::assertSame('UTF-8', $detect->detectXmlEncodings()[0]);
    }
}
