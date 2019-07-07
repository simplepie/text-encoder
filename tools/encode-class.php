#! /usr/bin/env php
<?php
declare(strict_types=1);

require_once \dirname(__DIR__) . '/vendor/autoload.php';

// Twig bootstrapping
$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig   = new Twig_Environment($loader, [
    'debug'            => true,
    'charset'          => 'utf-8',
    'cache'            => '/tmp',
    'auto_reload'      => true,
    'strict_variables' => true,
    'optimizations'    => -1,
]);
$twig->addExtension(new Twig_Extension_Debug());

$twig->addFunction(new Twig_Function('timestamp', static function () {
    return \str_replace('+00:00', 'Z', \gmdate(\DATE_ATOM));
}));

//------------------------------------------------------------------------------

function normalize_character_set($cs): string
{
    if ($cs instanceof DOMNode) {
        $cs = $cs->nodeValue;
    }

    $cs = \trim($cs);
    \preg_match('/^([^\s]+)/S', $cs, $m);
    $cs = \preg_replace('/(?:[^a-zA-Z0-9]+|([^0-9])0+)/', '$1', $m[1]);

    return \mb_strtolower($cs);
}

//------------------------------------------------------------------------------

\define('NS', 'http://www.iana.org/assignments');

// Read file into memory
$rawDocument = \file_get_contents(\dirname(__DIR__) . '/resources/iana-character-sets.xml');

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

//------------------------------------------------------------------------------

// Read file into memory
$rawDocument = \file_get_contents(\dirname(__DIR__) . '/resources/whatwg-encodings.json');
$rawDocument = \json_decode($rawDocument, true);

foreach ($rawDocument as $encodings) {
    foreach ($encodings['encodings'] as $set) {
        if ('replacement' !== $set['name']) {
            foreach ($set['labels'] as $label) {
                $registry[normalize_character_set($label)] = $set['name'];
            }
        }
    }
}

//------------------------------------------------------------------------------

$newRegistry    = \array_unique(\array_values($registry));
$knownEncodings = \array_flip(\mb_list_encodings());

foreach ($newRegistry as $enc) {
    if (isset($knownEncodings[$enc])) {
        $aliases = \mb_encoding_aliases($enc);

        foreach ($aliases as $alias) {
            $registry[normalize_character_set($alias)] = $enc;
        }
    }
}

//------------------------------------------------------------------------------

// Customize
$registry['ascii']   = 'US-ASCII';
$registry['euckr']   = 'windows-949';
$registry['usascii'] = 'US-ASCII';

foreach ($registry as $k => $v) {
    if (isset($registry[normalize_character_set($v)])) {
        $registry[$k] = $registry[normalize_character_set($v)];
    }
}

// Alphabetize the hashmap for readability
\uksort($registry, 'strnatcasecmp');

//-------------------------------------------------------------------------------
// Entity.php

$template = $twig->load('Encode.php.twig');
$output   = $template->render([
    'encodings' => $registry,
]);

$writePath = \sprintf(
    '%s/Encode.php',
    \dirname(__DIR__) . '/src/Util'
);

\file_put_contents($writePath, $output);
