<?php

namespace LaNet\LaNetBundle\ImagineFilter\Loader;

use Imagine\Filter\Basic\Crop;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;
use Liip\ImagineBundle\Imagine\Filter\Loader\LoaderInterface;

use Imagine\Exception\InvalidArgumentException;

use Liip\ImagineBundle\Imagine\Filter\RelativeResize;

class MySquareFullFilterLoader implements LoaderInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ImageInterface $image, array $options = array())
    {
      $width = $image->getSize()->getWidth();
      $height = $image->getSize()->getHeight();
      
     
      
      if($width > $height) {
           if  ($width >  $options['size'] ){
        $filter = new RelativeResize('heighten', $options['size']);
        $image = $filter->apply($image);
           }
      }
      else {
           if  ($height >  $options['size'] ){
        $filter = new RelativeResize('widen', $options['size']);
        $image = $filter->apply($image);
           }
      }
      
      return $image; 
    }
}
