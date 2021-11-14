<?php

namespace PhotoGallery\Controller;

use PhotoGallery\Form\PhotoForm;
use PhotoGallery\Model\Photo;
use PhotoGallery\Model\PhotoGalleryTable;
use PhotoGallery\Service\ImageManager;
use PHPThumb\GD;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * PhotoGalleryController for handling action with photo: add, delete and listAll
 */
class PhotoGalleryController extends AbstractActionController {

  /**
   * @var \PhotoGallery\Model\PhotoGalleryTable 
   */
  private $table;

  /**
   * @var \PhotoGallery\Service\ImageManager $imageManager
   */
  private $imageManager;

  /**
   * PhotoGalleryController constructor
   * 
   * @param \PhotoGallery\Model\PhotoGalleryTable $table
   *   PhotoGalleryTable Model
   * @param \PhotoGallery\Service\ImageManager $imageManager
   *   ImageManager service
   */
  public function __construct(PhotoGalleryTable $table, ImageManager $imageManager) {
    $this->table = $table;
    $this->imageManager = $imageManager;
  }

  /**
   * List all photos.
   *
   * @return ViewModel
   */
  public function indexAction(): ViewModel {
    return new ViewModel([
      'photos' => $this->table->fetchAll(),
    ]);
  }

  /**
   * edit specific photo.
   *
   * @return ViewModel
   */
  public function editAction(): ViewModel {
    return new ViewModel();
  }

  /**
   * Add photo to gallery.
   *
   * @return array|\Laminas\Http\Response
   */
  public function addAction() {

    $form = new PhotoForm();
    $form->get('submit')->setValue('Upload photo!');

    $request = $this->getRequest();

    if (!$request->isPost()) {
      return ['form' => $form];
    }

    $data = array_merge_recursive(
      $request->getPost()->toArray(),
      $request->getFiles()->toArray()
    );

    $form->setData($data);
 
    if (! $form->isValid()) {
      return ['form' => $form];
    }

    $photoName = $data['photo']['name'];
    $tmpPhotoPath = $data['photo']['tmp_name'];
    $targetPhotoPath = $this->imageManager->getImagePathByName($photoName);
    $targetPhoto = $this->imageManager->saveImage($tmpPhotoPath, $targetPhotoPath);
    $this->imageManager->saveImageThumb($targetPhotoPath, $photoName);

    if ($targetPhoto) {
      $this->flashMessenger()->addSuccessMessage("The file ". htmlspecialchars( ($photoName) ). " has been uploaded successfully.");
    } else {
      $this->flashMessenger()->addErrorMessage("Something went wrong :( Please try it again!");
    }

    $data = array_merge_recursive(
      $request->getPost()->toArray(),
      ['img_name' => $photoName],
    );

    $photo = new Photo();
    $photo->exchangeArray($data);
    $this->table->savePhoto($photo);

    return $this->redirect()->toRoute('photo-gallery');
  }

  /**
   * Delete photo from gallery.
   * 
   * @return array|\Laminas\Http\Response
   */
  public function deleteAction() {
    $id = (int) $this->params()->fromRoute('id', 0);
    if (!$id) {
      $this->flashMessenger()->addErrorMessage("No such id found in our gallery");
      return $this->redirect()->toRoute('photo-gallery');
    }

    $request = $this->getRequest();
    if ($request->isPost()) {
      $del = $request->getPost('del', 'No');

      if ($del == 'Yes') {
        $id = (int) $request->getPost('id');
        $photo = $this->table->getPhoto($id);
        
        $this->imageManager->removeImage($photo->img_name);
        $this->imageManager->removeImageThumb($photo->img_name);
        $this->table->deletePhoto($id);
        $this->flashMessenger()->addSuccessMessage("The photo has been deleted successfully.");
      }

      return $this->redirect()->toRoute('photo-gallery', ['action' => 'listAll']);
    }

    return [
      'id'    => $id,
      'photo' => $this->table->getPhoto($id),
    ];
  }

  /**
   * List all photos.
   *
   * @return ViewModel
   */
  public function listAllAction(): ViewModel {
    return new ViewModel([
      'photos' => $this->table->fetchAll(),
    ]);
  }
}
