#! /usr/bin/env php
<?php
declare(strict_types=1);

function normalize_character_set(DOMNode $cs): string
{
    $cs = \trim($cs->nodeValue);
    \preg_match('/^([^\s]+)/S', $cs, $m);
    $cs = \preg_replace('/(?:[^a-zA-Z0-9]+|([^0-9])0+)/', '$1', $m[1]);

    return \mb_strtolower($cs);
}

\define('NS', 'http://www.iana.org/assignments');

// Read file into memory
$rawDocument = \file_get_contents(\dirname(__DIR__) . '/resources/character-sets.xml');

// DOMDocument
$domDocument = new DOMDocument('1.0', 'utf-8');

// Don't barf errors all over the output
\libxml_use_internal_errors(true);

// DOMDocument configuration
$domDocument->recover             = true;
$domDocument->formatOutput        = false;
$domDocument->preserveWhiteSpace  = false;
$domDocument->resolveExternals    = true;
$domDocument->substituteEntities  = true;
$domDocument->strictErrorChecking = false;
$domDocument->validateOnParse     = false;

// XML/HTML processing rules
$libxml = \LIBXML_HTML_NOIMPLIED // Required, or things crash.
    | \LIBXML_BIGLINES
    | \LIBXML_COMPACT
    | \LIBXML_HTML_NODEFDTD
    | \LIBXML_NOBLANKS
    | \LIBXML_NOENT
    | \LIBXML_NOXMLDECL
    | \LIBXML_NSCLEAN
    | \LIBXML_PARSEHUGE;

// Parse the XML document with the configured libxml options
$domDocument->loadXML($rawDocument, $libxml);

// Clear the libxml errors to avoid excessive memory usage
\libxml_clear_errors();

/** @var DOMXpath */
$xpath = new DOMXpath($domDocument);
$xpath->registerNamespace('ns', NS);

/** @var DOMNodeList */
$records = $xpath->query('/ns:registry/ns:registry/ns:record');

// Keep track of what we find
$registry = [];

// The original switch-case statement from SimplePie "Classic" worked, but was algorithmically inefficient as the lookup
// always started at the top of the stack then worked its way down the list. It was also sorted alphabetically (for
// humans) as opposed to being sorted as most-likely-to-least-likely (for machines). Can't remember why we did it that
// way (although, honestly, we just didn't know any better at the time). Anyway, this implementation is a straight-up
// hashmap lookup. Should be much faster, as it adds almost no overhead on top of PHP's internal implementation of
// associative arrays.
foreach ($records as $record) {
    // $record is a DOMElement object

    $default   = null;
    $preferred = null;

    // The <name> will be the default value, unless there is a <preferred_alias>.
    $name = $record->getElementsByTagNameNS(NS, 'name');

    if (\count($name) > 0) {
        $default = \trim($name->item(0)->nodeValue);
    }

    // The <preferred_alias>.
    $preferredAlias = $record->getElementsByTagNameNS(NS, 'preferred_alias');

    if (\count($preferredAlias) > 0) {
        $preferred = \trim($preferredAlias->item(0)->nodeValue);
    }

    // Use <preferred_alias> if it exists, otherwise use <name>.
    $setTo = $preferred ?: $default;

    // Lookup all of the normal <alias> elements, and add them to the registry.
    $aliases = $record->getElementsByTagNameNS(NS, 'alias');

    if (\count($aliases) > 0) {
        foreach ($aliases as $alias) {
            $cs            = normalize_character_set($alias);
            $registry[$cs] = $setTo;
        }
    }

    // Normalize the <name> element and set that to the correct value.
    $registry[normalize_character_set($name->item(0))] = $setTo;

    // Normalize the <preferred_alias> element and set that to the correct value.
    if ($preferred) {
        $registry[normalize_character_set($preferredAlias->item(0))] = $setTo;
    }
}

// Customizations
$customize = [
    'Shift_JIS' => [
        'SJIS',
    ],
    'US-ASCII' => [
        'ascii',
    ],
];

// Alphabetize the hashmap for readability
\uksort($registry, 'strnatcasecmp');

\print_r($registry);

// 'EUC-KR'         => 'windows-949',
// 'GB2312'         => 'GBK',
// 'GB_2312-80'     => 'GBK',
// 'ISO-8859-1'     => 'windows-1252',
// 'ISO-8859-9'     => 'windows-1254',
// 'ISO-8859-11'    => 'windows-874',
// 'KS_C_5601-1987' => 'windows-949',
// 'Shift_JIS'      => 'Windows-31J',
// 'TIS-620'        => 'windows-874',
