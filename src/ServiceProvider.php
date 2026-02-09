<?php

namespace Derteaser\StatamicBladeIcons;

use Derteaser\StatamicBladeIcons\Tags\Icon;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider {
    protected $tags = [Icon::class];
}
