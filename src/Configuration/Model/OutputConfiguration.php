<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model;

use ScraperDash\Actor\Configuration\Model\Enum\OutputTypeEnum;

class OutputConfiguration
{
    private OutputTypeEnum $type;

    /**
     * @var class-string|null
     */
    private string|null $model;

    /**
     * @param class-string|null $model
     */
    public function __construct(
        OutputTypeEnum $type = OutputTypeEnum::MAP,
        string|null $model = null
    ) {
        $this->type = $type;
        $this->model = $model;
    }

    public function getType(): OutputTypeEnum
    {
        return $this->type;
    }

    /**
     * @return class-string|null
     */
    public function getModel(): string|null
    {
        return $this->model;
    }
}
