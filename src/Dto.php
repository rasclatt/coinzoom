<?php
namespace CoinZoom;

class Dto extends \SmartDto\Dto
{
    /**
     *	@description	
     *	@param	
     */
    public function toArray()
    {
        return $this->recurseConvert($this->toPropertyArray());
    }
    /**
     *	@description	
     *	@param	
     */
    protected function recurseConvert($obj)
    {
        if($obj instanceof \SmartDto\Dto) {
            $obj = $obj->toArray();
        }
        elseif(!is_array($obj))
            return $obj;

        foreach($obj as $k => $v) {
            $obj[$k] = $this->recurseCase($v);
        }
        return $obj;
    }
}