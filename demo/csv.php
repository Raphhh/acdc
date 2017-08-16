<?php

include_once __DIR__ . '/../vendor/autoload.php';

/**
 * @param $length
 * @return \Generator
 */
function createCSVGenerator($length)
{
    $cols = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $length; ++$i) {

        sleep(1); //simulate a lot of things..

        $col = '';
        foreach (str_split($cols) as $char) {
            $col .= '"' . $i . $char .'",';
        }
        yield rtrim($col, ',') . "\n";
    }
}


//create te generator
$generator = createCSVGenerator(30); //will take 30 sec...


//transform the generator to a stream
$acdc = new Ac\Dc();
$resource = $acdc->createStream($generator);


//display the stream
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="demo.csv"');
while(($line = fgets($resource)) !== false) {
    echo $line;
    ob_flush(); //already send the stream during the downloading
}
