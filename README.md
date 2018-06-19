# Squeezio
Compress &amp; Optimize all you images (jpg, png, gif, svg)

Install libraries :

```
sudo apt-get install imagemagick gifsicle jpegoptim pngquant && sudo npm install -g svgo
```

Install with composer :

```
composer require mrmanchot/squeezio
```

Library used :
- [ImageMagick](https://www.imagemagick.org/script/index.php)
- [Gifsicle](https://www.lcdf.org/gifsicle/)
- [JpegOptim](http://www.kokkonen.net/tjko/projects.html)
- [PngQuant](https://pngquant.org/)
- [SVGO](https://github.com/svg/svgo)

How to use :

```php
require __DIR__ . '/vendor/autoload.php';

$sqz = Sqz\Squeezio::getInstance(__DIR__ . '/my-file.jpg');
$sqz->setSize(800)->setQuality(70)->exec();
print_r($sqz->getInfos());
```
