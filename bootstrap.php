<?php

$base = Phar::running() ?: __DIR__;

\PHP_CodeSniffer\Config::setConfigData('installed_paths', $base . '/src/standards', true);
\PHP_CodeSniffer\Config::setConfigData('default_standard', 'mrsatik', true);
