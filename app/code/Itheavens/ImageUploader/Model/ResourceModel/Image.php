<?php 

namespace Itheavens\ImageUploader\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Image extends AbstractDb {
  protected function _construct () {
    return $this->_init('Itheavens_images', 'image_id');
  }
}