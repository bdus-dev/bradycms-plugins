# An open-source set of plugins for BraDyCMS

Available plugins:
- [cookieconsent](#cookie_consent)
- notes

---

## How to install
Just copy the plugin main folder inside the `modules` folder of the site directory, i.e.: `sites/default/modules`. Further configuration or plugin usage information are available below at plugin correspondent section of this guide.

---

## Cookie consent
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

## License

[ISC License (ISC)](https://opensource.org/licenses/ISC)

Copyright 2017 Julian Bogdani (BraDypUS)

Permission to use, copy, modify, and/or distribute this software for any purpose with or without fee is hereby granted, provided that the above copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
