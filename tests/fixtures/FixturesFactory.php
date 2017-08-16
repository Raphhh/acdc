<?php
namespace Ac\fixtures;

class FixturesFactory
{
    /**
     * @param $length
     * @return \Generator
     */
    public function createCSV($length)
    {
        $cols = 'ABCDE';
        for ($i = 0; $i < $length; ++$i) {
            $col = '';
            foreach (str_split($cols) as $char) {
                $col .= '"' . $i . $char .'",';
            }
            yield rtrim($col, ',') . "\n";
        }
    }
}
