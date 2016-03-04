<?php

namespace ForDev\LiteralNumbers;


interface LiteralNumbersInterface
{
    public function toLiteral($int);
    public function setCurrency($currency);
    public function currency($bool);
}