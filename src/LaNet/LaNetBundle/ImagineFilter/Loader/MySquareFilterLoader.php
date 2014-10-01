<?php

namespace LaNet\LaNetBundle\ImagineFilter\Loader;

use Imagine\Filter\Basic\Crop;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;
use Liip\ImagineBundle\Imagine\Filter\Loader\LoaderInterface;

use Imagine\Exception\InvalidArgumentException;

use Liip\ImagineBundle\Imagine\Filter\RelativeResize;

class MySquareFilterLoader implements LoaderInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ImageInterface $image, array $options = array())
    {
      $width = $image->getSize()->getWidth();
      $height = $image->getSize()->getHeight();
      
      if($width > $height) {
        $filter = new RelativeResize('heighten', $options['size']);
        $image = $filter->apply($image);
      }
      else {
        $filter = new RelativeResize('widen', $options['size']);
        $image = $filter->apply($image);
      }
      
      $filter = new Crop(new Point(0, 0), new Box($options['size'], $options['size']));
      $image = $filter->apply($image);
      return $image; 
    }
}
