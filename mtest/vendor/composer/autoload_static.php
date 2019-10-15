<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc08533a077214d199e040e3d6fd850d5
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc08533a077214d199e040e3d6fd850d5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc08533a077214d199e040e3d6fd850d5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
