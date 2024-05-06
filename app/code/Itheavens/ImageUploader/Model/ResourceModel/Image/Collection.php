<?php 

namespace Itheavens\ImageUploader\Model\ResourceModel\Image;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Itheavens\ImageUploader\Model\Image;
use Itheavens\ImageUploader\Model\ResourceModel\Image as ResourceModelImage;

class Collection extends AbstractCollection {
  protected function _construct()
  {
    $this->_init(Image::class, ResourceModelImage::class);
  }
}