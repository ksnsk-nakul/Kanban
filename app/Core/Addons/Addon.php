<?php

namespace App\Core\Addons;

final class Addon
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $path,
        public bool $enabled,
        public ?string $providerClass,
    ) {
    }
}

