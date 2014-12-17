<?php

namespace Application\Di;

class DiImpl implements Di
{
    protected $items = [];
    protected $serviceNamespace;

    /**
     * @param $namespace
     * @return mixed
     */
    public function setServiceNamespace($namespace)
    {
        $this->serviceNamespace = $namespace;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function reloadShared($name)
    {
        return $this->get($name, true);
    }

    /**
     * @param $name
     * @param bool $reloadShared
     * @return mixed|null
     */
    public function get($name, $reloadShared = false)
    {
        if (isset($this->items[$name])) {
            return $this->getFromCallback($name, $reloadShared);
        } else {
            return $this->getFromService($name);
        }
    }

    /**
     * @param $name
     * @param bool $reloadShared
     * @return mixed
     */
    protected function getFromCallback($name, $reloadShared = false)
    {
        if ($this->items[$name]['shared_object'] != null && $reloadShared == false) {
            return $this->items[$name]['shared_object'];
        }

        $value = call_user_func_array($this->items[$name]['value'], [$this]);
        if ($this->items[$name]['is_shared']) {
            $this->items[$name]['shared_object'] = $value;
        }
        return $value;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    protected function getFromService($name)
    {
        /**
         * @var DiService $object
         */
        $className = $this->serviceNamespace . '\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $name)))
            . 'Service';
        $object = new $className();
        if ($object instanceof DiService) {
            $this->set($name, array($object, 'getService'), $object->isShared());
            return $this->getFromCallback($name);
        }
        return null;
    }

    /**
     * @param $name
     * @param $value
     * @param bool $isShared
     * @return mixed|void
     */
    public function set($name, $value, $isShared = false)
    {
        $this->items[$name] = [
            'value' => $value,
            'is_shared' => $isShared,
            'shared_object' => null
        ];

        if (!is_callable($value)) {
            $this->items[$name]['shared_object'] = $value;
        }
    }
}
