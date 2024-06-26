<?php

namespace mrsatik\Sniffs\WhiteSpace;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class DisallowTabIndentSniff implements Sniff
{

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = [
        'PHP',
        'JS',
        'CSS',
    ];


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_OPEN_TAG];

    }


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile All the tokens found in the document.
     * @param int                         $stackPtr  The position of the current token in
     *                                               the stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens    = $phpcsFile->getTokens();
        $error     = 'Spaces must be used to indent lines; tabs are not allowed';
        $errorCode = 'TabsUsed';

        $checkTokens = [
            T_WHITESPACE             => true,
            T_DOC_COMMENT_WHITESPACE => true,
            T_DOC_COMMENT_STRING     => true,
        ];

        for ($i = ($stackPtr + 1); $i < $phpcsFile->numTokens; $i++) {
            if (isset($checkTokens[$tokens[$i]['code']]) === false) {
                continue;
            }

            // If tabs are being converted to spaces by the tokeniser, the
            // original content should be checked instead of the converted content.
            if (isset($tokens[$i]['orig_content']) === true) {
                $content = $tokens[$i]['orig_content'];
            } else {
                $content = $tokens[$i]['content'];
            }

            if ($content === '') {
                continue;
            }

            if ($tokens[$i]['code'] === T_DOC_COMMENT_WHITESPACE && $content === ' ') {
                // Ignore file/class-level DocBlock, especially for recording metrics.
                continue;
            }

            $tabFound = false;
            if ($tokens[$i]['column'] === 1) {
                if ($content[0] === "\t") {
                    $phpcsFile->recordMetric($i, 'Line indent', 'tabs');
                    $tabFound = true;
                } elseif ($content[0] === ' ') {
                    if (strpos($content, "\t") !== false) {
                        $phpcsFile->recordMetric($i, 'Line indent', 'mixed');
                        $tabFound = true;
                    } else {
                        $phpcsFile->recordMetric($i, 'Line indent', 'spaces');
                    }
                }
            } else {
                // Look for tabs so we can report and replace, but don't
                // record any metrics about them because they aren't
                // line indent tokens.
                if (strpos($content, "\t") !== false) {
                    $tabFound  = true;
                    $error     = 'Spaces must be used for alignment; tabs are not allowed';
                    $errorCode = 'NonIndentTabsUsed';
                }
            }

            if ($tabFound === false) {
                continue;
            }

            $fix = $phpcsFile->addFixableError($error, $i, $errorCode);
            if ($fix === true) {
                if (isset($tokens[$i]['orig_content']) === true) {
                    // Use the replacement that PHPCS has already done.
                    $phpcsFile->fixer->replaceToken($i, $tokens[$i]['content']);
                } else {
                    // Replace tabs with spaces, using an indent of 4 spaces.
                    // Other sniffs can then correct the indent if they need to.
                    $newContent = str_replace("\t", '    ', $tokens[$i]['content']);
                    $phpcsFile->fixer->replaceToken($i, $newContent);
                }
            }
        }

        // Ignore the rest of the file.
        return ($phpcsFile->numTokens + 1);
    }
}
