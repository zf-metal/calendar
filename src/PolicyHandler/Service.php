<?php
namespace ZfMetal\Calendar\PolicyHandler;

class Service
{

    public static function format($original,$transformed){
        $s["ID"] = 'id';
        $s["Cliente"] = 'Cliente X';
        $s["Sucursal"] = "Casa Central";
        $s["Direccion"] = "Direccion abc";
        $s["Zona"] = "centro";
        return $s;
    }

}