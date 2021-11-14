<?php

declare(strict_types=1);

namespace PhotoGallery;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface {
  public function getConfig(): array {
    /** @var array $config */
    $config = include __DIR__ . '/../config/module.config.php';
    return $config;
  }

  public function getServiceConfig(): array {
    return [
      'factories' => [
        Model\PhotoGalleryTable::class => function($container) {
          $tableGateway = $container->get(Model\PhotoGalleryTableGateway::class);
          return new Model\PhotoGalleryTable($tableGateway);
        },
        Model\PhotoGalleryTableGateway::class => function ($container) {
          $dbAdapter = $container->get(AdapterInterface::class);
          $resultSetPrototype = new ResultSet();
          $resultSetPrototype->setArrayObjectPrototype(new Model\Photo());
          return new TableGateway('photo_gallery', $dbAdapter, null, $resultSetPrototype);
        },
      ],
    ];
  }

  public function getControllerConfig(): array {
    return [
      'factories' => [
        Controller\PhotoGalleryController::class => function($container) {
          return new Controller\PhotoGalleryController(
            $container->get(Model\PhotoGalleryTable::class),
            $container->get(Service\ImageManager::class)
          );
        },
      ],
    ];
  }
}
