<?php
/**
 * Created by PhpStorm.
 * User: crist
 * Date: 16/5/2018
 * Time: 11:14
 */

namespace ZfMetal\Calendar\PolicyHandler;

class EntityId
{

    public static function transform($original,$transformed){
        if($original && method_exists($original,"getId")){
            return $original->getId();
        }
        return $transformed;
    }

}