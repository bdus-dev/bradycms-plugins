# cookieconsent
A very simple to use plugin of [Insite's Cookie consent](https://cookieconsent.insites.com/) packages for BraDyCMS.

Once installed the `cookieconsent` custom tag is available for use in article contents or in template files. The custom tags accepts a single argument, which is a json-serialized string or an array containing plugin configuration as explained at https://cookieconsent.insites.com/documentation/about-cookie-consent/.

## Usage example

```twig
{{ html.ct('cookieconsent', {
    'content':{
      'message': 'Questo sito usa cookie per assicurare un\'esperienza ottimale  nel nostro sito web. Preseguendo la navigazione si acconsente al loro utilizzo',
      'dismiss': 'Ricevuto!',
      'link': 'Maggiori informazioni',
      'href': 'informativa-cookie'
    }
  })
}}
```
