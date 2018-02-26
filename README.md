# TextEncoder

An implementation of the [WHATWG Encoding Specification](https://encoding.spec.whatwg.org) in PHP.

> The UTF-8 encoding is the most appropriate encoding for interchange of Unicode, the universal coded character set.

We agree with this statement. The goal of this project is to detect the current encoding of a string or document. If it isn't UTF-8, make it easy to convert to UTF-8.

## Coding Standards

PSR-1/2/12 are a solid foundation, but are not an entire coding style by themselves. By leveraging tools such as [PHP CS Fixer](http://cs.sensiolabs.org) and [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer), we can automate a large part of our style requirements. The things that we cannot yet automate are documented here:

<https://github.com/simplepie/simplepie-ng-coding-standards>
