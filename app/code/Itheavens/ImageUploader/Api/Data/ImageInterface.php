<?php 

namespace Itheavens\ImageUploader\Api\Data;

interface ImageInterface {
  const ID = 'image_id';
  const PATH = 'path';
  const IMAGETITLE = 'image_title';

  public function getPath ();

  public function setPath ($value);

  public function getImageTitle ();

  public function setImageTitle ($value);
}