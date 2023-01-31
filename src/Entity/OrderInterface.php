<?php

declare(strict_types=1);

namespace Recruitment\Entity;

interface OrderInterface
{
    public function getDataForView(): array;
}
