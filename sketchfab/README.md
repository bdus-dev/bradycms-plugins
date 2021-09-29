# sketchfab
Returns code for easily embedding Sketchfab models

### Parameter
- `url`, string, required (optional if `content` is available): Model ID
- `content`, string, required (optional if `id` is available):  Model ID
- `title`, string, optional, default: "A 3D model": A custom title
- `width`, int, optional, default: 840: iframe's width
- `height`, int, optional, default: 640: iframe's height
- `autostart`, int, optional, default: 1
- `ui_controls`, int, optional, default: 1
- `ui_infos`, int, optional, default: 1
- `ui_inspector`, int, optional, default: 1
- `ui_stop`, int, optional, default: 1
- `ui_watermark`, int, optional, default: 1
- `ui_theme`, bool, optional, default: false


## Minimal example

```twig
{{ html.ct('sketchfab', {
    'content':"IDENTIFIER"
  })
}}
```

or

```html
[[sketchfab]]IDENTIFIER[[/sketchfab]]
```

or

```
[[sketchfab url="IDENTIFIER"]][[/sketchfab]]
```

## Full example

```twig
{{ html.cts('sketchfab', {
    'content':"IDENTIFIER",
    'title': "A 3D model",
    'width': 840,
    'height': 640,
    'autostart': 1,
    'ui_controls': 1,
    'ui_infos': 1,
    'ui_inspector': 1,
    'ui_stop': 1,
    'ui_watermark': 1,
    'ui_theme': false
  })
}}
```

or

```html
[[sketchfab title="A 3D model"
    width="840"
    height="640"
    autostart="1"
    ui_controls="1"
    ui_infos="1"
    ui_inspector="1"
    ui_stop="1"
    ui_watermark="1"
    ui_theme="false"]]IDENTIFIER[[/sketchfab]]
```
