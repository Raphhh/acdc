# Ac\Dc: PHP generator stream

[![Latest Stable Version](https://poser.pugx.org/raphhh/acdc/v/stable.svg)](https://packagist.org/packages/raphhh/acdc)
[![Build Status](https://travis-ci.org/Raphhh/acdc.png)](https://travis-ci.org/Raphhh/acdc)

Convert a generator to a stream


## Installation

```
$ composer require raphhh/acdc
```

## Usage

```
$acdc = new Ac\dc();
$resource = $acdc->createStream($generator);
```
