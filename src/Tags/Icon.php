<?php

namespace Derteaser\StatamicBladeIcons\Tags;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Statamic\Tags\Tags;

class Icon extends Tags {
    protected static $aliases = ['blade_icon'];
    private function renderBladeToHtml(string $provider, string $icon, Collection $attrs): string {
        $attrsString = $attrs
            ->map(function ($value, $key) {
                $parsedValue = gettype($value) === 'string' ? $value : var_export($value, true);
                return $key . '=' . '"' . $parsedValue . '"';
            })
            ->join(' ');

        $blade = '<x-' . $provider . '-' . $icon . ' ' . $attrsString . ' />';

        try {
            $component = Blade::compileString($blade);
            return Blade::render($component);
        } catch (Exception) {
            logger('Blade Icons: Could not render icon ' . $provider . '-' . $icon . '. Please check if the icon exists.');
            return '';
        }
    }

    private function render(string $provider = null, string $icon = null): string {
        $provider = $provider ?? Str::lower($this->params->get('provider'));
        $icon = $icon ?? Str::lower($this->params->get('icon'));

        $attrs = $this->params->except(['as', 'scope', 'provider', 'icon']);

        return $this->renderBladeToHtml($provider, $icon, $attrs);
    }

    /**
     * The {{ icon }} tag.
     *
     * @return string
     */
    public function index(): string {
        return $this->render();
    }

    /**
     * The {{ icon:raw }} tag.
     *
     * @return string
     */
    public function raw(): string {
        $iconParam = Str::lower($this->params->get('icon'));
        $provider = Str::before($iconParam, '-');
        $icon = Str::after($iconParam, '-');
        return $this->render($provider, $icon);
    }

    /**
     * The {{ icon:lucide }} tag.
     *
     * @return string
     */
    public function lucide(): string {
        return $this->render('lucide');
    }

    /**
     * The {{ icon:si }} tag.
     *
     * @return string
     */
    public function si(): string {
        return $this->render('si');
    }

    /**
     * The {{ icon:by_url }} tag.
     *
     * @return string
     */
    public function byUrl(): string {
        $fallbackIcon = $this->params->get('fallback_icon');
        $fallbackProvider = $this->params->get('fallback_provider');

        $url = trim($this->params->get('url', ''));

        if (strlen($url) === 0) {
            return $this->render($fallbackProvider, $fallbackIcon);
        }

        $host = parse_url($url)['host'];

        if (Str::contains($host, 'zoom.us')) {
            return $this->render('si', 'zoom');
        }

        if (Str::contains($host, 'teams.microsoft.com')) {
            return $this->render('si', 'microsoftteams');
        }

        if (Str::contains($host, 'meet.google.com')) {
            return $this->render('si', 'googlemeet');
        }

        if (Str::contains($host, 'facebook.com')) {
            return $this->render('si', 'facebook');
        }

        return $this->render($fallbackProvider, $fallbackIcon);
    }

    /**
     * The {{ icon:{provider}:{icon} }} tag.
     *
     * @param string $tag
     * @return string
     */
    public function wildcard(string $tag): string {
        [$provider, $icon] = Str::of($tag)
            ->split('/:/')
            ->toArray();
        $icon = Str::kebab($icon);

        return $this->render($provider, $icon);
    }
}
