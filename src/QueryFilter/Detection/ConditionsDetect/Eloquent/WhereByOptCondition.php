<?php

namespace eloquentFilter\QueryFilter\Detection\ConditionsDetect\Eloquent;

use eloquentFilter\QueryFilter\Detection\Contract\DetectorConditionsContract;
use eloquentFilter\QueryFilter\Queries\WhereByOpt;

/**
 * Class WhereByOptCondition.
 */
class WhereByOptCondition implements DetectorConditionsContract
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
        if (!empty($params['operator']) && isset($params['value'])) {
            $method = WhereByOpt::class;
        }

        return $method ?? null;
    }
}
