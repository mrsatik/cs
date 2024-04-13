<?php
/// errors:0

function check(string $who): ?int
{
    switch ($who) {
        case 'John':
        case 'Paul':
            return 1;

        case 'Lars':
        case 'Mary':
            return 2;

        default:
            return null;
    }
}
