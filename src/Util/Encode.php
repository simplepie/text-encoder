<?php
/**
 * Copyright (c) 2004-2009, 2018 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2005-2010 Geoffrey Sneddon <http://gsnedders.com>
 * Copyright (c) 2004-2018 Contributors.
 *
 * https://opensource.org/licenses/BSD-3-Clause
 */

declare(strict_types=1);

namespace TextEncoder\Util;

/**
 * Normalize the names of the encodings to a simpler set.
 *
 * @see https://www.iana.org/assignments/character-sets/character-sets.xml
 */
class Encode
{
    private function __construct()
    {
    }

    /**
     * Normalizes the name of the character encoding to a simpler set.
     *
     * @param string $charset The original name of the character encoding.
     *
     * @return string
     *
     * @phpcs:disable Generic.Metrics.CyclomaticComplexity.MaxExceeded
     */
    public static function normalize(string $charset): string
    {
        // Normalization from UTS #22
        $cs = \mb_strtolower(\preg_replace('/(?:[^a-zA-Z0-9]+|([^0-9])0+)/', '\1', $charset));

        switch ($cs) {
            case 'adobestandardencoding':
            case 'csadobestandardencoding':
                return 'Adobe-Standard-Encoding';

            case 'adobesymbolencoding':
            case 'cshppsmath':
                return 'Adobe-Symbol-Encoding';

            case 'ami1251':
            case 'amiga1251':
                return 'Amiga-1251';

            case 'ansix31101983':
            case 'csat5001983':
            case 'csiso99naplps':
            case 'isoir99':
            case 'naplps':
                return 'ANSI_X3.110-1983';

            case 'arabic7':
            case 'asmo449':
            case 'csiso89asmo449':
            case 'iso9036':
            case 'isoir89':
                return 'ASMO_449';

            case 'big5':
            case 'csbig5':
                return 'Big5';

            case 'big5hkscs':
                return 'Big5-HKSCS';

            case 'bocu1':
            case 'csbocu1':
                return 'BOCU-1';

            case 'brf':
            case 'csbrf':
                return 'BRF';

            case 'bs4730':
            case 'csiso4unitedkingdom':
            case 'gb':
            case 'iso646gb':
            case 'isoir4':
            case 'uk':
                return 'BS_4730';

            case 'bsviewdata':
            case 'csiso47bsviewdata':
            case 'isoir47':
                return 'BS_viewdata';

            case 'cesu8':
            case 'cscesu8':
                return 'CESU-8';

            case 'ca':
            case 'csa71':
            case 'csaz243419851':
            case 'csiso121canadian1':
            case 'iso646ca':
            case 'isoir121':
                return 'CSA_Z243.4-1985-1';

            case 'csa72':
            case 'csaz243419852':
            case 'csiso122canadian2':
            case 'iso646ca2':
            case 'isoir122':
                return 'CSA_Z243.4-1985-2';

            case 'csaz24341985gr':
            case 'csiso123csaz24341985gr':
            case 'isoir123':
                return 'CSA_Z243.4-1985-gr';

            case 'csiso139csn369103':
            case 'csn369103':
            case 'isoir139':
                return 'CSN_369103';

            case 'csdecmcs':
            case 'dec':
            case 'decmcs':
                return 'DEC-MCS';

            case 'csiso21german':
            case 'de':
            case 'din66003':
            case 'iso646de':
            case 'isoir21':
                return 'DIN_66003';

            case 'csdkus':
            case 'dkus':
                return 'dk-us';

            case 'csiso646danish':
            case 'dk':
            case 'ds2089':
            case 'iso646dk':
                return 'DS_2089';

            case 'csibmebcdicatde':
            case 'ebcdicatde':
                return 'EBCDIC-AT-DE';

            case 'csebcdicatdea':
            case 'ebcdicatdea':
                return 'EBCDIC-AT-DE-A';

            case 'csebcdiccafr':
            case 'ebcdiccafr':
                return 'EBCDIC-CA-FR';

            case 'csebcdicdkno':
            case 'ebcdicdkno':
                return 'EBCDIC-DK-NO';

            case 'csebcdicdknoa':
            case 'ebcdicdknoa':
                return 'EBCDIC-DK-NO-A';

            case 'csebcdices':
            case 'ebcdices':
                return 'EBCDIC-ES';

            case 'csebcdicesa':
            case 'ebcdicesa':
                return 'EBCDIC-ES-A';

            case 'csebcdicess':
            case 'ebcdicess':
                return 'EBCDIC-ES-S';

            case 'csebcdicfise':
            case 'ebcdicfise':
                return 'EBCDIC-FI-SE';

            case 'csebcdicfisea':
            case 'ebcdicfisea':
                return 'EBCDIC-FI-SE-A';

            case 'csebcdicfr':
            case 'ebcdicfr':
                return 'EBCDIC-FR';

            case 'csebcdicit':
            case 'ebcdicit':
                return 'EBCDIC-IT';

            case 'csebcdicpt':
            case 'ebcdicpt':
                return 'EBCDIC-PT';

            case 'csebcdicuk':
            case 'ebcdicuk':
                return 'EBCDIC-UK';

            case 'csebcdicus':
            case 'ebcdicus':
                return 'EBCDIC-US';

            case 'csiso111ecmacyrillic':
            case 'ecmacyrillic':
            case 'isoir111':
            case 'koi8e':
                return 'ECMA-cyrillic';

            case 'csiso17spanish':
            case 'es':
            case 'iso646es':
            case 'isoir17':
                return 'ES';

            case 'csiso85spanish2':
            case 'es2':
            case 'iso646es2':
            case 'isoir85':
                return 'ES2';

            case 'cseucpkdfmtjapanese':
            case 'eucjp':
            case 'extendedunixcodepackedformatforjapanese':
                return 'EUC-JP';

            case 'cseucfixwidjapanese':
            case 'extendedunixcodefixedwidthforjapanese':
                return 'Extended_UNIX_Code_Fixed_Width_for_Japanese';

            case 'gb18030':
                return 'GB18030';

            case 'chinese':
            case 'cp936':
            case 'csgb2312':
            case 'csiso58gb231280':
            case 'gb2312':
            case 'gb231280':
            case 'gbk':
            case 'isoir58':
            case 'ms936':
            case 'windows936':
                return 'GBK';

            case 'cn':
            case 'csiso57gb1988':
            case 'gb198880':
            case 'iso646cn':
            case 'isoir57':
                return 'GB_1988-80';

            case 'csiso153gost1976874':
            case 'gost1976874':
            case 'isoir153':
            case 'stsev35888':
                return 'GOST_19768-74';

            case 'csiso150':
            case 'csiso150greekccitt':
            case 'greekccitt':
            case 'isoir150':
                return 'greek-ccitt';

            case 'csiso88greek7':
            case 'greek7':
            case 'isoir88':
                return 'greek7';

            case 'csiso18greek7old':
            case 'greek7old':
            case 'isoir18':
                return 'greek7-old';

            case 'cshpdesktop':
            case 'hpdesktop':
                return 'HP-DeskTop';

            case 'cshplegal':
            case 'hplegal':
                return 'HP-Legal';

            case 'cshpmath8':
            case 'hpmath8':
                return 'HP-Math8';

            case 'cshppifont':
            case 'hppifont':
                return 'HP-Pi-font';

            case 'cshproman8':
            case 'hproman8':
            case 'r8':
            case 'roman8':
                return 'hp-roman8';

            case 'hzgb2312':
                return 'HZ-GB-2312';

            case 'csibmsymbols':
            case 'ibmsymbols':
                return 'IBM-Symbols';

            case 'csibmthai':
            case 'ibmthai':
                return 'IBM-Thai';

            case 'cp37':
            case 'csibm37':
            case 'ebcdiccpca':
            case 'ebcdiccpnl':
            case 'ebcdiccpus':
            case 'ebcdiccpwt':
            case 'ibm37':
                return 'IBM037';

            case 'cp38':
            case 'csibm38':
            case 'ebcdicint':
            case 'ibm38':
                return 'IBM038';

            case 'cp273':
            case 'csibm273':
            case 'ibm273':
                return 'IBM273';

            case 'cp274':
            case 'csibm274':
            case 'ebcdicbe':
            case 'ibm274':
                return 'IBM274';

            case 'cp275':
            case 'csibm275':
            case 'ebcdicbr':
            case 'ibm275':
                return 'IBM275';

            case 'csibm277':
            case 'ebcdiccpdk':
            case 'ebcdiccpno':
            case 'ibm277':
                return 'IBM277';

            case 'cp278':
            case 'csibm278':
            case 'ebcdiccpfi':
            case 'ebcdiccpse':
            case 'ibm278':
                return 'IBM278';

            case 'cp280':
            case 'csibm280':
            case 'ebcdiccpit':
            case 'ibm280':
                return 'IBM280';

            case 'cp281':
            case 'csibm281':
            case 'ebcdicjpe':
            case 'ibm281':
                return 'IBM281';

            case 'cp284':
            case 'csibm284':
            case 'ebcdiccpes':
            case 'ibm284':
                return 'IBM284';

            case 'cp285':
            case 'csibm285':
            case 'ebcdiccpgb':
            case 'ibm285':
                return 'IBM285';

            case 'cp290':
            case 'csibm290':
            case 'ebcdicjpkana':
            case 'ibm290':
                return 'IBM290';

            case 'cp297':
            case 'csibm297':
            case 'ebcdiccpfr':
            case 'ibm297':
                return 'IBM297';

            case 'cp420':
            case 'csibm420':
            case 'ebcdiccpar1':
            case 'ibm420':
                return 'IBM420';

            case 'cp423':
            case 'csibm423':
            case 'ebcdiccpgr':
            case 'ibm423':
                return 'IBM423';

            case 'cp424':
            case 'csibm424':
            case 'ebcdiccphe':
            case 'ibm424':
                return 'IBM424';

            case '437':
            case 'cp437':
            case 'cspc8codepage437':
            case 'ibm437':
                return 'IBM437';

            case 'cp500':
            case 'csibm500':
            case 'ebcdiccpbe':
            case 'ebcdiccpch':
            case 'ibm500':
                return 'IBM500';

            case 'cp775':
            case 'cspc775baltic':
            case 'ibm775':
                return 'IBM775';

            case '850':
            case 'cp850':
            case 'cspc850multilingual':
            case 'ibm850':
                return 'IBM850';

            case '851':
            case 'cp851':
            case 'csibm851':
            case 'ibm851':
                return 'IBM851';

            case '852':
            case 'cp852':
            case 'cspcp852':
            case 'ibm852':
                return 'IBM852';

            case '855':
            case 'cp855':
            case 'csibm855':
            case 'ibm855':
                return 'IBM855';

            case '857':
            case 'cp857':
            case 'csibm857':
            case 'ibm857':
                return 'IBM857';

            case 'ccsid858':
            case 'cp858':
            case 'ibm858':
            case 'pcmultilingual850euro':
                return 'IBM00858';

            case '860':
            case 'cp860':
            case 'csibm860':
            case 'ibm860':
                return 'IBM860';

            case '861':
            case 'cp861':
            case 'cpis':
            case 'csibm861':
            case 'ibm861':
                return 'IBM861';

            case '862':
            case 'cp862':
            case 'cspc862latinhebrew':
            case 'ibm862':
                return 'IBM862';

            case '863':
            case 'cp863':
            case 'csibm863':
            case 'ibm863':
                return 'IBM863';

            case 'cp864':
            case 'csibm864':
            case 'ibm864':
                return 'IBM864';

            case '865':
            case 'cp865':
            case 'csibm865':
            case 'ibm865':
                return 'IBM865';

            case '866':
            case 'cp866':
            case 'csibm866':
            case 'ibm866':
                return 'IBM866';

            case 'cp868':
            case 'cpar':
            case 'csibm868':
            case 'ibm868':
                return 'IBM868';

            case '869':
            case 'cp869':
            case 'cpgr':
            case 'csibm869':
            case 'ibm869':
                return 'IBM869';

            case 'cp870':
            case 'csibm870':
            case 'ebcdiccproece':
            case 'ebcdiccpyu':
            case 'ibm870':
                return 'IBM870';

            case 'cp871':
            case 'csibm871':
            case 'ebcdiccpis':
            case 'ibm871':
                return 'IBM871';

            case 'cp880':
            case 'csibm880':
            case 'ebcdiccyrillic':
            case 'ibm880':
                return 'IBM880';

            case 'cp891':
            case 'csibm891':
            case 'ibm891':
                return 'IBM891';

            case 'cp903':
            case 'csibm903':
            case 'ibm903':
                return 'IBM903';

            case '904':
            case 'cp904':
            case 'csibbm904':
            case 'ibm904':
                return 'IBM904';

            case 'cp905':
            case 'csibm905':
            case 'ebcdiccptr':
            case 'ibm905':
                return 'IBM905';

            case 'cp918':
            case 'csibm918':
            case 'ebcdiccpar2':
            case 'ibm918':
                return 'IBM918';

            case 'ccsid924':
            case 'cp924':
            case 'ebcdiclatin9euro':
            case 'ibm924':
                return 'IBM00924';

            case 'cp1026':
            case 'csibm1026':
            case 'ibm1026':
                return 'IBM1026';

            case 'ibm1047':
                return 'IBM1047';

            case 'ccsid1140':
            case 'cp1140':
            case 'ebcdicus37euro':
            case 'ibm1140':
                return 'IBM01140';

            case 'ccsid1141':
            case 'cp1141':
            case 'ebcdicde273euro':
            case 'ibm1141':
                return 'IBM01141';

            case 'ccsid1142':
            case 'cp1142':
            case 'ebcdicdk277euro':
            case 'ebcdicno277euro':
            case 'ibm1142':
                return 'IBM01142';

            case 'ccsid1143':
            case 'cp1143':
            case 'ebcdicfi278euro':
            case 'ebcdicse278euro':
            case 'ibm1143':
                return 'IBM01143';

            case 'ccsid1144':
            case 'cp1144':
            case 'ebcdicit280euro':
            case 'ibm1144':
                return 'IBM01144';

            case 'ccsid1145':
            case 'cp1145':
            case 'ebcdices284euro':
            case 'ibm1145':
                return 'IBM01145';

            case 'ccsid1146':
            case 'cp1146':
            case 'ebcdicgb285euro':
            case 'ibm1146':
                return 'IBM01146';

            case 'ccsid1147':
            case 'cp1147':
            case 'ebcdicfr297euro':
            case 'ibm1147':
                return 'IBM01147';

            case 'ccsid1148':
            case 'cp1148':
            case 'ebcdicinternational500euro':
            case 'ibm1148':
                return 'IBM01148';

            case 'ccsid1149':
            case 'cp1149':
            case 'ebcdicis871euro':
            case 'ibm1149':
                return 'IBM01149';

            case 'csiso143iecp271':
            case 'iecp271':
            case 'isoir143':
                return 'IEC_P27-1';

            case 'csiso49inis':
            case 'inis':
            case 'isoir49':
                return 'INIS';

            case 'csiso50inis8':
            case 'inis8':
            case 'isoir50':
                return 'INIS-8';

            case 'csiso51iniscyrillic':
            case 'iniscyrillic':
            case 'isoir51':
                return 'INIS-cyrillic';

            case 'csinvariant':
            case 'invariant':
                return 'INVARIANT';

            case 'iso2022cn':
                return 'ISO-2022-CN';

            case 'iso2022cnext':
                return 'ISO-2022-CN-EXT';

            case 'csiso2022jp':
            case 'iso2022jp':
                return 'ISO-2022-JP';

            case 'csiso2022jp2':
            case 'iso2022jp2':
                return 'ISO-2022-JP-2';

            case 'csiso2022kr':
            case 'iso2022kr':
                return 'ISO-2022-KR';

            case 'cswindows30latin1':
            case 'iso88591windows30latin1':
                return 'ISO-8859-1-Windows-3.0-Latin-1';

            case 'cswindows31latin1':
            case 'iso88591windows31latin1':
                return 'ISO-8859-1-Windows-3.1-Latin-1';

            case 'csisolatin2':
            case 'iso88592':
            case 'iso885921987':
            case 'isoir101':
            case 'l2':
            case 'latin2':
                return 'ISO-8859-2';

            case 'cswindows31latin2':
            case 'iso88592windowslatin2':
                return 'ISO-8859-2-Windows-Latin-2';

            case 'csisolatin3':
            case 'iso88593':
            case 'iso885931988':
            case 'isoir109':
            case 'l3':
            case 'latin3':
                return 'ISO-8859-3';

            case 'csisolatin4':
            case 'iso88594':
            case 'iso885941988':
            case 'isoir110':
            case 'l4':
            case 'latin4':
                return 'ISO-8859-4';

            case 'csisolatincyrillic':
            case 'cyrillic':
            case 'iso88595':
            case 'iso885951988':
            case 'isoir144':
                return 'ISO-8859-5';

            case 'arabic':
            case 'asmo708':
            case 'csisolatinarabic':
            case 'ecma114':
            case 'iso88596':
            case 'iso885961987':
            case 'isoir127':
                return 'ISO-8859-6';

            case 'csiso88596e':
            case 'iso88596e':
                return 'ISO-8859-6-E';

            case 'csiso88596i':
            case 'iso88596i':
                return 'ISO-8859-6-I';

            case 'csisolatingreek':
            case 'ecma118':
            case 'elot928':
            case 'greek':
            case 'greek8':
            case 'iso88597':
            case 'iso885971987':
            case 'isoir126':
                return 'ISO-8859-7';

            case 'csisolatinhebrew':
            case 'hebrew':
            case 'iso88598':
            case 'iso885981988':
            case 'isoir138':
                return 'ISO-8859-8';

            case 'csiso88598e':
            case 'iso88598e':
                return 'ISO-8859-8-E';

            case 'csiso88598i':
            case 'iso88598i':
                return 'ISO-8859-8-I';

            case 'cswindows31latin5':
            case 'iso88599windowslatin5':
                return 'ISO-8859-9-Windows-Latin-5';

            case 'csisolatin6':
            case 'iso885910':
            case 'iso8859101992':
            case 'isoir157':
            case 'l6':
            case 'latin6':
                return 'ISO-8859-10';

            case 'iso885913':
                return 'ISO-8859-13';

            case 'iso885914':
            case 'iso8859141998':
            case 'isoceltic':
            case 'isoir199':
            case 'l8':
            case 'latin8':
                return 'ISO-8859-14';

            case 'iso885915':
            case 'latin9':
                return 'ISO-8859-15';

            case 'iso885916':
            case 'iso8859162001':
            case 'isoir226':
            case 'l10':
            case 'latin10':
                return 'ISO-8859-16';

            case 'iso10646j1':
                return 'ISO-10646-J-1';

            case 'csunicode':
            case 'iso10646ucs2':
                return 'ISO-10646-UCS-2';

            case 'csucs4':
            case 'iso10646ucs4':
                return 'ISO-10646-UCS-4';

            case 'csunicodeascii':
            case 'iso10646ucsbasic':
                return 'ISO-10646-UCS-Basic';

            case 'csunicodelatin1':
            case 'iso10646':
            case 'iso10646unicodelatin1':
                return 'ISO-10646-Unicode-Latin1';

            case 'csiso10646utf1':
            case 'iso10646utf1':
                return 'ISO-10646-UTF-1';

            case 'csiso115481':
            case 'iso115481':
            case 'isotr115481':
                return 'ISO-11548-1';

            case 'csiso90':
            case 'isoir90':
                return 'iso-ir-90';

            case 'csunicodeibm1261':
            case 'isounicodeibm1261':
                return 'ISO-Unicode-IBM-1261';

            case 'csunicodeibm1264':
            case 'isounicodeibm1264':
                return 'ISO-Unicode-IBM-1264';

            case 'csunicodeibm1265':
            case 'isounicodeibm1265':
                return 'ISO-Unicode-IBM-1265';

            case 'csunicodeibm1268':
            case 'isounicodeibm1268':
                return 'ISO-Unicode-IBM-1268';

            case 'csunicodeibm1276':
            case 'isounicodeibm1276':
                return 'ISO-Unicode-IBM-1276';

            case 'csiso646basic1983':
            case 'iso646basic1983':
            case 'ref':
                return 'ISO_646.basic:1983';

            case 'csiso2intlrefversion':
            case 'irv':
            case 'iso646irv1983':
            case 'isoir2':
                return 'ISO_646.irv:1983';

            case 'csiso2033':
            case 'e13b':
            case 'iso20331983':
            case 'isoir98':
                return 'ISO_2033-1983';

            case 'csiso5427cyrillic':
            case 'iso5427':
            case 'isoir37':
                return 'ISO_5427';

            case 'iso5427cyrillic1981':
            case 'iso54271981':
            case 'isoir54':
                return 'ISO_5427:1981';

            case 'csiso5428greek':
            case 'iso54281980':
            case 'isoir55':
                return 'ISO_5428:1980';

            case 'csiso6937add':
            case 'iso6937225':
            case 'isoir152':
                return 'ISO_6937-2-25';

            case 'csisotextcomm':
            case 'iso69372add':
            case 'isoir142':
                return 'ISO_6937-2-add';

            case 'csiso8859supp':
            case 'iso8859supp':
            case 'isoir154':
            case 'latin125':
                return 'ISO_8859-supp';

            case 'csiso10367box':
            case 'iso10367box':
            case 'isoir155':
                return 'ISO_10367-box';

            case 'csiso15italian':
            case 'iso646it':
            case 'isoir15':
            case 'it':
                return 'IT';

            case 'csiso13jisc6220jp':
            case 'isoir13':
            case 'jisc62201969':
            case 'jisc62201969jp':
            case 'katakana':
            case 'x2017':
                return 'JIS_C6220-1969-jp';

            case 'csiso14jisc6220ro':
            case 'iso646jp':
            case 'isoir14':
            case 'jisc62201969ro':
            case 'jp':
                return 'JIS_C6220-1969-ro';

            case 'csiso42jisc62261978':
            case 'isoir42':
            case 'jisc62261978':
                return 'JIS_C6226-1978';

            case 'csiso87jisx208':
            case 'isoir87':
            case 'jisc62261983':
            case 'jisx2081983':
            case 'x208':
                return 'JIS_C6226-1983';

            case 'csiso91jisc62291984a':
            case 'isoir91':
            case 'jisc62291984a':
            case 'jpocra':
                return 'JIS_C6229-1984-a';

            case 'csiso92jisc62991984b':
            case 'iso646jpocrb':
            case 'isoir92':
            case 'jisc62291984b':
            case 'jpocrb':
                return 'JIS_C6229-1984-b';

            case 'csiso93jis62291984badd':
            case 'isoir93':
            case 'jisc62291984badd':
            case 'jpocrbadd':
                return 'JIS_C6229-1984-b-add';

            case 'csiso94jis62291984hand':
            case 'isoir94':
            case 'jisc62291984hand':
            case 'jpocrhand':
                return 'JIS_C6229-1984-hand';

            case 'csiso95jis62291984handadd':
            case 'isoir95':
            case 'jisc62291984handadd':
            case 'jpocrhandadd':
                return 'JIS_C6229-1984-hand-add';

            case 'csiso96jisc62291984kana':
            case 'isoir96':
            case 'jisc62291984kana':
                return 'JIS_C6229-1984-kana';

            case 'csjisencoding':
            case 'jisencoding':
                return 'JIS_Encoding';

            case 'cshalfwidthkatakana':
            case 'jisx201':
            case 'x201':
                return 'JIS_X0201';

            case 'csiso159jisx2121990':
            case 'isoir159':
            case 'jisx2121990':
            case 'x212':
                return 'JIS_X0212-1990';

            case 'csiso141jusib1002':
            case 'iso646yu':
            case 'isoir141':
            case 'js':
            case 'jusib1002':
            case 'yu':
                return 'JUS_I.B1.002';

            case 'csiso147macedonian':
            case 'isoir147':
            case 'jusib1003mac':
            case 'macedonian':
                return 'JUS_I.B1.003-mac';

            case 'csiso146serbian':
            case 'isoir146':
            case 'jusib1003serb':
            case 'serbian':
                return 'JUS_I.B1.003-serb';

            case 'koi7switched':
                return 'KOI7-switched';

            case 'cskoi8r':
            case 'koi8r':
                return 'KOI8-R';

            case 'koi8u':
                return 'KOI8-U';

            case 'csksc5636':
            case 'iso646kr':
            case 'ksc5636':
                return 'KSC5636';

            case 'cskz1048':
            case 'kz1048':
            case 'rk1048':
            case 'strk10482002':
                return 'KZ-1048';

            case 'csiso19latingreek':
            case 'isoir19':
            case 'latingreek':
                return 'latin-greek';

            case 'csiso27latingreek1':
            case 'isoir27':
            case 'latingreek1':
                return 'Latin-greek-1';

            case 'csiso158lap':
            case 'isoir158':
            case 'lap':
            case 'latinlap':
                return 'latin-lap';

            case 'csmacintosh':
            case 'mac':
            case 'macintosh':
                return 'macintosh';

            case 'csmicrosoftpublishing':
            case 'microsoftpublishing':
                return 'Microsoft-Publishing';

            case 'csmnem':
            case 'mnem':
                return 'MNEM';

            case 'csmnemonic':
            case 'mnemonic':
                return 'MNEMONIC';

            case 'csiso86hungarian':
            case 'hu':
            case 'iso646hu':
            case 'isoir86':
            case 'msz77953':
                return 'MSZ_7795.3';

            case 'csnatsdano':
            case 'isoir91':
            case 'natsdano':
                return 'NATS-DANO';

            case 'csnatsdanoadd':
            case 'isoir92':
            case 'natsdanoadd':
                return 'NATS-DANO-ADD';

            case 'csnatssefi':
            case 'isoir81':
            case 'natssefi':
                return 'NATS-SEFI';

            case 'csnatssefiadd':
            case 'isoir82':
            case 'natssefiadd':
                return 'NATS-SEFI-ADD';

            case 'csiso151cuba':
            case 'cuba':
            case 'iso646cu':
            case 'isoir151':
            case 'ncnc1081':
                return 'NC_NC00-10:81';

            case 'csiso69french':
            case 'fr':
            case 'iso646fr':
            case 'isoir69':
            case 'nfz62010':
                return 'NF_Z_62-010';

            case 'csiso25french':
            case 'iso646fr1':
            case 'isoir25':
            case 'nfz620101973':
                return 'NF_Z_62-010_(1973)';

            case 'csiso60danishnorwegian':
            case 'csiso60norwegian1':
            case 'iso646no':
            case 'isoir60':
            case 'no':
            case 'ns45511':
                return 'NS_4551-1';

            case 'csiso61norwegian2':
            case 'iso646no2':
            case 'isoir61':
            case 'no2':
            case 'ns45512':
                return 'NS_4551-2';

            case 'osdebcdicdf3irv':
                return 'OSD_EBCDIC_DF03_IRV';

            case 'osdebcdicdf41':
                return 'OSD_EBCDIC_DF04_1';

            case 'osdebcdicdf415':
                return 'OSD_EBCDIC_DF04_15';

            case 'cspc8danishnorwegian':
            case 'pc8danishnorwegian':
                return 'PC8-Danish-Norwegian';

            case 'cspc8turkish':
            case 'pc8turkish':
                return 'PC8-Turkish';

            case 'csiso16portuguese':
            case 'iso646pt':
            case 'isoir16':
            case 'pt':
                return 'PT';

            case 'csiso84portuguese2':
            case 'iso646pt2':
            case 'isoir84':
            case 'pt2':
                return 'PT2';

            case 'cp154':
            case 'csptcp154':
            case 'cyrillicasian':
            case 'pt154':
            case 'ptcp154':
                return 'PTCP154';

            case 'scsu':
                return 'SCSU';

            case 'csiso10swedish':
            case 'fi':
            case 'iso646fi':
            case 'iso646se':
            case 'isoir10':
            case 'se':
            case 'sen850200b':
                return 'SEN_850200_B';

            case 'csiso11swedishfornames':
            case 'iso646se2':
            case 'isoir11':
            case 'se2':
            case 'sen850200c':
                return 'SEN_850200_C';

            case 'csiso102t617bit':
            case 'isoir102':
            case 't617bit':
                return 'T.61-7bit';

            case 'csiso103t618bit':
            case 'isoir103':
            case 't61':
            case 't618bit':
                return 'T.61-8bit';

            case 'csiso128t101g2':
            case 'isoir128':
            case 't101g2':
                return 'T.101-G2';

            case 'cstscii':
            case 'tscii':
                return 'TSCII';

            case 'csunicode11':
            case 'unicode11':
                return 'UNICODE-1-1';

            case 'csunicode11utf7':
            case 'unicode11utf7':
                return 'UNICODE-1-1-UTF-7';

            case 'csunknown8bit':
            case 'unknown8bit':
                return 'UNKNOWN-8BIT';

            case 'ansix341968':
            case 'ansix341986':
            case 'ascii':
            case 'cp367':
            case 'csascii':
            case 'ibm367':
            case 'iso646irv1991':
            case 'iso646us':
            case 'isoir6':
            case 'us':
            case 'usascii':
                return 'US-ASCII';

            case 'csusdk':
            case 'usdk':
                return 'us-dk';

            case 'utf7':
                return 'UTF-7';

            case 'utf8':
                return 'UTF-8';

            case 'utf16':
                return 'UTF-16';

            case 'utf16be':
                return 'UTF-16BE';

            case 'utf16le':
                return 'UTF-16LE';

            case 'utf32':
                return 'UTF-32';

            case 'utf32be':
                return 'UTF-32BE';

            case 'utf32le':
                return 'UTF-32LE';

            case 'csventurainternational':
            case 'venturainternational':
                return 'Ventura-International';

            case 'csventuramath':
            case 'venturamath':
                return 'Ventura-Math';

            case 'csventuraus':
            case 'venturaus':
                return 'Ventura-US';

            case 'csiso70videotexsupp1':
            case 'isoir70':
            case 'videotexsuppl':
                return 'videotex-suppl';

            case 'csviqr':
            case 'viqr':
                return 'VIQR';

            case 'csviscii':
            case 'viscii':
                return 'VISCII';

            case 'csshiftjis':
            case 'cswindows31j':
            case 'mskanji':
            case 'shiftjis':
            case 'windows31j':
                return 'Windows-31J';

            case 'iso885911':
            case 'tis620':
                return 'windows-874';

            case 'cseuckr':
            case 'csksc56011987':
            case 'euckr':
            case 'isoir149':
            case 'korean':
            case 'ksc5601':
            case 'ksc56011987':
            case 'ksc56011989':
            case 'windows949':
                return 'windows-949';

            case 'windows1250':
                return 'windows-1250';

            case 'windows1251':
                return 'windows-1251';

            case 'cp819':
            case 'csisolatin1':
            case 'ibm819':
            case 'iso88591':
            case 'iso885911987':
            case 'isoir100':
            case 'l1':
            case 'latin1':
            case 'windows1252':
                return 'windows-1252';

            case 'windows1253':
                return 'windows-1253';

            case 'csisolatin5':
            case 'iso88599':
            case 'iso885991989':
            case 'isoir148':
            case 'l5':
            case 'latin5':
            case 'windows1254':
                return 'windows-1254';

            case 'windows1255':
                return 'windows-1255';

            case 'windows1256':
                return 'windows-1256';

            case 'windows1257':
                return 'windows-1257';

            case 'windows1258':
                return 'windows-1258';

            default:
                return $charset;
        }
    }

    // @phpcs:enable
}
