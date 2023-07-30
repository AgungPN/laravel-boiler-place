<?php

use Illuminate\Support\Carbon;
use Symfony\Component\Uid\Ulid;

if (!function_exists('generateUlid')) {
    /**
     * generate ulid
     *
     * @return string
     */
    function generateUlid(): string
    {
        return Ulid::generate();
    }
}

if (!function_exists('searchOnArray')) {
    function searchOnArray($array, $search, $key)
    {
        return array_search($search, array_column($array, $key));
    }
}

if (!function_exists('convertBoolen')) {
    function convertBoolean($data)
    {
        return filter_var($data, FILTER_VALIDATE_BOOLEAN);
    }
}

if (!function_exists('removeValueFromArray')) {
    function removeValueFromArray($array, $removeValue)
    {
        if (($key = array_search($removeValue, $array)) !== false) {
            unset($array[$key]);
        }
        return $array;
    }
}

function sortArray($array, $column)
{
    array_multisort(array_map(function ($element) use ($column) {
        return $element[$column];
    }, $array), SORT_ASC, $array);
    return $array;
}

if (!function_exists('array_rename_key')) {
    /**
     * rename the name key array
     *
     * @param array $array
     * @param string $oldKey
     * @param string $newKey
     * @param bool $removeOldKey
     * @return array
     */
    function array_rename_key(array $array, string $oldKey, string $newKey, bool $removeOldKey = true): array
    {
        if (isset($array[$oldKey])) {
            $array[$newKey] = $array[$oldKey];
            if ($removeOldKey)
                unset($array[$oldKey]);
        }
        return $array;
    }
}

if (!function_exists('is_json_string')) {
    /**
     * Check whether string is JSON.
     *
     * @param mixed $checked
     * @return bool
     */
    function is_json_string(mixed $checked): bool
    {
        if (!is_string($checked)) {
            return false;
        }

        // decode the JSON data
        json_decode($checked);

        // switch and check possible JSON errors
        $error = match (json_last_error()) {
            JSON_ERROR_NONE => false,
            default => true,
        };
        return $error === false;
    }
}


if (!function_exists('urlWithParams')) {
    /**
     * Make the reverse of the boolean statement.
     *
     * @param $url
     * @param array $params
     * @return string
     */
    function urlWithParams($url, array $params): string
    {
        $index = 0;
        foreach ($params as $paramName => $paramValue) {
            if ($index == 0) {
                $url .= '?' . $paramName . '=' . $paramValue;
            } else {
                $url .= '&' . $paramName . '=' . $paramValue;
            }
            $index++;
        }
        return $url;
    }
}


if (!function_exists('is_not_null')) {
    /**
     * is not null
     * reverse of is_null
     *
     * @param mixed $value
     * @return bool
     */
    function is_not_null(mixed $value): bool
    {
        return !is_null($value);
    }
}
if (!function_exists('is_first_day_in_month')) {
    /**
     * is first day in month
     *
     * @param Carbon $carbon
     * @return bool
     */
    function is_first_day_in_month(Carbon $carbon): bool
    {
        $date1 = $carbon->format("d");
        $date2 = today()->firstOfMonth()->format("d");

        return $date1 === $date2;
    }
}

if (!function_exists('setTimestamps')) {
    /**
     * set created_at and updated_at timestamps
     *
     * @param Carbon|null $carbon
     * @return array
     */
    function setTimestamps(?Carbon $carbon = null): array
    {
        $now = $carbon ?? now();
        return ['created_at' => $now, 'updated_at' => $now];
    }
}
if (!function_exists('setIdAndTimestamps')) {
    /**
     * set timestamps and id for insert
     *
     * @param Carbon|null $carbon
     * @return array
     */
    function setIdAndTimestamps(?Carbon $carbon = null): array
    {
        $now = $carbon ?? now();
        return ['created_at' => $now, 'updated_at' => $now, 'id' => generateUlid()];
    }
}

