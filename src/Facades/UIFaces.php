<?php


namespace robertogallea\UIFaces\Facades;


use Illuminate\Support\Facades\Facade;

class UIFaces extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \robertogallea\UIFaces\UIFaces::class;
    }
}