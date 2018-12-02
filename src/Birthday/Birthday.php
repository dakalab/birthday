<?php

namespace Dakalab\Birthday;

class Birthday
{
    const MAX_AGE = 200; // max age, seems nobody will live so long

    const SUPPORTED_LANGS = ['en', 'cn'];

    protected $birthday;

    protected $lang;

    protected $age;

    protected $constellation;

    /**
     * Constructor
     *
     * @param  string                      $birthday
     * @param  string                      $lang
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function __construct($birthday, $lang = 'en')
    {
        $this->birthday = $birthday;
        $this->setLang($lang);
        $this->parse();
    }

    /**
     * Parse the birthday
     *
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    protected function parse(): void
    {
        list('year' => $year, 'month' => $month, 'day' => $day) = self::validate($this->birthday);
        $this->age = self::calculateAge($year, $month, $day);
        $this->constellation = self::parseConstellation($month, $day);
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * Get constellation
     *
     * @return string
     */
    public function getConstellation(): string
    {
        return $this->translate($this->constellation, $this->lang);
    }

    /**
     * Set the language
     *
     * @param  string $lang
     * @return void
     */
    public function setLang($lang): void
    {
        $this->lang = $lang;
    }

    /**
     * Validate birthday, if it is valid then return the birth year, month and day
     *
     * @param  string                      $birthday
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     * @return array
     */
    public static function validate($birthday): array
    {
        $date = strtotime($birthday);

        if ($date === false) {
            throw new \InvalidArgumentException("Invalid birthday: $birthday");
        }

        $year = date('Y', $date);
        $month = date('n', $date);
        $day = date('j', $date);
        $currentYear = date('Y');

        if ($year > $currentYear || $year <= $currentYear - self::MAX_AGE) {
            throw new \OutOfRangeException('The age is out of range [0, 200)');
        }

        return ['year' => $year, 'month' => $month, 'day' => $day];
    }

    /**
     * Calculate age
     *
     * @param  int   $year
     * @param  int   $month
     * @param  int   $day
     * @return int
     */
    public static function calculateAge($year, $month, $day): int
    {
        $currentYear = date('Y');
        $currentMonth = date('n');
        $currentDay = date('j');
        $age = $currentYear - $year;
        if ($currentMonth < $month || ($currentMonth == $month && $currentDay < $day)) {
            $age--;
        }

        return $age;
    }

    /**
     * Parse constellation by the given month and day
     *
     * @param  int                         $month
     * @param  int                         $day
     * @throws \InvalidArgumentException
     * @return string
     */
    public static function parseConstellation($month, $day): string
    {
        switch ($month) {
            case 1:
                return $day >= 20 ? 'Aquarius' : 'Capricorn';
            case 2:
                return $day >= 19 ? 'Pisces' : 'Aquarius';
            case 3:
                return $day >= 21 ? 'Aries' : 'Pisces';
            case 4:
                return $day >= 20 ? 'Taurus' : 'Aries';
            case 5:
                return $day >= 21 ? 'Gemini' : 'Taurus';
            case 6:
                return $day >= 22 ? 'Cancer' : 'Gemini';
            case 7:
                return $day >= 23 ? 'Leo' : 'Cancer';
            case 8:
                return $day >= 23 ? 'Virgo' : 'Leo';
            case 9:
                return $day >= 23 ? 'Libra' : 'Virgo';
            case 10:
                return $day >= 24 ? 'Scorpio' : 'Libra';
            case 11:
                return $day >= 23 ? 'Sagittarius' : 'Scorpio';
            case 12:
                return $day >= 22 ? 'Capricorn' : 'Sagittarius';
        }
        throw new \InvalidArgumentException("Invalid month and day: $month , $day");
    }

    /**
     * Load translations
     *
     * @param  string  $lang
     * @return array
     */
    protected function loadTranslation($lang = 'en'): array
    {
        if (!in_array($lang, self::SUPPORTED_LANGS)) {
            $lang = 'en';
        }
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $lang . '.json');

        return json_decode($json, true);
    }

    /**
     * Translate the constellation
     *
     * @param  string   $constellation
     * @param  string   $lang
     * @return string
     */
    protected function translate($constellation, $lang = 'en'): string
    {
        $arr = $this->loadTranslation($lang);

        return isset($arr[$constellation]) ? $arr[$constellation] : '';
    }
}
