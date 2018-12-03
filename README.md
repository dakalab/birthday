# birthday

Validate birthday, parse the age and constellation of valid birthday.

[![Build Status](https://travis-ci.org/dakalab/birthday.svg?branch=master)](https://travis-ci.org/dakalab/birthday)
[![codecov](https://codecov.io/gh/dakalab/birthday/branch/master/graph/badge.svg)](https://codecov.io/gh/dakalab/birthday)
[![Total Downloads](https://poser.pugx.org/dakalab/birthday/downloads)](https://packagist.org/packages/dakalab/birthday)
[![License](https://poser.pugx.org/dakalab/birthday/license.svg)](https://packagist.org/packages/dakalab/birthday)

## Install

```
composer require dakalab/birthday
```

## Usage

```
$birthday = new Birthday('1988-01-01', 'zh');
$age = $birthday->getAge();
$constellation = $birthday->getConstellation();
```
