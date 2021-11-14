<?php

namespace PhotoGallery\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class PhotoGalleryTable {
  
  private $tableGateway;

  public function __construct(TableGatewayInterface $tableGateway) {
    $this->tableGateway = $tableGateway;
  }

  public function fetchAll() {
    return $this->tableGateway->select();
  }

  public function getPhoto($id) {
    $id = (int) $id;
    $rowset = $this->tableGateway->select(['id' => $id]);
    $row = $rowset->current();
    if (! $row) {
      throw new RuntimeException(sprintf(
        'Could not find row with identifier %d',
        $id
      ));
    }

    return $row;
  }

  public function savePhoto(Photo $photo) {
    $data = [
      'title'    => $photo->title,
      'caption'  => $photo->caption,
      'alt'      => $photo->alt,
      'img_name' => $photo->img_name,
    ];

    $id = (int) $photo->id;

    if ($id === 0) {
      $this->tableGateway->insert($data);
      return;
    }

    try {
      $this->getPhoto($id);
    } catch (RuntimeException $e) {
      throw new RuntimeException(sprintf(
        'Cannot update photo with identifier %d; does not exist',
        $id
      ));
    }

    $this->tableGateway->update($data, ['id' => $id]);
  }

  public function deletePhoto($id) {
    $this->tableGateway->delete(['id' => (int) $id]);
  }
}
