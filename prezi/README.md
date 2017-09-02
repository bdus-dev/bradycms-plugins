# prezi

Easily embed a Prezi presentation in a web page, according to https://prezi.com/support/article/sharing/embedding-prezis/
The following options are available:
- `content` (string, required); prezi's id
- `width` (int, optional, default: 550): width of the iframe
- `height` (int, optional, default: 400): height of the iframe
- `frameborder` (int, optional, default: 0): iframe border
- `bgcolor` (string, optional, default: ffffff): background color
- `lock_to_path` (int, optional (0 or 1), default: 0): wether permit zoom or pan or not
- `autoplay` (int, optional (0 or 1), default: 0): wether permit autoplay or not
- `autohide_ctrls` (int, optional (0 or 1), default: 0): wether permit automatically hide controls or not

## Minimal example

```html
[[prezi]]some-prezi-id[[/prezi]]
```

## Full example

```html
[[prezi width="600" height="400" frameborder="1" bgcolor="000000" lock_to_path="1" autoplay="1" autohide_ctrls="1"]]some-prezi-id[[/prezi]]
```
