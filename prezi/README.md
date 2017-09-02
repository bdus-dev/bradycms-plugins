# skype

Shows a call/chat contact me Skype button, according to https://www.skype.com/en/developer/create-contactme-buttons/.
The following options are available
- `content` (string, required): skype contact to contact
- `type` (string optional): contact type, one of call (default), chat, dropdown
- `imagesize` (integer, optional): Skype image size, one of 10, 12, 14, 16, 24, 32 (default)

## Minimal example

```html
[[skype]]skype-username-to-contact[[/skype]]
```

## Full example

```html
[[skype type="dropdown" imagesize="24"]]skype-username-to-contact[[/skype]]
```
