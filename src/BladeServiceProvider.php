<?php

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
use Illuminate\View\Compilers\BladeCompiler;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerExtensions();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerDirectives();
    }

    /**
     * Register "Blade::extend" calls.
     */
    private function registerExtensions()
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
    private function registerDirectives()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            /*
             * Auth helper function.
             *
             * Usage: @auth() ... @endauth
             */
            $bladeCompiler->directive('auth', function () {
                return '<?php if(auth()->check()): ?>';
            });
            $bladeCompiler->directive('endauth', function () {
                return '<?php endif; ?>';
            });

            /*
             * Guest helper function.
             *
             * Usage: @guest() ... @endguest
             */
            $bladeCompiler->directive('guest', function () {
                return '<?php if(auth()->guest()): ?>';
            });
            $bladeCompiler->directive('endguest', function () {
                return '<?php endif; ?>';
            });

            /*
             * php json_encode() function.
             *
             * Usage: @json_encode($value)
             */
            $bladeCompiler->directive('json', function ($expression) {
                return "<?php echo(json_encode($expression)); ?>";
            });

            /*
             * php explode() function.
             *
             * Usage: @explode($delimiter, $string)
             */
            $bladeCompiler->directive('explode', function ($expression) {
                list($delimiter, $string) = $this->getArguments($expression);

                return "<?php explode({$delimiter}, {$string}); ?>";
            });

            /*
             * php implode() function.
             *
             * Usage: @implode($delimiter, $string)
             */
            $bladeCompiler->directive('implode', function ($expression) {
                list($delimiter, $array) = $this->getArguments($expression);

                return "<?php echo(implode({$delimiter}, {$array})); ?>";
            });

            /*
             * php var_dump() function.
             *
             * Usage: @var_dump($value)
             */
            $bladeCompiler->directive('var_dump', function ($expression) {
                return "<?php var_dump({$expression}); ?>";
            });

            /*
             * Set variable.
             *
             * Usage: @set($name, value)
             */
            $bladeCompiler->directive('set', function ($expression) {
                list($name, $value) = $this->getArguments($expression);

                return "<?php {$name} = {$value}; ?>";
            });

            /*
             * Laravel dd() function.
             *
             * Usage: @dd($value)
             */
            $bladeCompiler->directive('dd', function ($expression) {
                return "<?php dd({$expression}); ?>";
            });

            /*
             * Laravel camel_case() function.
             *
             * Usage: @camel_case($value)
             */
            $bladeCompiler->directive('camel_case', function ($expression) {
                return "<?php echo(camel_case({$expression})); ?>";
            });

            /*
             * Laravel class_basename() function.
             *
             * Usage: @class_basename($value)
             */
            $bladeCompiler->directive('class_basename', function ($expression) {
                return "<?php echo(class_basename({$expression})); ?>";
            });

            /*
             * Laravel e() function.
             *
             * Usage: @e($value)
             */
            $bladeCompiler->directive('e', function ($expression) {
                return "<?php echo(e({$expression})); ?>";
            });

            /*
             * Laravel ends_with() function.
             *
             * Usage: @ends_with($haystack, $needles)
             */
            $bladeCompiler->directive('ends_with', function ($expression) {
                return "<?php echo(ends_with({$expression})); ?>";
            });

            /*
             * Laravel snake_case() function.
             *
             * Usage: @snake_case($value)
             */
            $bladeCompiler->directive('snake_case', function ($expression) {
                return "<?php echo(snake_case({$expression})); ?>";
            });

            /*
             * Laravel str_limit() function.
             *
             * Usage: @str_limit($value, $limit, $end)
             */
            $bladeCompiler->directive('str_limit', function ($expression) {
                return "<?php echo(str_limit({$expression})); ?>";
            });

            /*
             * Laravel starts_with() function.
             *
             * Usage: @starts_with($haystack, $needles)
             */
            $bladeCompiler->directive('starts_with', function ($expression) {
                return "<?php echo(starts_with({$expression})); ?>";
            });

            /*
             * Laravel str_contains() function.
             *
             * Usage: @str_contains($haystack, $needles)
             */
            $bladeCompiler->directive('str_contains', function ($expression) {
                return "<?php echo(str_contains({$expression})); ?>";
            });

            /*
             * Laravel str_finish() function.
             *
             * Usage: @str_finish($value, $cap)
             */
            $bladeCompiler->directive('str_finish', function ($expression) {
                return "<?php echo(str_finish({$expression})); ?>";
            });

            /*
             * Laravel str_is() function.
             *
             * Usage: @str_is($pattern, $value)
             */
            $bladeCompiler->directive('str_is', function ($expression) {
                return "<?php echo(str_is({$expression})); ?>";
            });

            /*
             * Laravel str_plural() function.
             *
             * Usage: @str_plural($value, $count)
             */
            $bladeCompiler->directive('str_plural', function ($expression) {
                return "<?php echo(str_plural({$expression})); ?>";
            });

            /*
             * Laravel str_random() function.
             *
             * Usage: @str_random($length)
             */
            $bladeCompiler->directive('str_random', function ($expression) {
                return "<?php echo(str_random({$expression})); ?>";
            });

            /*
             * Laravel str_replace_first() function.
             *
             * Usage: @str_replace_first($search, $replace, $subject)
             */
            $bladeCompiler->directive('str_replace_first', function ($expression) {
                return "<?php echo(str_replace_first({$expression})); ?>";
            });

            /*
             * Laravel str_replace_last() function.
             *
             * Usage: @str_replace_last($search, $replace, $subject)
             */
            $bladeCompiler->directive('str_replace_last', function ($expression) {
                return "<?php echo(str_replace_last({$expression})); ?>";
            });

            /*
             * Laravel str_singular() function.
             *
             * Usage: @str_singular($value)
             */
            $bladeCompiler->directive('str_singular', function ($expression) {
                return "<?php echo(str_singular({$expression})); ?>";
            });

            /*
             * Laravel str_slug() function.
             *
             * Usage: @str_slug($title, $separator)
             */
            $bladeCompiler->directive('str_slug', function ($expression) {
                return "<?php echo(str_slug({$expression})); ?>";
            });

            /*
             * Laravel studly_case() function.
             *
             * Usage: @studly_case($value)
             */
            $bladeCompiler->directive('studly_case', function ($expression) {
                return "<?php echo(studly_case({$expression})); ?>";
            });

            /*
             * Laravel title_case() function.
             *
             * Usage: @title_case($value)
             */
            $bladeCompiler->directive('title_case', function ($expression) {
                return "<?php echo(title_case({$expression})); ?>";
            });

            /*
             * Laravel action() function.
             *
             * Usage: @action($path, $secure)
             */
            $bladeCompiler->directive('action', function ($expression) {
                return "<?php echo(action({$expression})); ?>";
            });

            /*
             * Laravel asset() function.
             *
             * Usage: @asset($path, $secure)
             */
            $bladeCompiler->directive('asset', function ($expression) {
                return "<?php echo(asset({$expression})); ?>";
            });

            /*
             * Laravel secure_asset() function.
             *
             * Usage: @secure_asset($path)
             */
            $bladeCompiler->directive('secure_asset', function ($expression) {
                return "<?php echo(secure_asset({$expression})); ?>";
            });

            /*
             * Laravel route() function.
             *
             * Usage: @route($path, $parameters, $absolute)
             */
            $bladeCompiler->directive('route', function ($expression) {
                return "<?php echo(route({$expression})); ?>";
            });

            /*
             * Laravel secure_url() function.
             *
             * Usage: @secure_url($path, $parameters)
             */
            $bladeCompiler->directive('secure_url', function ($expression) {
                return "<?php echo(secure_url({$expression})); ?>";
            });

            /*
             * Laravel url() function.
             *
             * Usage: @url($path, $parameters)
             */
            $bladeCompiler->directive('url', function ($expression) {
                return "<?php echo(url({$expression})); ?>";
            });

            /*
             * Laravel abort() function.
             *
             * Usage: @abort($code, $message, $headers)
             */
            $bladeCompiler->directive('abort', function ($expression) {
                return "<?php abort({$expression}); ?>";
            });

            /*
             * Laravel abort_if() function.
             *
             * Usage: @abort_if($boolean, $code, $message, $headers)
             */
            $bladeCompiler->directive('abort_if', function ($expression) {
                return "<?php abort_if({$expression}); ?>";
            });

            /*
             * Laravel abort_unless() function.
             *
             * Usage: @abort_unless($boolean, $code, $message, $headers)
             */
            $bladeCompiler->directive('abort_unless', function ($expression) {
                return "<?php abort_unless({$expression}); ?>";
            });

            /*
             * Laravel method_field() function.
             *
             * Usage: @method_field($method)
             */
            $bladeCompiler->directive('method_field', function ($expression) {
                return "<?php echo(method_field({$expression})); ?>";
            });

            /*
             * Laravel env() function.
             *
             * Usage: @env($key, $default)
             */
            $bladeCompiler->directive('env', function ($expression) {
                return "<?php echo(env({$expression})); ?>";
            });

            /*
             * Laravel bcrypt() function.
             *
             * Usage: @bcrypt($key, $options)
             */
            $bladeCompiler->directive('bcrypt', function ($expression) {
                return "<?php echo(bcrypt({$expression})); ?>";
            });

            /*
             * Font Awesome helper function.
             *
             * Usage: @title_case($value)
             */
            $bladeCompiler->directive('icon', function ($expression) {
                $icon = substr($expression, 1, -1);

                return "<?php echo('<i class=\"fa fa-{$icon}\"></i>'); ?>";
            });

            /*
             * Carbon helper function.
             *
             * Usage: @carbon($value, $format)
             */
            $bladeCompiler->directive('carbon', function ($expression) {
                list($value, $format) = $this->getArguments($expression);

                return "<?php echo((new Carbon\Carbon({$value}))->format($format)); ?>";
            });
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
