<?php

declare(strict_types=1);

namespace PhotoGallery;

use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
  'router' => [
    'routes' => [
      'photo-gallery' => [
        'type'    => Segment::class,
        'options' => [
          'route' => '/photo-gallery[/:action[/:id]]',
          'constraints' => [
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id'     => '[0-9]+',
          ],
          'defaults' => [
            'controller' => Controller\PhotoGalleryController::class,
            'action'     => 'index',
          ],
        ],
      ],
    ],
  ],
  'view_manager' => [
    'template_path_stack' => [
      'galerry' => __DIR__ . '/../view',
    ],
  ],
  'service_manager' => [
    'factories' => [
      Service\ImageManager::class => InvokableFactory::class,            
    ],
  ],  
];
