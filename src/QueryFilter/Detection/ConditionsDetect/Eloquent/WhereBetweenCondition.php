<?php

namespace eloquentFilter\QueryFilter\Detection\ConditionsDetect\Eloquent;

use eloquentFilter\QueryFilter\Detection\Contract\DetectorConditionsContract;
use eloquentFilter\QueryFilter\Queries\WhereBetween;

/**
 * Class WhereBetweenCondition.
 */
class WhereBetweenCondition implements DetectorConditionsContract
{
    /**
     * @param $field
     * @param $params
     * @param bool $is_override_method
     *
     * @return mixed|string
     */
    public static function detect($field, $params, bool $is_override_method = false): ?string
    {
        if (isset($params['start']) && isset($params['end'])) {
            $method = WhereBetween::class;
        }

        return $method ?? null;
    }
}
