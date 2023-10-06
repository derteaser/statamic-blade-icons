<?php

namespace Derteaser\StatamicBladeIcons;

use Derteaser\StatamicBladeIcons\Fieldtypes\IconPicker;
use Derteaser\StatamicBladeIcons\Tags\Icon;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider {
    protected $fieldtypes = [IconPicker::class];
    protected $tags = [Icon::class];
    protected $vite = [
        'input' => ['resources/js/blade-icon-picker.js'],
        'hotFile' => 'dist/vite.hot',
        'publicDirectory' => 'dist',
    ];
}
