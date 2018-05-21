<?php
/**
 * Created by PhpStorm.
 * User: crist
 * Date: 16/5/2018
 * Time: 11:14
 */

namespace ZfMetal\Calendar\PolicyHandler;

class EntityIdName
{

    public static function transform($original,$transformed){
        if($original && method_exists($original,"getId")){
            return ["id"=> $original->getId(),"name" =>$original->getName()];
        }
        return $transformed;
    }

}