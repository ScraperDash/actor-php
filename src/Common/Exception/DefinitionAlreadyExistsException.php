<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Common\Exception;

use Psr\Container\ContainerExceptionInterface;

class DefinitionAlreadyExistsException extends \RuntimeException implements ContainerExceptionInterface
{
}
