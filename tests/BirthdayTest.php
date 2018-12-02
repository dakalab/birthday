<?php

namespace Dakalab\Birthday\Tests;

use Dakalab\Birthday\Birthday;

/**
 * Test class for Dakalab\Birthday\Birthday
 *
 * @coversDefaultClass \Dakalab\Birthday\Birthday
 * @runTestsInSeparateProcesses
 */
class BirthdayTest extends TestCase
{
    /**
     * @dataProvider birthdayProvider
     */
    public function testBirthday($date, $lang, $age, $constellation): void
    {
        $birthday = new Birthday($date, $lang);
        $this->assertEquals($age, $birthday->getAge());
        $this->assertEquals($constellation, $birthday->getConstellation());
    }

    public function birthdayProvider(): array
    {
        return [
            [date('Y') . '-01-01', 'en', 0, 'Capricorn'],
            [date('Y') . '-10-01', 'cn', 0, '天秤座'],
            [date('Y') . '-3-01', 'xx', 0, 'Pisces'],
        ];
    }

    /**
     * @dataProvider calculateAgeProvider
     */
    public function testCalculateAge($year, $month, $day, $expected): void
    {
        $age = Birthday::calculateAge($year, $month, $day);
        $this->assertEquals($expected, $age);
    }

    public function calculateAgeProvider(): array
    {
        return [
            [date('Y'), 1, 1, 0],
            [date('Y') - 1, 1, 1, 1],
            [date('Y') - 2, 12, 32, 1],
        ];
    }

    /**
     * @dataProvider parseConstellationProvider
     */
    public function testParseConstellation($month, $day, $expected, $expectError): void
    {
        if ($expectError) {
            $this->expectException(\InvalidArgumentException::class);
        }
        $constellation = Birthday::parseConstellation($month, $day);
        $this->assertEquals($expected, $constellation);
    }

    public function parseConstellationProvider(): array
    {
        return [
            [1, 1, 'Capricorn', false],
            [2, 1, 'Aquarius', false],
            [3, 1, 'Pisces', false],
            [4, 1, 'Aries', false],
            [5, 1, 'Taurus', false],
            [6, 1, 'Gemini', false],
            [7, 1, 'Cancer', false],
            [8, 1, 'Leo', false],
            [9, 1, 'Virgo', false],
            [10, 1, 'Libra', false],
            [11, 1, 'Scorpio', false],
            [12, 1, 'Sagittarius', false],
            [13, 1, '', true],
        ];
    }

    /**
     * @dataProvider validateProvider
     */
    public function testValidate($date, $expected, $exception): void
    {
        if (!is_null($exception)) {
            $this->expectException($exception);
        }
        list('year' => $year, 'month' => $month, 'day' => $day) = Birthday::validate($date);
        $this->assertEquals($expected, "$year-$month-$day");
    }

    public function validateProvider(): array
    {
        return [
            [date('Y') . '-01-01', date('Y') . '-1-1', null],
            ['xxx', null, \InvalidArgumentException::class],
            [date('Y') + 1 . '-01-01', null, \OutOfRangeException::class],
            [date('Y') - 300 . '-01-01', null, \OutOfRangeException::class],
        ];
    }
}
