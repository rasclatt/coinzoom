<?php

namespace CoinZoom\PublicApi;

class Dto
{
    /**
     *	@description	
     *	@param	
     */
    public function __construct(array $array = null)
    {
        if (!is_array($array))
            return $this;

        foreach ($array as $k => $v) {
            if (!isset($this->{$k}))
                continue;

            switch (gettype($this->{$k})) {
                case ('boolean'):
                    $this->{$k} = (bool) trim($v);
                    break;
                case ('string'):
                    $this->{$k} = (string) trim($v);
                    break;
                case ('int'):
                    $this->{$k} = (int) trim($v);
                    break;
                default:
                    $this->{$k} = $v;
            }

            if (method_exists($this, $k))
                $this->{$k}();
        }
    }
    /**
     *	@description	Turns objects to arrays
     */
    public function toArray()
    {
        return $this->recurseToArray($this);

        $vars = get_class_vars(get_class($this));
        $new = [];
        foreach ($vars as $k => $v) {
            $new[$k] = $this->{$k};
        }
        return $new;
    }
    /**
     *	@description	Tries to fetch values from saved objects
     */
    public function __call($method, $args = null)
    {
        $key = preg_replace('/^get/', '', $method);
        if (isset($this->{$key}))
            return $this->{$key};
        return false;
    }
    /**
     *	@description	
     *	@param	
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
    /**
     *	@description	Will recurse a nested array and convert all attributes into arrays from their objects
     *	@param	[mixed]
     */
    private function recurseToArray($array)
    {
        if (!is_array($array) && !is_object($array))
            return $array;

        if (is_object($array)) {
            $vars = get_class_vars(get_class($array));
            if (empty($vars))
                $new = $this->recurseToArray((array) $array);
            else {
                foreach ($vars as $k => $v) {
                    $new[$k] = $this->recurseToArray($array->{$k});
                }
            }
        } elseif (is_array($array)) {
            foreach ($array as $k => $v) {
                $new[$k] = $this->recurseToArray($v);
            }
        }

        return ($new) ?? null;
    }
}
