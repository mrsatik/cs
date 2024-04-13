<?php
namespace mrsatik\CodestyleTest;

use PHP_CodeSniffer\Runner;
use PHPUnit\Framework\TestCase;

$base = dirname(__DIR__);
require_once $base.'/vendor/squizlabs/php_codesniffer/autoload.php';
require_once $base."/bootstrap.php";


class AcceptanceTest extends TestCase
{
    /**
     * @param $snippetFile
     * @param $expectedErrors
     *
     * @dataProvider snippets
     */
    public function testSnippet($snippetFile, $severity, $expectedErrors)
    {
        $ruleset = dirname(__DIR__) . '/src/standards/mrsatik/ruleset.xml';
        $_SERVER['argv'] = [
            $_SERVER['argv'][0],
            $snippetFile,
            "-n",
//            "-s", show sniffs names
            "--report-width=70",
            "--severity=$severity",
            "--standard=$ruleset"
        ];

        $runner   = new Runner();

        ob_start();
        $runner->runPHPCS();
        $result = ob_get_clean();

        '' === $expectedErrors
            ? $this->assertEmpty($result)
            : $this->assertStringContainsString($expectedErrors, $result);
    }

    /**
     * @return array
     */
    public function snippets()
    {
        $directory = __DIR__.'/snippets';
        $dir = dir($directory);
        $result = $files = [];
        while ($entry = $dir->read()) {
            if (\in_array($entry, ['.', ".."]) === true) {
                continue;
            }

            $i = pathinfo($entry);

            if (isset($files[$i['filename']]) === false) {
                $files[$i['filename']] = [];
            }
            $files[$i['filename']][] = $i['extension'];
        }

        foreach ($files as $name => $info) {
            if (\in_array('php', $info) === false) {
                throw new \UnexpectedValueException("Could't find php file for $name snippet");
            }

            if (count($info) === 1) {
                throw new \UnexpectedValueException("Could't find expected result file for $name snippet");
            }

            foreach ($info as $ext) {
                if ('php' === $ext) {
                    continue;
                }
                if (preg_match('|severity-(\d+)|', $ext, $m)) {
                    $result[] = ["$directory/$name.php", $m[1], file_get_contents("$directory/$name.$ext")];
                } else {
                    throw new \UnexpectedValueException("Unexpected file-extension for $name snippet. Expected 'severity-\\d+' ");
                }
            }
        }

        return $result;
    }
}