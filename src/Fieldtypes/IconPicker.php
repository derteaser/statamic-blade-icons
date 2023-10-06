<?php

namespace Derteaser\StatamicBladeIcons\Fieldtypes;

use BladeUI\Icons\Factory as IconFactory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Statamic\Fields\Fieldtype;

class IconPicker extends Fieldtype {
    protected $icon = 'select';
    protected $categories = ['media', 'special'];

    public function preload(): array {
        $iconsFactory = App::make(IconFactory::class);
        $sets = collect($iconsFactory->all());
        $icons = [];

        foreach ($sets as $set) {
            $prefix = $set['prefix'];
            foreach ($set['paths'] as $path) {
                foreach (File::files($path) as $file) {
                    $filename = $prefix . '-' . $file->getFilenameWithoutExtension();
                    $svg = file_get_contents($file->getRealPath());

                    $icons[$filename] = $svg;
                }
            }
        }

        ksort($icons);

        return ['icons' => $icons];
    }
}
