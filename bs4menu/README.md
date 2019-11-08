# bs4meny
Gets menu data and renders a Bootstrap v4 menu


## Minimal example

```twig
{{ html.ct('bs4menu', {
    'content':"menu_name"
  })
}}
```

## Full example

```twig
{{ html.ct('bs4menu', {
    'content':"menu_name",
    'ulClass': "custom-css-class-1 custom-css-class-n"
  })
}}
```
