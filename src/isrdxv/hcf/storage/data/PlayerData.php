<?php
declare(strict_types=1);

namespace isrdxv\hcf\storage\data;

final class PlayerData
{

    static function deserealize(array $data): self
    {
        return new self();
    }

    function __construct()
    {

    }

}