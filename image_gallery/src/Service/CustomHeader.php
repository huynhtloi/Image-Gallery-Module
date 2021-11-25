<?php

namespace Drupal\image_gallery\Service;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Config\ConfigFactoryInterface;

class CustomHeader {
  use StringTranslationTrait;
  protected $configFactory;

  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  public function getNavbarMenu() {
    $render = [
      '#theme' => 'image_gallery_secondary_menu',
    ];

    $render['#overridden'] = TRUE;
    $render['#attached'] = [
      'library' => [
        'image_gallery/custom-header',
        'image_gallery/bootstrap',
      ],
    ];

    return $render;
  }

  public function getSearchPrimaryMenu() {
    $render = [
      '#theme' => 'image_gallery_primary_menu',
    ];

    $render['#overridden'] = TRUE;
    $render['#attached'] = [
      'library' => [
        'image_gallery/custom-header',
        'image_gallery/bootstrap',
      ],
    ];

    return $render;
  }

  public function getLogoHeader() {
    $render = [
      '#theme' => 'image_gallery_header',
    ];

    $render['#overridden'] = TRUE;
    $render['#attached'] = [
      'library' => [
        'image_gallery/custom-header',
        'image_gallery/bootstrap',
      ],
    ];

    return $render;
  }
}
