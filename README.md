# PHP Info

Wraps the `phpinfo` function and provides a more structured output format using HTML, TEXT, and JSON.
Supports all PHP versions from 5.4 onwards.

Install

~~~bash
composer require tebe/phpinfo
~~~

**Web**

~~~php
<?php

require dirname(__DIR__) . '/vendor/autoload.php';

tebe\phpinfo();
~~~ 

**CLI**

Text output

~~~bash
./vendor/bin/phpinfo
./vendor/bin/phpinfo --text
~~~

JSON output

~~~bash
./vendor/bin/phpinfo --json
~~~

Thanks to https://www.reddit.com/user/HolyGonzo/.
