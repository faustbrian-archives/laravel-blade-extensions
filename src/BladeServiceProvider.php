<?php

/*
 * This file is part of Laravel Blade Extensions.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

/*
 * This file is part of Laravel Blade Extensions.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Blade;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->registerExtensions();
        $this->registerDirectives();
    }

    /**
     * Register "Blade::extend" calls.
     */
    private function registerExtensions(): void
    {
        /*
         * php switch statement.
         */
        Blade::extend(function ($value, $compiler) {
            $value = preg_replace('/(?<=\s)@switch\((.*)\)(\s*)@case\((.*)\)(?=\s)/', '<?php switch($1):$2case $3: ?>', $value);
            $value = preg_replace('/(?<=\s)@endswitch(?=\s)/', '<?php endswitch; ?>', $value);

            $value = preg_replace('/(?<=\s)@case\((.*)\)(?=\s)/', '<?php case $1: ?>', $value);
            $value = preg_replace('/(?<=\s)@default(?=\s)/', '<?php default: ?>', $value);
            $value = preg_replace('/(?<=\s)@break(?=\s)/', '<?php break; ?>', $value);

            return $value;
        });
    }

    /**
     * Register "Blade::directive" calls.
     */
    private function registerDirectives(): void
    {
        /*
         * php json_encode() function.
         *
         * Usage: @json_encode($value)
         */
        Blade::directive('json', function ($expression) {
            return "<?php echo(json_encode($expression)); ?>";
        });

        /*
         * php explode() function.
         *
         * Usage: @explode($delimiter, $string)
         */
        Blade::directive('explode', function ($expression) {
            list($delimiter, $string) = $this->getArguments($expression);

            return "<?php explode({$delimiter}, {$string}); ?>";
        });

        /*
         * php implode() function.
         *
         * Usage: @implode($delimiter, $string)
         */
        Blade::directive('implode', function ($expression) {
            list($delimiter, $array) = $this->getArguments($expression);

            return "<?php echo(implode({$delimiter}, {$array})); ?>";
        });

        /*
         * php var_dump() function.
         *
         * Usage: @var_dump($value)
         */
        Blade::directive('var_dump', function ($expression) {
            return "<?php var_dump({$expression}); ?>";
        });

        /*
         * Set variable.
         *
         * Usage: @set($name, value)
         */
        Blade::directive('set', function ($expression) {
            list($name, $value) = $this->getArguments($expression);

            return "<?php {$name} = {$value}; ?>";
        });

        /*
         * Laravel dd() function.
         *
         * Usage: @dd($value)
         */
        Blade::directive('dd', function ($expression) {
            return "<?php dd({$expression}); ?>";
        });

        /*
         * Laravel camel_case() function.
         *
         * Usage: @camel_case($value)
         */
        Blade::directive('camel_case', function ($expression) {
            return "<?php echo(camel_case({$expression})); ?>";
        });

        /*
         * Laravel class_basename() function.
         *
         * Usage: @class_basename($value)
         */
        Blade::directive('class_basename', function ($expression) {
            return "<?php echo(class_basename({$expression})); ?>";
        });

        /*
         * Laravel e() function.
         *
         * Usage: @e($value)
         */
        Blade::directive('e', function ($expression) {
            return "<?php echo(e({$expression})); ?>";
        });

        /*
         * Laravel ends_with() function.
         *
         * Usage: @ends_with($haystack, $needles)
         */
        Blade::directive('ends_with', function ($expression) {
            return "<?php echo(ends_with({$expression})); ?>";
        });

        /*
         * Laravel snake_case() function.
         *
         * Usage: @snake_case($value)
         */
        Blade::directive('snake_case', function ($expression) {
            return "<?php echo(snake_case({$expression})); ?>";
        });

        /*
         * Laravel str_limit() function.
         *
         * Usage: @str_limit($value, $limit, $end)
         */
        Blade::directive('str_limit', function ($expression) {
            return "<?php echo(str_limit({$expression})); ?>";
        });

        /*
         * Laravel starts_with() function.
         *
         * Usage: @starts_with($haystack, $needles)
         */
        Blade::directive('starts_with', function ($expression) {
            return "<?php echo(starts_with({$expression})); ?>";
        });

        /*
         * Laravel str_contains() function.
         *
         * Usage: @str_contains($haystack, $needles)
         */
        Blade::directive('str_contains', function ($expression) {
            return "<?php echo(str_contains({$expression})); ?>";
        });

        /*
         * Laravel str_finish() function.
         *
         * Usage: @str_finish($value, $cap)
         */
        Blade::directive('str_finish', function ($expression) {
            return "<?php echo(str_finish({$expression})); ?>";
        });

        /*
         * Laravel str_is() function.
         *
         * Usage: @str_is($pattern, $value)
         */
        Blade::directive('str_is', function ($expression) {
            return "<?php echo(str_is({$expression})); ?>";
        });

        /*
         * Laravel str_plural() function.
         *
         * Usage: @str_plural($value, $count)
         */
        Blade::directive('str_plural', function ($expression) {
            return "<?php echo(str_plural({$expression})); ?>";
        });

        /*
         * Laravel str_random() function.
         *
         * Usage: @str_random($length)
         */
        Blade::directive('str_random', function ($expression) {
            return "<?php echo(str_random({$expression})); ?>";
        });

        /*
         * Laravel str_replace_first() function.
         *
         * Usage: @str_replace_first($search, $replace, $subject)
         */
        Blade::directive('str_replace_first', function ($expression) {
            return "<?php echo(str_replace_first({$expression})); ?>";
        });

        /*
         * Laravel str_replace_last() function.
         *
         * Usage: @str_replace_last($search, $replace, $subject)
         */
        Blade::directive('str_replace_last', function ($expression) {
            return "<?php echo(str_replace_last({$expression})); ?>";
        });

        /*
         * Laravel str_singular() function.
         *
         * Usage: @str_singular($value)
         */
        Blade::directive('str_singular', function ($expression) {
            return "<?php echo(str_singular({$expression})); ?>";
        });

        /*
         * Laravel str_slug() function.
         *
         * Usage: @str_slug($title, $separator)
         */
        Blade::directive('str_slug', function ($expression) {
            return "<?php echo(str_slug({$expression})); ?>";
        });

        /*
         * Laravel studly_case() function.
         *
         * Usage: @studly_case($value)
         */
        Blade::directive('studly_case', function ($expression) {
            return "<?php echo(studly_case({$expression})); ?>";
        });

        /*
         * Laravel title_case() function.
         *
         * Usage: @title_case($value)
         */
        Blade::directive('title_case', function ($expression) {
            return "<?php echo(title_case({$expression})); ?>";
        });

        /*
         * Laravel action() function.
         *
         * Usage: @action($path, $secure)
         */
        Blade::directive('action', function ($expression) {
            return "<?php echo(action({$expression})); ?>";
        });

        /*
         * Laravel asset() function.
         *
         * Usage: @asset($path, $secure)
         */
        Blade::directive('asset', function ($expression) {
            return "<?php echo(asset({$expression})); ?>";
        });

        /*
         * Laravel secure_asset() function.
         *
         * Usage: @secure_asset($path)
         */
        Blade::directive('secure_asset', function ($expression) {
            return "<?php echo(secure_asset({$expression})); ?>";
        });

        /*
         * Laravel route() function.
         *
         * Usage: @route($path, $parameters, $absolute)
         */
        Blade::directive('route', function ($expression) {
            return "<?php echo(route({$expression})); ?>";
        });

        /*
         * Laravel secure_url() function.
         *
         * Usage: @secure_url($path, $parameters)
         */
        Blade::directive('secure_url', function ($expression) {
            return "<?php echo(secure_url({$expression})); ?>";
        });

        /*
         * Laravel url() function.
         *
         * Usage: @url($path, $parameters)
         */
        Blade::directive('url', function ($expression) {
            return "<?php echo(url({$expression})); ?>";
        });

        /*
         * Laravel abort() function.
         *
         * Usage: @abort($code, $message, $headers)
         */
        Blade::directive('abort', function ($expression) {
            return "<?php abort({$expression}); ?>";
        });

        /*
         * Laravel abort_if() function.
         *
         * Usage: @abort_if($boolean, $code, $message, $headers)
         */
        Blade::directive('abort_if', function ($expression) {
            return "<?php abort_if({$expression}); ?>";
        });

        /*
         * Laravel abort_unless() function.
         *
         * Usage: @abort_unless($boolean, $code, $message, $headers)
         */
        Blade::directive('abort_unless', function ($expression) {
            return "<?php abort_unless({$expression}); ?>";
        });

        /*
         * Laravel method_field() function.
         *
         * Usage: @method_field($method)
         */
        Blade::directive('method_field', function ($expression) {
            return "<?php echo(method_field({$expression})); ?>";
        });

        /*
         * Laravel env() function.
         *
         * Usage: @env($key, $default)
         */
        Blade::directive('env', function ($expression) {
            return "<?php echo(env({$expression})); ?>";
        });

        /*
         * Laravel bcrypt() function.
         *
         * Usage: @bcrypt($key, $options)
         */
        Blade::directive('bcrypt', function ($expression) {
            return "<?php echo(bcrypt({$expression})); ?>";
        });

        /*
         * Font Awesome helper function.
         *
         * Usage: @title_case($value)
         */
        Blade::directive('icon', function ($expression) {
            $icon = substr($expression, 1, -1);

            return "<?php echo('<i class=\"fa fa-{$icon}\"></i>'); ?>";
        });

        /*
         * Carbon helper function.
         *
         * Usage: @carbon($value, $format)
         */
        Blade::directive('carbon', function ($expression) {
            list($value, $format) = $this->getArguments($expression);

            return "<?php echo((new Carbon\Carbon({$value}))->format($format)); ?>";
        });
    }

    /**
     * Get an array from an expression.
     *
     * @param string $expression
     *
     * @return array
     */
    private function getArguments($expression): array
    {
        return explode(', ', str_replace(['(', ')'], '', $expression));
    }
}
