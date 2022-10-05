<?php

namespace eloquentFilter\QueryFilter\Core;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class QueryFilterCoreWrapper.
 */
class QueryFilterBuilder
{

    /**
     * @var \eloquentFilter\QueryFilter\Core\QueryFilterCoreBuilder
     */
    public $core;
    public $request;

    /**
     * @param array|null $request
     */
    public function __construct(QueryFilterCore $core, RequestFilter $requestFilter)
    {
        $this->core = $core;
        $this->request = $requestFilter;
    }

    /**
     * @param Builder $builder
     * @param array|null $request
     * @param array|null $ignore_request
     * @param array|null $accept_request
     * @param array|null $detect_injected
     *
     * @return void
     */
    public function apply(Builder $builder, array $request = null, array $ignore_request = null, array $accept_request = null, array $detect_injected = null)
    {

        $this->core->setBuilder($builder);

        if (!empty($request)) {
            $this->request->setRequest($request);
        }

        if (config('eloquentFilter.enabled') == false || empty($this->request->getRequest())) {
            return;
        }


        if (method_exists($this->core->getBuilder()->getModel(), 'serializeRequestFilter') && !empty($this->request->getRequest())) {

            $serializeRequestFilter = $this->core->getBuilder()->getModel()->serializeRequestFilter($this->request->getRequest());
            $this->request->handelSerializeRequestFilter($serializeRequestFilter);

        }

        if ($alias_list_filter = $this->core->getBuilder()->getModel()->getAliasListFilter()) {

            $this->request->makeAliasRequestFilter($alias_list_filter);
        }


        $this->request->setFilterRequests($ignore_request, $accept_request, $this->core->getBuilder()->getModel());

        if (!empty($detect_injected)) {
            $this->core->setDetectInjected($detect_injected);
            $this->core->setDetectFactory($this->core->getDetectorFactory($this->core->getDefaultDetect(), $this->core->getDetectInjected()));
        }

        app()->bind('ResolverDetections', function () {
            return new ResolverDetections($this->core->getBuilder(), $this->request->getRequest(), $this->core->getDetectFactory());
        });

        $response = app('ResolverDetections')->getResolverOut();

        $response = $this->core->handelResponseFilter($response);

        return $response;
    }

    /**
     * @param null $index
     *
     * @return array|mixed|null
     */
    public function filterRequests($index = null)
    {
        if (!empty($index)) {
            return $this->request->getRequest()[$index];
        }

        return $this->request->getRequest();
    }

    /**
     * @return mixed
     */
    public function getAcceptedRequest()
    {
        return $this->request->getAcceptRequest();
    }

    /**
     * @return mixed
     */
    public function getIgnoredRequest()
    {
        return $this->request->getIgnoreRequest();
    }

    /**
     * @return mixed
     */
    public function getInjectedDetections()
    {
        return $this->core->getDetectInjected();
    }

}
