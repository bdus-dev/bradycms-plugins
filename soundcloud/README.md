# soundcloud

Easily embed a Soundcloud widget in a web page
The following options are available:
- `content` (string, required); prezi's id
- `width` (int, optional, default: 100%): width of the iframe
- `height` (int, optional, default: 166): height of the iframe
- `color` (string, optional, default: 0): color
- `auto_play` (int, optional (0 or 1), default: 0): wether permit autoplay or not
- `show_artwork` (int, optional (0 or 1), default: 0): wether to show artwork or not


## Minimal example

```html
[[soundcloud]]some-soundcloud-id[[/soundcloud]]
```

## Full example

```html
[[soundcloud width="80%" height="200" color="000000" auto_play="1" show_artwork="1"]]some-soundcloud-id[[/soundcloud]]
```
