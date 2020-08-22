<?php

namespace eloquentFilter\QueryFilter\Detection\ConditionsDetect;

use eloquentFilter\QueryFilter\Detection\DetectorContract;
use eloquentFilter\QueryFilter\Queries\WhereOr;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WhereOrCondition.
 */
class WhereOrCondition implements DetectorContract
{
    /**
     * @param $field
     * @param $params
     * @param Model|null $model
     *
     * @return mixed|string
     */
    public static function detect($field, $params, Model $model = null): ?string
    {
        if ($field == 'or') {
            $method = WhereOr::class;
        }

        return $method ?? null;
    }
}
