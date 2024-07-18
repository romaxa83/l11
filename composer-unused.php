<?php

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;

return static function (Configuration $config): Configuration {
    $config
        // деякий коментар, чому пакет використовується
        ->addNamedFilter(NamedFilter::fromString('opcodesio/log-viewer'))
        ->addNamedFilter(NamedFilter::fromString('sebastian/diff'))
    ;

    return $config;
};
