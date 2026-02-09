# Statamic Blade Icons

A Statamic addon that adds a simple `{{ icon }}` tag for rendering [Blade Icons] components in your Statamic templates.

## Features

- Render any registered Blade Icon set from Antlers.
- Multiple tag styles: `{{ icon }}`, `{{ icon:raw }}`, `{{ icon:by_url }}`, and wildcard tags.
- Pass arbitrary attributes through to the icon component (classes, size, etc.).

## Requirements

- PHP 8.1+
- Statamic 4, 5, or 6
- `blade-ui-kit/blade-icons`

## Installation

```bash
composer require derteaser/statamic-blade-icons
```

## Usage

### Basic tag

```antlers
{{ icon provider="heroicon" icon="academic-cap" class="w-5 h-5 text-slate-600" }}
```

### Alias

```antlers
{{ blade_icon provider="heroicon" icon="academic-cap" class="w-5 h-5" }}
```

### Wildcard tag

```antlers
{{ icon:heroicon:academic-cap class="w-5 h-5" }}
```

### Raw tag (single parameter)

Use a single `icon` parameter in the format `{provider}-{icon}`.

```antlers
{{ icon:raw icon="heroicon-academic-cap" class="w-5 h-5" }}
```

### By URL tag

Render a specific icon based on the URL host, otherwise fall back to a provided icon.

```antlers
{{ icon:by_url
   url="https://meet.google.com/abc"
   fallback_provider="heroicon"
   fallback_icon="link"
   class="size-5"
}}
```

Currently mapped hosts:

- `zoom.us` -> `si-zoom`
- `teams.microsoft.com` -> `si-microsoftteams`
- `meet.google.com` -> `si-googlemeet`
- `facebook.com` -> `si-facebook`

## Attributes

All additional parameters are passed through as Blade component attributes. For example:

```antlers
{{ icon:heroicon:academic-cap class="size-5" aria-hidden="true" }}
```

## Registering Icon Sets

This addon relies on the Blade Icons package. Register icon sets in your project as you normally would, then reference them via the `provider` and `icon` parameters.

## Notes

- If an icon cannot be rendered, the addon logs a warning and returns an empty string.

## License

MIT
