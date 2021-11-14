<?php
namespace PhotoGallery\Service;

use PHPThumb\GD;

/**
 * The ImageManager service.
 */
class ImageManager {

  /**
   * Path to image folder.
   *
   * @var string
   */  
  private $imageDir;

  /**
   * ImageManager constructor
   */
  public function __construct() {
    $this->imageDir = getcwd() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'img';
  }

  /**
   * Get new image path by name.
   *
   * @param string $fileName
   *   File name.
   *
   * @return string
   *   Return new image path.
   */
  public function getImagePathByName($fileName): string {
    return $this->imageDir . DIRECTORY_SEPARATOR . $fileName;                
  }

  /**
   * Get new image path by name.
   *
   * @param string $fileName
   *   File name.
   *
   * @return string
   *   Return new image path.
   */
  public function getThumbnailImagePathByName($fileName): string {
    return $this->imageDir . DIRECTORY_SEPARATOR . 'thumbnail' . DIRECTORY_SEPARATOR . $fileName;                
  }

  /**
   * Save image.
   *
   * @param string $tmpPath
   *   Temporary file.
   * @param string $targetFile
   *   Target file.
   *
   * @return bool
   *   Return true if file was saved, else false.
   */
  public function saveImage($tmpFile, $targetFile): bool {
    return move_uploaded_file($tmpFile, $targetFile);
  }

  /**
   * Save image thumbnail.
   *
   * @param string $file
   *   Image file.
   * @param string $name
   *   Image file name.
   */
  public function saveImageThumb($file, $name): void {
    $gd = new GD($file);
    $gd->adaptiveResize(200, 200)
      ->save($this->getThumbnailImagePathByName($name));
  }

  /**
   * Remove image.
   *
   * @param string $fileName
   *   Image name.
   *
   * @return bool
   *   Return true if file was removed, else false.
   */
  public function removeImage($fileName): bool {
    $image = $this->getImagePathByName($fileName);
    return unlink($image);
  }

  /**
   * Remove image thumbnail.
   *
   * @param string $fileName
   *   Thumbnail image name.
   *
   * @return bool
   *   Return true if file was removed, else false.
   */
  public function removeImageThumb($fileName): bool {
    $imageThumb = $this->getThumbnailImagePathByName($fileName);
    return unlink($imageThumb);
  }

}
