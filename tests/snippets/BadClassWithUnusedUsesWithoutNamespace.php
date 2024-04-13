<?php

use Exception;
use mrsatik\Sniffs\WhiteSpace\DisallowTabIndentSniff;
use mrsatik\Sniffs\WhiteSpace\UnusedUseStatementSniff;
use mrsatik\codestyle\AcceptanceTest;

abstract class BadClassWithUnusedUsesWithoutNamespace
{
    abstract protected function foo(DisallowTabIndentSniff $b) : UnusedUseStatementSniff;
}