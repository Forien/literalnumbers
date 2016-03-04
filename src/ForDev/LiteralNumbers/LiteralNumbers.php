<?php

namespace ForDev\LiteralNumbers;


abstract class LiteralNumbers
{
    public static function getInstance($lang)
    {
        $var = strtoupper($lang);
        $class = 'ForDev\\LiteralNumbers\\Localized\\' .$var;
        
        if (!class_exists($class)) {
            throw new \PhpSpec\Exception\Fracture\ClassNotFoundException('Class "'. $class .'" not found in LiteralNumbers library.', $class);
        }
        $provider = new $class();
        
        if (!$provider instanceof LiteralNumbersInterface) {
            throw new \PhpSpec\Exception\Fracture\InterfaceNotImplementedException('Class "'. $class .'" does not have correct "'. LiteralNumbersInterface::class .'" interface', $class, LiteralNumbersInterface::class);
        }
        
        return $provider;
    }
}