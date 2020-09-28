<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7427332bdedc4974133979586ba82b8d
{
    public static $files = array (
        '2de9cbadae1794eca6740523da3de318' => __DIR__ . '/../..' . '/Core/Config.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Source\\' => 7,
        ),
        'C' => 
        array (
            'CoffeeCode\\Router\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Source\\' => 
        array (
            0 => __DIR__ . '/../..' . '/source',
        ),
        'CoffeeCode\\Router\\' => 
        array (
            0 => __DIR__ . '/..' . '/coffeecode/router/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7427332bdedc4974133979586ba82b8d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7427332bdedc4974133979586ba82b8d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
