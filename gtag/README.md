# gtag
Returns code for Google Analytics tag

### Parameter
- `id`, string, required (optional if `content` is available): tag identifier
- `content`, string, required (optional if `id` is available): tag identifier
- `domain`, string, optional: if available the code will be shown only if domain matches


## Minimal example

```twig
{{ html.ct('gtag', {
    'content':"IDENTIFIER"
  })
}}
```

or

```html
[[gtag]]IDENTIFIER[[/gtag]]
```

or

```
[[gtag id="IDENTIFIER"]][[/gtag]]
```

## Full example

```twig
{{ html.ct('gtag', {
    'content':"IDENTIFIER",
    'domain':"example.com"
  })
}}
```

or

```html
[[gtag domain="example.com"]]IDENTIFIER[[/gtag]]
```

or

```
[[gtag id="IDENTIFIER" domain="example.com"]][[/gtag]]
```