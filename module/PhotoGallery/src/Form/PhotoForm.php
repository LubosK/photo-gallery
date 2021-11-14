<?php

namespace PhotoGallery\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\FileInput;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\StringLength;

/**
 * Form for photo uploading.
 */
class PhotoForm extends Form {
  /**
   * Input filter.
   *
   * @var \Laminas\InputFilter\InputFilter
   */
  private $inputFilter;

  /**
   * PhotoForm constructor.
   */
  public function __construct($name = null, $options = []) {
    parent::__construct($name, $options);
    $this->addElements();
    $this->addInputFilters();
  }

  /**
   * Add elements to form.
   */
  public function addElements(): void {
    $id = new Element\Hidden('id');

    $title = new Element\Text('title');
    $title->setLabel('Title');

    $caption = new Element\Text('caption');
    $caption->setLabel('Caption');

    $alt = new Element\Text('alt');
    $alt->setLabel('Alternative title (alt="altenative_title")');

    $photo = new Element\File('photo');
    $photo->setLabel('Upload awesome photo (limit 488.28kB!)');
    // $photo->setAttribute('id', 'photo');

    $submit = new Element\Submit('submit');
    $submit->setValue('Save photo!');

    $this->add($id);
    $this->add($title);
    $this->add($caption);
    $this->add($alt);
    $this->add($photo);
    $this->add($submit);
  }

  /**
   * Add filter to inputs
   */
  public function addInputFilters(): void {
    $inputFilter = new InputFilter();   
    $this->setInputFilter($inputFilter);

    $idFilter = new Input('id');
    $idFilter->setRequired(true);
    $idFilter->getFilterChain()
      ->attachByName('toint');

    $titleFilter = new Input('title');
    $titleFilter->setRequired(true);
    $titleFilter->getFilterChain()
      ->attachByName('striptags')
      ->attachByName('stringtrim');
    $titleFilter->getValidatorChain()
      ->attach(new StringLength([
        'encoding' => 'UTF-8',
        'min' => 1,
        'max' => 100,
      ]));

    $captionFilter = new Input('caption');
    $captionFilter->setRequired(false);
    $captionFilter->getFilterChain()
      ->attachByName('striptags')
      ->attachByName('stringtrim');
    $captionFilter->getValidatorChain()
      ->attach(new StringLength([
        'encoding' => 'UTF-8',
        'min' => 1,
        'max' => 255,
      ]));

    $altFilter = new Input('alt');
    $altFilter->setRequired(true);
    $altFilter->getFilterChain()
      ->attachByName('striptags')
      ->attachByName('stringtrim');
    $altFilter->getValidatorChain()
      ->attach(new StringLength([
        'encoding' => 'UTF-8',
        'min' => 1,
        'max' => 100,
      ]));

    $photoInput = new FileInput('photo');
    $photoInput->setRequired(true);
    $photoInput->getValidatorChain()
      ->attachByName('filesize', ['max' => 500000]);
    
    $inputFilter->add($idFilter);
    $inputFilter->add($titleFilter);
    $inputFilter->add($captionFilter);
    $inputFilter->add($altFilter);
    $inputFilter->add($photoInput);
  }

}
