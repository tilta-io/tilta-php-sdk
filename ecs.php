<?php declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\AssignmentInConditionSniff;
use PhpCsFixer\Fixer\Basic\PsrAutoloadingFixer;
use PhpCsFixer\Fixer\ClassNotation\ProtectedToPrivateFixer;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSpaceFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {

    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests'
    ]);

    $ecsConfig->ruleWithConfiguration(HeaderCommentFixer::class, ['header' => 'Copyright (c) Tilta Fintech GmbH

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.', 'separate' => 'bottom', 'location' => 'after_open', 'comment_type' => 'comment']);

    $ecsConfig->sets([
        SetList::CLEAN_CODE,
        SetList::COMMON,
        SetList::STRICT,
        SetList::PSR_12,
        SetList::COMMENTS,
        SetList::SPACES,
        SetList::NAMESPACES,
        SetList::DOCBLOCK,
        SetList::ARRAY,
        SetList::CONTROL_STRUCTURES,
    ]);

    $ecsConfig->rules([
        PsrAutoloadingFixer::class
    ]);

    $ecsConfig->skip([
        ProtectedToPrivateFixer::class,
        NotOperatorWithSpaceFixer::class,
        NotOperatorWithSuccessorSpaceFixer::class,
        AssignmentInConditionSniff::class,
        ArrayListItemNewlineFixer::class => [
            __DIR__ . '/tests/Functional/Util/ResponseHelperTest.php',
            __DIR__ . '/tests/Functional/Service/*'
        ],
        ArrayOpenerAndCloserNewlineFixer::class => [
            __DIR__ . '/tests/Functional/Util/ResponseHelperTest.php',
            __DIR__ . '/tests/Functional/Service/*'
        ]
    ]);

    $ecsConfig->cacheDirectory(__DIR__ . '/var/cache/cs_fixer');
};
