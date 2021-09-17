<?php

namespace CoinZoom;

class Helpers
{
    /**
     *	@description	
     *	@param	
     */
    public static function alterKeys(array $array)
    {
        $new = [];
        foreach ($array as $k => $v) {
            preg_match_all('/((?:^|[A-Z])[a-z]+)/', $k, $match);
            $akey = strtolower(implode('_', array_pop($match)));
            $new[$akey] = $v;
        }
        return $new;
    }
}
