<?php

namespace App\Services;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * @codeCoverageIgnore
 *
 * @infection-ignore-all
 */
class ProjectStructure
{
    public static function filesInModuleSubDir(string $subDirName): array
    {
        $modulesPath = base_path('Modules');
        $modulesDirectories = glob($modulesPath . '/*', GLOB_ONLYDIR);
        $directories = array_map(
            fn ($path) => $path .'/' . $subDirName,
            $modulesDirectories
        );

        $result = [];
        foreach ($directories as $directory) {
            if (! is_dir($directory)) {
                continue;
            }
            $result = [
                ...$result,
                ...self::filesInDirectory($directory),
            ];
        }
        return $result;
    }
    private static function filesInDirectory(string $directoryPath): array
    {
        $directoryIterator = new RecursiveDirectoryIterator($directoryPath);
        $recursiveIterator = new RecursiveIteratorIterator($directoryIterator);

        $files = [];

        foreach ($recursiveIterator as $file) {
            if (! $file->isDir()) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }
}
