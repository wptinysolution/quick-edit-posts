<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita65784dd18c5c3b545b344765c7eef10
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TinySolutions\\pqe\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TinySolutions\\pqe\\' => 
        array (
            0 => __DIR__ . '/../..' . '/TinyApp',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'TinySolutions\\pqe\\Controllers\\Admin\\AdminMenu' => __DIR__ . '/../..' . '/TinyApp/Controllers/Admin/AdminMenu.php',
        'TinySolutions\\pqe\\Controllers\\Admin\\Api' => __DIR__ . '/../..' . '/TinyApp/Controllers/Admin/Api.php',
        'TinySolutions\\pqe\\Controllers\\AssetsController' => __DIR__ . '/../..' . '/TinyApp/Controllers/AssetsController.php',
        'TinySolutions\\pqe\\Controllers\\Dependencies' => __DIR__ . '/../..' . '/TinyApp/Controllers/Dependencies.php',
        'TinySolutions\\pqe\\Controllers\\Hooks\\ActionHooks' => __DIR__ . '/../..' . '/TinyApp/Controllers/Hooks/ActionHooks.php',
        'TinySolutions\\pqe\\Controllers\\Hooks\\FilterHooks' => __DIR__ . '/../..' . '/TinyApp/Controllers/Hooks/FilterHooks.php',
        'TinySolutions\\pqe\\Controllers\\Installation' => __DIR__ . '/../..' . '/TinyApp/Controllers/Installation.php',
        'TinySolutions\\pqe\\Helpers\\Fns' => __DIR__ . '/../..' . '/TinyApp/Helpers/Fns.php',
        'TinySolutions\\pqe\\Traits\\SingletonTrait' => __DIR__ . '/../..' . '/TinyApp/Traits/SingletonTrait.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita65784dd18c5c3b545b344765c7eef10::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita65784dd18c5c3b545b344765c7eef10::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita65784dd18c5c3b545b344765c7eef10::$classMap;

        }, null, ClassLoader::class);
    }
}
