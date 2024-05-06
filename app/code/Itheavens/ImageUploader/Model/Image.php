<?php 

namespace Itheavens\ImageUploader\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Itheavens\ImageUploader\Api\Data\ImageInterface;
use Itheavens\ImageUploader\Model\ResourceModel\Image as ResourceModelImage;

class Image extends AbstractModel implements ImageInterface, IdentityInterface {
  const CACHE_TAG = 'Itheavens_images';

  public function getIdentities()
  {
    return [
      self::CACHE_TAG . '_' . $this->getId(),
    ];
  }

  protected function _construct () {
    $this->_init(ResourceModelImage::class);
  }

  public function getPath()
  {
    return $this->getData(self::PATH);
  }

  public function setPath($value)
  {
    return $this->setData(self::PATH, $value);
  }

  public function getImageTitle()
  {
    return $this->getData(self::IMAGETITLE);
  }

  public function setImageTitle($value)
  {
    return $this->setData(self::IMAGETITLE, $value);
  }
}