if (!function_exists('createCarbon')) {
    /**
     * create carbon by date
     *
     * @param mixed $date
     * @param string|null $format
     * @return Carbon|null
     */
    function createCarbon(mixed $date, ?string $format = "Y-m-d"): ?Carbon
    {
        return Carbon::createFromFormat($format, $date);
    }
}


if (!function_exists('falsyStr')) {
    /**
     * check is value  falsy
     * will return true example value: 0, false, "", "  ", null
     *
     * @param null $str
     * @param bool|null $isCheckStringValue
     * @return bool
     */
    function falsyStr($str = null, ?bool $isCheckStringValue = false): bool
    {
        $isNotStr = !isset($str) || trim($str) == '';
        if ($isCheckStringValue && !$isNotStr) {
            $invalidStr = ['null', 'undefined'];
            $isNotStr = in_array($str, $invalidStr);
        }
        return $isNotStr;
    }
}
if (!function_exists('trustyStr')) {
    /**
     * check is value  trusty
     *
     * @param $str
     * @return bool
     */
    function trustyStr($str = null): bool
    {
        return !falsyStr($str);
    }
}

if (!function_exists('arrayGetParentKey')) {
    /**
     * get parent key from child value on array
     *
     * @param array $parrentArray
     * @param mixed $searchValue
     * @return string|int|null
     */
    function arrayGetParentKey(array $parrentArray, mixed $searchValue): string|int|null
    {
        $parentKey = null;

        foreach ($parrentArray as $key => $value) {
            if (in_array($searchValue, $value)) {
                $parentKey = $key;
                break;
            }
        }

        return $parentKey;
    }
}

if (!function_exists('generatePhoneNumberID')) {
    /**
     * generate 62 phone number
     */
    function generatePhoneNumberID(): string
    {
        return '628' . fake()->numerify('##########');
    }
}

if (!function_exists('moneyFormatIdr')) {
    /**
     * format idr money
     */
    function moneyFormatIdr(int|float $amount): string
    {
        return 'Rp. ' . number_format($amount, 0, ',', '.');
    }
}
if (!function_exists('formatNumber')) {
    /**
     * format number
     * @param int $number
     * @return string
     * @example 1000 to 1K
     *
     */
    function formatNumber(int $number): string
    {
        {
            $suffixes = ['', 'K', 'M', 'B', 'T'];
            $suffixIndex = 0;

            while ($number >= 1000) {
                $number /= 1000;
                $suffixIndex++;
            }

            return round($number, 1) . $suffixes[$suffixIndex];
        }
    }
}

/**
 * Get the first character of a string
 *
 * @param string $string
 * @return string
 */
if (!function_exists('first_character')) {
    function first_character(string $string): string
    {
        return substr($string, 1);
    }
}

/**
 * Get the last character of a string
 *
 * @param string $string
 * @return string
 */
if (!function_exists('last_character')) {
    function last_character(string $string): string
    {
        return substr($string, -1);
    }
}

/**
 * Concat paths
 *
 * @param array $paths
 * @param bool $startSlash
 * @param bool $endSlash
 * @return string
 */
if (!function_exists('concat_paths')) {
    function concat_paths(
        array $paths,
        bool  $startSlash = false,
        bool  $endSlash = false
    ): string
    {
        $paths = array_map(function ($path) {
            // Remove / in first character
            if ($path) {
                if (first_character($path) == '/') {
                    $path = substr($path, 1);
                }

                // Remove / in last character
                if (last_character($path) == '/') {
                    $path = substr($path, 0, -1);
                }
            }


            return $path;
        }, $paths);

        $result = implode('/', $paths);
        if ($startSlash) $result = '/' . $result;
        if ($endSlash) $result .= '/';

        return $result;
    }
}

if (!function_exists('test_path')) {
    /**
     * Get the test folder relative path.
     *
     * @param string $path
     * @return string
     */
    function test_path(string $path = ''): string
    {
        return concat_paths(
            [base_path(), 'tests', $path]
        );
    }
}
