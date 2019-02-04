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