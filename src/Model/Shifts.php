<?php
/**
 * Created by IntelliJ IDEA.
 * User: crist
 * Date: 4/2/2019
 * Time: 17:10
 */

namespace ZfMetal\Calendar\Model;


class Shifts
{

    /** @var array */
    protected $shifts = [];

    public function add(Shift $shift)
    {
        $this->shifts[] = $shift;
    }

    public function remove($key)
    {
        if(key_exists($key,$this->shifts)){
            unset($this->shifts[$key]);
        }

    }

    public function getCollection(){
        return $this->shifts;
    }

    public function toArray()
    {
        $r = [];
        /** @var Shift $shift */
        foreach ($this->shifts as $shift) {
            $r[] = $shift->toArray();
        }

        return $r;
    }

}