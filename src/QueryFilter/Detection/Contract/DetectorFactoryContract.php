<?php

namespace eloquentFilter\QueryFilter\Detection\Contract;

/**
 * Interface Detector.
 */
interface DetectorFactoryContract
{
    /**
     * @param string $field
     * @param $params
     * @param null $model
     * @return mixed
     */
    public function buildDetections(string $field, $params, $model = null): ?string;
}
