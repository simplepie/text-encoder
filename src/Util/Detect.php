<?php
/**
 * Copyright (c) 2018-2019 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2018-2019 Contributors
 *
 * http://opensource.org/licenses/Apache2.0
 */

declare(strict_types=1);

namespace TextEncoder\Util;

use DOMDocument;
use SimplePie\UtilityPack\Mixin\DomDocumentTrait;
use SimplePie\UtilityPack\Mixin\LibxmlTrait;
use SimplePie\UtilityPack\Mixin\LoggerTrait;
use SimplePie\UtilityPack\Mixin\RawDocumentTrait;

class Detect
{
    use DomDocumentTrait;
    use RawDocumentTrait;
    use LibxmlTrait;
    use LoggerTrait;

    /**
     * @var string[]
     */
    protected $encodings = [];

    /**
     * Constructs a new instance of this class.
     *
     * @param string $rawDocument The raw content of the document.
     */
    public function __construct(string $rawDocument)
    {
        $this->rawDocument = $rawDocument;
    }

    /**
     * Reads the value of the XML prologue, if it exists.
     *
     * @param ?string $xml
     *
     * @return string|null The value of the XML prologue, or null.
     */
    public function getXmlPrologue(?string $xml = null): ?string
    {
        $xml = $xml ?: $this->rawDocument;

        $this->domDocument = new DOMDocument('1.0');

        // Don't barf errors all over the output
        \libxml_use_internal_errors(true);

        $this->getDefaultDomConfig($this->domDocument);
        $this->domDocument->loadXML($xml, $this->getDefaultLibxmlConfig());

        // Clear the libxml errors to avoid excessive memory usage
        \libxml_clear_errors();

        return $this->domDocument->encoding;
    }

    /**
     * Detect XML encoding, as per XML 1.0 Appendix F.1.
     *
     * Whereas:
     * - 8-bit would be `\x3C` (1 byte)
     * - 16-bit would be `\x00\x3C` (2 bytes)
     * - 32-bit would be `\x00\x00\x00\x3C` (4 bytes)
     *
     * @return string[]
     *
     * @see https://www.w3.org/TR/xml/#sec-guessing-no-ext-info
     * @see https://tools.ietf.org/html/rfc3023
     *
     * @phpcs:disable Generic.Metrics.CyclomaticComplexity.MaxExceeded
     */
    public function detectXmlEncodings(): array
    {
        $template = '<?xml%s?>';

        if ("\x00\x00\xFE\xFF" === \mb_substr($this->rawDocument, 0, 4)) {
            // UTF-32 Big Endian BOM
            $this->encodings[] = 'UTF-32BE';
        } elseif ("\xFF\xFE\x00\x00" === \mb_substr($this->rawDocument, 0, 4)) {
            // UTF-32 Little Endian BOM
            $this->encodings[] = 'UTF-32LE';
        } elseif ("\xFE\xFF" === \mb_substr($this->rawDocument, 0, 2)) {
            // UTF-16 Big Endian BOM
            $this->encodings[] = 'UTF-16BE';
        } elseif ("\xFF\xFE" === \mb_substr($this->rawDocument, 0, 2)) {
            // UTF-16 Little Endian BOM
            $this->encodings[] = 'UTF-16LE';
        } elseif ("\xEF\xBB\xBF" === \mb_substr($this->rawDocument, 0, 3)) {
            // UTF-8 BOM
            $this->encodings[] = 'UTF-8';
        } elseif ("\x00\x00\x00\x3C\x00\x00\x00\x3F\x00\x00\x00\x78\x00\x00\x00\x6D\x00\x00\x00\x6C" === \mb_substr($this->rawDocument, 0, 20)) { // phpcs:ignore Generic.Files.LineLength.MaxExceeded
            // UTF-32 Big Endian Without BOM
            $pos = \mb_strpos($this->rawDocument, "\x00\x00\x00\x3F\x00\x00\x00\x3E");

            if (false !== $pos) {
                $enc = $this->getXmlPrologue(\sprintf(
                    $template,
                    \mb_substr($this->rawDocument, 20, $pos - 20)
                ));

                // No `encoding` in prologue
                if ($enc) {
                    $this->encodings[] = $enc;
                }
            }

            $this->encodings[] = 'UTF-32BE';
        } elseif ("\x3C\x00\x00\x00\x3F\x00\x00\x00\x78\x00\x00\x00\x6D\x00\x00\x00\x6C\x00\x00\x00" === \mb_substr($this->rawDocument, 0, 20)) { // phpcs:ignore Generic.Files.LineLength.MaxExceeded
            // UTF-32 Little Endian Without BOM
            $pos = \mb_strpos($this->rawDocument, "\x3F\x00\x00\x00\x3E\x00\x00\x00");

            if (false !== $pos) {
                $enc = $this->getXmlPrologue(\sprintf(
                    $template,
                    \mb_substr($this->rawDocument, 20, $pos - 20)
                ));

                // No `encoding` in prologue
                if ($enc) {
                    $this->encodings[] = $enc;
                }
            }

            $this->encodings[] = 'UTF-32LE';
        } elseif ("\x00\x3C\x00\x3F\x00\x78\x00\x6D\x00\x6C" === \mb_substr($this->rawDocument, 0, 10)) {
            // UTF-16 Big Endian Without BOM
            $pos = \mb_strpos($this->rawDocument, "\x00\x3F\x00\x3E");

            if (false !== $pos) {
                $enc = $this->getXmlPrologue(\sprintf(
                    $template,
                    \mb_substr($this->rawDocument, 20, $pos - 10)
                ));

                // No `encoding` in prologue
                if ($enc) {
                    $this->encodings[] = $enc;
                }
            }

            $this->encodings[] = 'UTF-16BE';
        } elseif ("\x3C\x00\x3F\x00\x78\x00\x6D\x00\x6C\x00" === \mb_substr($this->rawDocument, 0, 10)) {
            // UTF-16 Little Endian Without BOM
            $pos = \mb_strpos($this->rawDocument, "\x3F\x00\x3E\x00");

            if (false !== $pos) {
                $enc = $this->getXmlPrologue(\sprintf(
                    $template,
                    \mb_substr($this->rawDocument, 20, $pos - 10)
                ));

                // No `encoding` in prologue
                if ($enc) {
                    $this->encodings[] = $enc;
                }
            }

            $this->encodings[] = 'UTF-16LE';
        } elseif ("\x3C\x3F\x78\x6D\x6C" === \mb_substr($this->rawDocument, 0, 5)) {
            // US-ASCII (or superset)
            $pos = \mb_strpos($this->rawDocument, "\x3F\x3E");

            if (false !== $pos) {
                $enc = $this->getXmlPrologue(\sprintf(
                    $template,
                    \mb_substr($this->rawDocument, 5, $pos - 5)
                ));

                // No `encoding` in prologue
                if ($enc) {
                    $this->encodings[] = $enc;
                }
            }

            $this->encodings[] = 'UTF-8';
        } else {
            // Fallback to UTF-8
            $this->encodings[] = 'UTF-8';
        }

        return $this->encodings;
    }

    // @phpcs:enable
}
