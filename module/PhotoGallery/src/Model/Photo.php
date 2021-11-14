<?php

namespace PhotoGallery\Model;

/**
 * Photo model.
 */
class Photo {
  /**
   * Unique photo id.
   *
   * @var int
   */
  public $id;

  /**
   * Title of photo.
   *
   * @var string
   */
  public $title;

  /**
   * Caption for photo.
   *
   * @var string
   */
  public $caption;

  /**
   * alternative title for html alt attribute
   *
   * @var string
   */
  public $alt;

  /**
   * Path to image.
   *
   * @var string
   */
  public $img_name;

  public function exchangeArray(array $data) {
    $this->id        = !empty($data['id']) ? $data['id'] : null;
    $this->title     = !empty($data['title']) ? $data['title'] : null;
    $this->caption   = !empty($data['caption']) ? $data['caption'] : null;
    $this->alt       = !empty($data['alt']) ? $data['alt'] : null;
    $this->img_name  = !empty($data['img_name']) ? $data['img_name'] : null;
  }

}
