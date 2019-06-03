<?php
/**
 * Copyright (c) 2018-2019 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2018-2019 Contributors
 *
 * http://opensource.org/licenses/Apache2.0
 */

declare(strict_types=1);

namespace TextEncoder\Util;

class XmlDeclarationParser
{
    /**
     * XML Version.
     *
     * @var string
     */
    public $version = '1.0';

    /**
     * Encoding.
     *
     * @var string
     */
    public $encoding = 'UTF-8';

    /**
     * Standalone.
     *
     * @var bool
     */
    public $standalone = false;

    /**
     * Current state of the state machine.
     *
     * @var string
     */
    public $state = 'beforeVersionName';

    /**
     * Input data.
     *
     * @var string
     */
    public $data = '';

    /**
     * Input data length (to avoid calling strlen() everytime this is needed).
     *
     * @var int
     */
    public $data_length = 0;

    /**
     * Current position of the pointer.
     *
     * @var int
     */
    public $position = 0;

    /**
     * Create an instance of the class with the input data.
     *
     * @param string $data Input data
     */
    public function __construct($data)
    {
        $this->data        = $data;
        $this->data_length = \mb_strlen($this->data);
    }

    /**
     * Parse the input data.
     *
     * @return bool A value of `true` means that the parsing was successful.
     *              A value of `false` means that the parsing was unsuccessful.
     */
    public function parse(): bool
    {
        while ($this->state && 'emit' !== $this->state && $this->hasData()) {
            $state = $this->state;
            $this->{$state}();
        }

        $this->data = '';

        if ('emit' === $this->state) {
            return true;
        }

        $this->version    = '';
        $this->encoding   = '';
        $this->standalone = '';

        return false;
    }

    /**
     * Check whether there is data beyond the pointer.
     *
     * @return bool A value of `true` means that there is additional data to parse.
     *              A value of `false` means that there is no more data to parse.
     */
    public function hasData(): bool
    {
        return $this->position < $this->data_length;
    }

    /**
     * Advance past any whitespace while parsing.
     *
     * @return int The number of whitespace characters that were passed.
     */
    public function skipWhitespace(): int
    {
        $whitespace = \strspn($this->data, "\x09\x0A\x0D\x20", $this->position);
        $this->position += $whitespace;

        return $whitespace;
    }

    /**
     * Read the value.
     */
    public function getValue(): ?string
    {
        $quote = \mb_substr($this->data, $this->position, 1);

        if ('"' === $quote || "'" === $quote) {
            $this->position++;
            $len = \strcspn($this->data, $quote, $this->position);

            if ($this->hasData()) {
                $value = \mb_substr($this->data, $this->position, $len);
                $this->position += $len + 1;

                return $value;
            }
        }

        return null;
    }

    public function beforeVersionName(): void
    {
        if ($this->skipWhitespace()) {
            $this->state = 'versionName';
        } else {
            $this->state = false;
        }
    }

    public function versionName(): void
    {
        if ('version' === \mb_substr($this->data, $this->position, 7)) {
            $this->position += 7;
            $this->skipWhitespace();
            $this->state = 'versionEquals';
        } else {
            $this->state = false;
        }
    }

    public function versionEquals(): void
    {
        if ('=' === \mb_substr($this->data, $this->position, 1)) {
            $this->position++;
            $this->skipWhitespace();
            $this->state = 'versionValue';
        } else {
            $this->state = false;
        }
    }

    public function versionValue(): void
    {
        $this->version = $this->getValue();

        if ($this->version) {
            $this->skipWhitespace();

            if ($this->hasData()) {
                $this->state = 'encodingName';
            } else {
                $this->state = 'emit';
            }
        } else {
            $this->state = false;
        }
    }

    public function encodingName(): void
    {
        if ('encoding' === \mb_substr($this->data, $this->position, 8)) {
            $this->position += 8;
            $this->skipWhitespace();
            $this->state = 'encodingEquals';
        } else {
            $this->state = 'standaloneName';
        }
    }

    public function encodingEquals(): void
    {
        if ('=' === \mb_substr($this->data, $this->position, 1)) {
            $this->position++;
            $this->skipWhitespace();
            $this->state = 'encodingValue';
        } else {
            $this->state = false;
        }
    }

    public function encodingValue(): void
    {
        $this->encoding = $this->getValue();

        if ($this->encoding) {
            $this->skipWhitespace();

            if ($this->hasData()) {
                $this->state = 'standaloneName';
            } else {
                $this->state = 'emit';
            }
        } else {
            $this->state = false;
        }
    }

    public function standaloneName(): void
    {
        if ('standalone' === \mb_substr($this->data, $this->position, 10)) {
            $this->position += 10;
            $this->skipWhitespace();
            $this->state = 'standaloneEquals';
        } else {
            $this->state = false;
        }
    }

    public function standaloneEquals(): void
    {
        if ('=' === \mb_substr($this->data, $this->position, 1)) {
            $this->position++;
            $this->skipWhitespace();
            $this->state = 'standaloneValue';
        } else {
            $this->state = false;
        }
    }

    public function standaloneValue(): void
    {
        $standalone = $this->getValue();

        if ($standalone) {
            switch ($standalone) {
                case 'yes':
                    $this->standalone = true;

                    break;

                case 'no':
                    $this->standalone = false;

                    break;

                default:
                    $this->state = false;

                    return;
            }

            $this->skipWhitespace();

            if ($this->hasData()) {
                $this->state = false;
            } else {
                $this->state = 'emit';
            }
        } else {
            $this->state = false;
        }
    }
}
