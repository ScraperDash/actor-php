<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Common\Exception;

use Psr\Container\NotFoundExceptionInterface;

class DefinitionNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
}
