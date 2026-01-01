# PHP Info

Wraps the `phpinfo` function and provides a more structured output format using HTML, TEXT, and JSON.
Supports all PHP versions from 5.4 onwards.
Smoke tested with all PHP versions on latest Ubuntu.

## Installation

~~~bash
composer require tebe/phpinfo
~~~

## Usage

**Web with HTML output**

~~~php
<?php

require dirname(__DIR__) . '/vendor/autoload.php';

tebe\phpinfo();
~~~ 

**CLI with different text outputs**

Text output

~~~bash
./vendor/bin/phpinfo
./vendor/bin/phpinfo --text
~~~

JSON output

~~~bash
./vendor/bin/phpinfo --json
~~~

Credits to https://www.reddit.com/user/HolyGonzo/.
