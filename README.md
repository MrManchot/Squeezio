# Squeezio
Compress &amp; Optimize all you images (jpg, png, gif, svg)

Library used :
- [ImageMagick](https://www.imagemagick.org/script/index.php)
- [Gifsicle](https://www.lcdf.org/gifsicle/)
- [JpegOptim](http://www.kokkonen.net/tjko/projects.html)
- [PngQuant](https://pngquant.org/)
- [SVGO](https://github.com/svg/svgo)

How to use :

```php
$sqz = Sqz\Squeezio::getInstance('my-file.jpg');
$sqz->exec();
```