# notes

This plugin is used to automatically create footnotes for articles. Once installed the custom tag `notes` will be available.

Notes must be marked in the text in the exact place where the reference number will appear, and notes text must be wrapped by custom tag `notes`, eg. `[[notes]]Some text[[/notes]]`.

Rich html can be used in notes text. A notes section, wrapped in `div.footNotes` will be created at the end of the article and notes will be listed after the `<h2 class="notes">Note</h2>` head.

Each note will bear reference to its occurrence in the text and vice-versa. Occurrence links will be provided, or usage with [Bootstrap popovers](http://getbootstrap.com/javascript/#popovers) with:

- `ftpopover` css class
- `href` to note item in notes section list
- unique `id` attribute (bd-note-{progressive number})
- `title` attribute with note text
- `data-content` attribute with note text
- `data-toggle` attribute set to `popover`
- `data-original-title` attribute set to `Nota {progressive numbner}`


## Example usage

```html
<p>Augue nisl risus nulla dictumst a cursus a at vestibulum congue conubia
consectetur suspendisse suscipit eu vel a sodales dui consectetur.
Nascetur[[notes]]Nunc erat conubia parturient sapien <strong>mattis</strong> posuere.[[/notes]]
a hendrerit ornare senectus nec dui vestibulum eget eget penatibus cursus
tincidunt sociosqu inceptos ante et.</p>
```
