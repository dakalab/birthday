# birthday

Validate birthday, parse the age and constellation of valid birthday.

[![Build Status](https://travis-ci.org/dakalab/birthday.svg?branch=master)](https://travis-ci.org/dakalab/birthday)
[![codecov](https://codecov.io/gh/dakalab/birthday/branch/master/graph/badge.svg)](https://codecov.io/gh/dakalab/birthday)
[![Latest Stable Version](https://poser.pugx.org/dakalab/birthday/v/stable)](https://packagist.org/packages/dakalab/birthday)
[![Total Downloads](https://poser.pugx.org/dakalab/birthday/downloads)](https://packagist.org/packages/dakalab/birthday)
[![PHP Version](https://img.shields.io/php-eye/dakalab/birthday.svg)](https://packagist.org/packages/dakalab/birthday)
[![License](https://poser.pugx.org/dakalab/birthday/license.svg)](https://packagist.org/packages/dakalab/birthday)

## Install

```
composer require dakalab/birthday
```

## Usage

```
use Dakalab\Birthday\Birthday;

$birthday = new Birthday('2018-12-01', 'zh');
$age = $birthday->getAge();
$constellation = $birthday->getConstellation();
$formatedDate = $birthday->format('d/m/Y'); // 01/12/2018
$normalizedDate = (string) $birthday; // 2018-12-01
```
