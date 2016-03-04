<?php
namespace ForDev\LiteralNumbers\Localized;

use ForDev\LiteralNumbers\LiteralNumbersInterface;

class PL implements LiteralNumbersInterface
{
    protected $words = [
            'minus',
            [
                'zero',
                'jeden',
                'dwa',
                'trzy',
                'cztery',
                'pięć',
                'sześć',
                'siedem',
                'osiem',
                'dziewięć'
            ],
            [
                'dziesięć',
                'jedenaście',
                'dwanaście',
                'trzynaście',
                'czternaście',
                'piętnaście',
                'szesnaście',
                'siedemnaście',
                'osiemnaście',
                'dziewiętnaście'
            ],
            [
                'dziesięć',
                'dwadzieścia',
                'trzydzieści',
                'czterdzieści',
                'pięćdziesiąt',
                'sześćdziesiąt',
                'siedemdziesiąt',
                'osiemdziesiąt',
                'dziewięćdziesiąt'
            ],
            [
                'sto',
                'dwieście',
                'trzysta',
                'czterysta',
                'pięćset',
                'sześćset',
                'siedemset',
                'osiemset',
                'dziewięćset'
            ],
            [
                'tysiąc',
                'tysiące',
                'tysięcy'
            ],
            [
                'milion',
                'miliony',
                'milionów'
            ],
            [
                'miliard',
                'miliardy',
                'miliardów'
            ],
            [
                'bilion',
                'biliony',
                'bilionów'
            ]
    ];

    protected $currencies = [
        'pln' => [
            'złoty',
            'złote',
            'złotych'
        ],
        'usd' => [
            'dolar amerykański',
            'dolary amerykańskie',
            'dolarów amerykańskich'
        ],
        'euro' => [
            'euro',
            'euro',
            'euro'
        ],
    ];

    protected $currency = null;
    protected $addCurrency = false;
    protected $last = 0;

    protected function conjugation($variants, $int)
    {
        $txt = $variants[2];
        if ($int == 1) {
            return $variants[0];
        }
        $jednosci = (int)substr($int, -1);
        $reszta = $int % 100;
        if (($jednosci > 1 && $jednosci < 5) & !($reszta > 10 && $reszta < 20))
            $txt = $variants[1];

        return $txt;
    }

    protected function number($int)
    {
        $wynik = '';
        $j = abs((int)$int);

        if ($j == 0) return $this->words[1][0];
        $jednosci = $j % 10;
        $dziesiatki = ($j % 100 - $jednosci) / 10;
        $setki = ($j - $dziesiatki * 10 - $jednosci) / 100;

        if ($setki > 0) $wynik .= $this->words[4][$setki - 1] . ' ';

        if ($dziesiatki > 0)
            if ($dziesiatki == 1) $wynik .= $this->words[2][$jednosci] . ' ';
            else
                $wynik .= $this->words[3][$dziesiatki - 1] . ' ';

        if ($jednosci > 0 && $dziesiatki != 1) $wynik .= $this->words[1][$jednosci] . ' ';

        return $wynik;
    }

    public function toLiteral($int)
    {
        $in = preg_replace('/[^-\d]+/', '', $int);
        $out = '';

        if ($in{0} == '-') {
            $in = substr($in, 1);
            $out = $this->words[0] . ' ';
        }

        $txt = str_split(strrev($in), 3);

        if ($in == 0) {
            $out = $this->words[1][0] . ' ';
        }

        for ($i = count($txt) - 1; $i >= 0; $i--) {
            $liczba = (int)strrev($txt[$i]);
            if ($liczba > 0) {
                if ($i == 0) {
                    $this->last = $liczba;
                    $out .= $this->number($liczba) . ' ';
                } else {
                    $out .= ($liczba > 1 ? $this->number($liczba) . ' ' : '')
                        . $this->conjugation($this->words[4 + $i], $liczba) . ' ';
                }
            }
        }

        if (!empty($this->currency) && $this->addCurrency) {
            $out .= $this->addCurrency();
        }

        $out = trim(str_replace(['   ', '  '], ' ', $out));

        return $out;
    }

    public function setCurrency($currency)
    {
        $this->currency = strtolower($currency);

        return $this;
    }

    public function currency($bool) {
        $this->addCurrency = (bool)$bool;

        return $this;
    }

    protected function addCurrency()
    {
        return $this->conjugation($this->currencies[$this->currency], $this->last);
    }
}
