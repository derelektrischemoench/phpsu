<?php
declare(strict_types=1);

namespace PHPSu\Helper;

final class StringHelper
{
    /**
     * @param string $string
     * @param int $maxLength
     * @return string[]
     */
    public static function splitString(string $string, int $maxLength): array
    {
        $exploded = explode(' ', $string);
        $full = array_shift($exploded);
        while (count($exploded)) {
            $part = array_shift($exploded);
            if (strlen($full . ' ' . $part) > $maxLength) {
                array_unshift($exploded, $part);
                $result = [$full];
                array_push($result, ...static::splitString(implode(' ', $exploded), $maxLength));
                return $result;
            }
            $full .= ' ' . $part;
        }
        return [$full];
    }
}