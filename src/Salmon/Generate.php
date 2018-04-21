<?php
declare(strict_types = 1);

namespace Salmon;

final class Generate
{
    public const TYPE_CHECKER_NONE    = 0;
    public const TYPE_CHECKER_PHPSTAN = 1;
    public const TYPE_CHECKER_PSALM   = 2;

    /** @var int */
    public $typeChecker;

    public function __construct(int $typeChecker)
    {
        $this->typeChecker = $typeChecker;
    }
}
