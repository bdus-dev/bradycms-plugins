# galRef
A simple custom tag to displays link to gallery item. Reference to the gallery
and to the gallery item should be provided and a display text should be given as content parameter

- `gal` (string, required): gallery unique name
- `item` (int, required): gallery item's number
- `content` (string, required): visible linkified content.
- `rel` (string, optional) rel attribute that links items in galleries.

## Usage example

```html
[[galRef gal="article-images" item="1" rel="article-images"]]Figure 1[[/galRef]]
```
