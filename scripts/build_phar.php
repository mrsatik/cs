<?php

error_reporting(E_ALL | E_STRICT);

$base = dirname(__DIR__);

$options = getopt("", array('target:', 'script:'));

if (empty($options['target'])
    || empty($options['script'])
    || !in_array($options['script'], array('phpcs', 'phpcbf'))) {
    echo getHelp();
    exit(1);
}

try {
    $phar = new Phar($options['target']);

    if (!$phar->isWritable()) {
        throw new UnexpectedValueException();
    }
} catch (UnexpectedValueException $e) {
    echo getError($options['target']);

    exit(1);
}

$phar->buildFromDirectory($base, "/vendor\/|config\/|standards\//");
$phar->setStub(getStub($options['script']));

echo "{$options['target']} is built succesfuly".PHP_EOL;


function getHelp()
{
    return <<<HELP
Phar archive build
Usage: {$GLOBLAS['argv'][0]} --target=<target> --script=<script>
	
	--target=    output file name
	--script=    one of "phpcs" | "phpcbf"

HELP;
}

function getError($pharFile)
{
    return <<<ERR
Unable to build $pharFile
May be...
* there is no target folder
* u have no permission to write this file
* u have no 'phar.readonly = 0' in your php.ini 

ERR;
}

function getStub($script)
{
    return <<<STUB
#!/usr/bin/env php
<?php

Phar::mapPhar("$script.phar");

require "phar://$script.phar/vendor/autoload.php";
require "phar://$script.phar/vendor/squizlabs/php_codesniffer/autoload.php";
require "phar://$script.phar/config/bootstrap.php";

\$runner   = new PHP_CodeSniffer\Runner();
\$exitCode = \$runner->run$script();
exit(\$exitCode);

__HALT_COMPILER();
STUB;
}