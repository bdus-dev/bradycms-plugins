# An open-source set of plugins for BraDyCMS

Available plugins:
- [cookieconsent](cookieconsent/README.md)
- [galRef](#galref)
- [gist](#gist)
- [notes](#notes)
- [skype](#skype)

---

## How to install
Just copy the plugin main folder inside the `modules` folder of the site directory, i.e.: `sites/default/modules`. Further configuration or plugin usage information are available below at plugin correspondent section of this guide.

---

## cookieconsent
This is a very simple to use plugin of [Insite's Cookie consent](https://cookieconsent.insites.com/) packages for BraDyCMS.

Once installed the `cookieconsent` custom tag is available for use in article contents or in template files. The custom tags accepts a single argument, which is a json-serialized string or an array containing plugin configuration as explained at https://cookieconsent.insites.com/documentation/about-cookie-consent/.

### Usage example
    {{ html.ct('cookieconsent', {
        'content':{
          'message': 'Questo sito usa cookie per assicurare un\'esperienza ottimale  nel nostro sito web. Preseguendo la navigazione si acconsente al loro utilizzo',
          'dismiss': 'Ricevuto!',
          'link': 'Maggiori informazioni',
          'href': 'informativa-cookie'
        }
      })
    }}

---

## galRef
A simple custom tag to displays link to gallery item. Reference to the gallery
and to the gallery item should be provided and a display text should be given as content parameter

- `gal` (string, required): gallery unique name
- `item` (int, required): gallery item's number
- `content` (string, required): visible linkified content.
- `rel` (string, optional) rel attribute that links items in galleries.

### Usage example
    [[galRef gal="article-images" item="1" rel="article-images"]]Figure 1[[/galRef]]

---

## gist
Embed Github gists in article contents
The plugin is used to easily embed in article contents Github gists using a simple custom tag: `gist` and the gist url.

### Example
    [[gist]]https://gist.github.com/jbogdani/9185f5d7e8fb1721f5ac.js[[/gist]]
---

## notes

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


### Example usage
    Augue nisl risus nulla dictumst a cursus a at vestibulum congue conubia
    consectetur suspendisse suscipit eu vel a sodales dui consectetur.
    Nascetur[[notes]]Nunc erat conubia parturient sapien <strong>mattis</strong> posuere.[[/notes]]
    a hendrerit ornare senectus nec dui vestibulum eget eget penatibus cursus
    tincidunt sociosqu inceptos ante et.

---

## skype

Shows a call/chat contact me Skype button, according to https://www.skype.com/en/developer/create-contactme-buttons/.
The following options are available
- `content` (string, required): skype contact to contact
- `type` (string optional): contact type, one of call (default), chat, dropdown
- `imagesize` (integer, optional): Skype image size, one of 10, 12, 14, 16, 24, 32 (default)

### Minimal example
[[skype]]skype-username-to-contact[[/skype]]

### Full example
[[skype type="dropdown" imagesize="24"]]skype-username-to-contact[[/skype]]

---

## License

[ISC License (ISC)](https://opensource.org/licenses/ISC)

Copyright 2017 Julian Bogdani (BraDypUS)

Permission to use, copy, modify, and/or distribute this software for any purpose with or without fee is hereby granted, provided that the above copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
