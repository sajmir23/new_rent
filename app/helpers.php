<?php

use App\Models\User;
use App\Support\Helper;
use App\Support\Sanitize;
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;

if (! function_exists('user')) {
    function user(): Authenticatable|User|null
    {
        if (auth('web')->user() instanceof User) {
            return auth('web')->user();
        }

        return null;
    }
}

// ToDo: Uncomment this when you have a customer model
//if (! function_exists('customer')) {
//    function user(): Authenticatable|Customer|null
//    {
//        if (auth('customer_web')->user() instanceof Customer) {
//            return auth('customer_web')->user();
//        }
//
//        return null;
//    }
//}

if (! function_exists('current_agent')) {
    function current_agent(): Agent
    {
        $agent = new Agent();

        $agent->setUserAgent(request()->userAgent());

        return $agent;
    }
}

if (! function_exists('active_url')) {
    function active_url(string $url, string $returnClass = 'active'): string
    {
        return request()->is($url) ? $returnClass : '';
    }
}

if (! function_exists('active_route')) {
    function active_route(string $route, string $returnClass = 'active'): string
    {
        return request()->route()->getName() === $route ? $returnClass : '';
    }
}

if (! function_exists('active_routes')) {
    function active_routes(array $routes = [], string $returnClass = 'active'): string
    {
        $isActive = false;

        foreach ($routes as $route) {
            if (request()->route()->getName() === $route) {
                $isActive = true;
                break;
            }
        }

        return $isActive ? $returnClass : '';
    }
}

if (! function_exists('in_url')) {
    function in_url(string $url, string $returnClass = 'active'): string
    {
        return request()->is($url) ? $returnClass : '';
    }
}

if (! function_exists('keyword_to_array')) {
    function keyword_to_array(?string $keyword, string $startSearch = '', string $endSearch = '%', ?bool $useWildcards = false): array
    {
        $keywords = [];

        collect(str_getcsv($keyword, ' ', '"'))
            ->filter()
            ->each(function ($term) use (&$keywords, $startSearch, $endSearch, $useWildcards) {
                $term = Sanitize::sanitize($term);
                $word = str_replace(['%', '_'], ['\\%', '\\_'], $term);

                $searchTerm = (
                (@$word[0] == '-')
                    ? ($startSearch . ltrim($word, '-') . $endSearch)
                    : ($startSearch . $word . $endSearch)
                );

                if ($useWildcards) {
                    $keywords[] = str_replace(' ', '%', $searchTerm);
                } else {
                    $keywords[] = $searchTerm;
                }
            });

        return $keywords;
    }
}

if (! function_exists('random_color_part')) {
    function random_color_part(): string
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }
}

if (! function_exists('random_color')) {
    function random_color(): string
    {
        return '#'.random_color_part() . random_color_part() . random_color_part();
    }
}

if (! function_exists('get_sql_query')) {
    function get_sql_query($builder): string
    {
        $addSlashes = str_replace('?', "'?'", $builder->toSql());
        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }
}

if (! function_exists('remove_multiple_spaces')) {
    function remove_multiple_spaces(?string $string): ?string
    {
        return preg_replace('!\s+!', ' ', trim($string));
    }
}

if (! function_exists('clean_mobile_number')) {
    /**
     * Cleans the Mobile number by removing multiple spaces, all special characters except numbers and + sign
     *
     * @param string|null $mobileNumber
     *
     * @return string|null
     *
     * @example clean_mobile_number("+1 (584) 374-7906") => +15843747906
     */
    function clean_mobile_number(?string $mobileNumber): ?string
    {
        return preg_replace('/[^0-9+]/', '', $mobileNumber);
    }
}

if (! function_exists('locale')) {
    function locale(): string
    {
        return app()->getLocale();
    }
}


if (! function_exists('number_format_short')) {
    function number_format_short($value, $precision = 1): string
    {
        // 1 - 999 [$value > 0 && $value < 900]
        $n_format = number_format($value, $precision);
        $suffix = '';
        if ($value >= 900 && $value < 1000000) {
            // 0.9k-999k
            $n_format = number_format($value / 1000, $precision);
            $suffix = 'K';
        } elseif ($value >= 1000000 && $value < 1000000000) {
            // 1m-999m
            $n_format = number_format($value / 1000000, $precision);
            $suffix = 'M';
        } elseif ($value >= 1000000000 && $value < 1000000000000) {
            // 1b-999b
            $n_format = number_format($value / 1000000000, $precision);
            $suffix = 'B';
        } elseif ($value >= 1000000000000) {
            // 0.9t+
            $n_format = number_format($value / 1000000000000, $precision);
            $suffix = 'T';
        }

        // Remove necessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotZero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotZero, '', $n_format);
        }

        return ! empty($n_format.$suffix) ? $n_format.$suffix : 0;
    }
}

if (! function_exists('class_has_trait')) {
    /**
     * Check if a class has a specific trait
     *
     * @param object|string $className
     * @param string $traitName
     *
     * @return bool
     *
     * @example class_has_trait(new User(), 'Draftable')
     * @example class_has_trait(User::class, 'App\Models\Concerns\HasDebts')
     */
    function class_has_trait(object|string $className, string $traitName): bool
    {
        if (is_object($className)) {
            $className = get_class($className);
        }

        # FOR FULLY QUALIFIED CLASS NAMES
        //return in_array($traitName, class_uses_recursive($className));

        $traits = class_uses_recursive($className);

        foreach ($traits as $trait) {
            $shortTraitName = null;

            try {
                $reflect = new ReflectionClass($trait);
                $shortTraitName = $reflect->getShortName();
            } catch(ReflectionException $e) {
                return false;
            }

            if ($shortTraitName === $traitName) {
                return true;
            } elseif ($trait === $traitName) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('get_models_collection')) {
    function get_models_collection(): Collection
    {
        $models = collect(File::allFiles(app_path()))
            ->map(function ($item) {
                $path = $item->getRelativePathName();
                return sprintf(
                    '\%s%s',
                    Container::getInstance()->getNamespace(),
                    strtr(substr($path, 0, strrpos($path, '.')), '/', '\\')
                );
            })
            ->filter(function ($class) {
                $valid = false;

                if (class_exists($class)) {
                    $reflection = new \ReflectionClass($class);
                    $valid = $reflection->isSubclassOf(Model::class) && !$reflection->isAbstract();
                }

                return $valid;
            });

        return $models->values();
    }
}

if (! function_exists('get_models_with_trait')) {
    function get_models_with_trait(string $traitName): array
    {
        return Cache::remember('models_with_trait', 86400, function () use ($traitName) {
            return get_models_collection()
                ->map(function ($model) use ($traitName) {
                    $modelData = [];

                    if (! is_object($model)) {
                        $model = app($model);
                    }

                    if (class_has_trait($model, $traitName)) {
                        $modelData = [Helper::getClassName($model) => __(Helper::getClassName($model).'.singular')];
                    }

                    return $modelData;
                })
                ->collapse()
                ->filter()
                ->toArray();
        });
    }
}

if (! function_exists('display_price')) {
    /**
     * display_price
     * convert price with decimals and separator
     *
     * @param float|int|string|null $price
     * @param int $precision
     * @param string|null $symbol
     *
     * @return string
     * @$price - Added hack in for when the variants are being created it passes over the new ISO currency code
     * which breaks number_format
     */
    function display_price(float|int|string|null $price, int $precision = 2, ?string $symbol = ''): string
    {
        if ($price === '') {
            return 0;
        }

        if ($price === null) {
            return 0;
        }

        if (! is_numeric($price)) {
            return $price;
        }

        $price =  preg_replace("/^([0-9]+\.?[0-9]*)(\s[A-Z]{3})$/", "$1", (string)$price);

        if ($symbol !== null && $symbol !== '') {
            return number_format(round((float)$price, $precision), $precision).' '.$symbol;
        }

        return number_format(round((float)$price, $precision), $precision);
    }
}

if (! function_exists('roman_year')) {
    function roman_year(int $year = null): string
    {
        $year = $year ?? date('Y');

        $romanNumerals = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        ];

        $result = '';

        foreach ($romanNumerals as $roman => $yearNumber) {
            // Divide to get  matches
            $matches = (int)($year / $yearNumber);

            // Assign the roman char * $matches
            $result .= str_repeat($roman, $matches);

            // Subtract from the number
            $year %= $yearNumber;
        }

        return $result;
    }
}

if (!function_exists('humanFilesize')) {
    /**
     * Show Human readable file size
     * @param int $bytes
     * @param int $precision
     * @return string
     * @oaram int $precision
     */
    function humanFilesize(int $bytes, int $precision = 2): string
    {
        $units = ['b', 'Kb', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $step = 1024;

        for ($i=0; $bytes > $step; $i++) {
            $bytes /= $step;
        }
        return round($bytes, $precision) . $units[$i];
    }
}

if (!function_exists('str_tease')) {
    /**
     * Shortens a string in a pretty way. It will clean it by trimming
     * it, remove all double spaces and html. If the string is then still
     * longer than the specified $length it will be shortened. The end
     * of the string is always a full word concatenated with the
     * specified moreTextIndicator.
     *
     * @param string $string
     * @param int    $length
     * @param string $moreTextIndicator
     *
     * @return string
     */
    function str_tease(string $string, int $length = 200, string $moreTextIndicator = '...'): string
    {
        $string = trim($string);
        //remove html
        $string = strip_tags($string);
        //replace multiple spaces
        $string = (string)preg_replace("/\s+/", ' ', $string);

        if (strlen($string) == 0) {
            return '';
        }

        if (strlen($string) <= $length) {
            return $string;
        }

        $ww = wordwrap($string, $length, "\n");

        return substr($ww, 0, (int) strpos($ww, "\n")).$moreTextIndicator;
    }
}

if (! function_exists('getNWords')) {
    /**
     * Limit content with number of words
     *
     * @param string|null $string $string
     * @param int $n
     * @param bool $withDots
     *
     * @return string|null
     */
    function getNWords(string $string = null, int $n = 5, bool $withDots = true): ?string
    {
        if ($string === null) {
            return null;
        }

        $excerpt = explode(' ', strip_tags($string), $n + 1);
        $wordCount = count($excerpt);
        if ($wordCount >= $n) {
            array_pop($excerpt);
        }
        $excerpt = implode(' ', $excerpt);
        if ($withDots && $wordCount >= $n) {
            $excerpt .= '...';
        }
        return $excerpt;
    }
}

if (! function_exists('truthy_values')) {
    function truthy_values(): array
    {
        return ['true', 'yes', 'on', '1', 1];
    }
}

if (! function_exists('falsy_values')) {
    function falsy_values(): array
    {
        return ['false', 'no', 'off', '0',  0];
    }
}

if (!function_exists('route_from_string')) {
    function route_from_string($routeName, $routeParameter, $modelId): string
    {
        try {
            return Route::has("{$routeName}") ? route($routeName, [$routeParameter => $modelId]) : "javascript:void(0);";
        } catch (Exception $e) {
            return "javascript:void(0);";
        }
    }
}

if (!function_exists('serial_generator')) {
    function serial_generator(string|int $input, int $pad_len = 8, ?string $prefix = null): string
    {
        if ($pad_len <= strlen($input)) {
            trigger_error("Pad Lengthstrong>{$pad_len}</strong> cannot be less than or equal to the length of <strong>{$input}</strong> to generate serial number", E_USER_ERROR);
        }

        if (is_string($prefix)) {
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
        }

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }
}
