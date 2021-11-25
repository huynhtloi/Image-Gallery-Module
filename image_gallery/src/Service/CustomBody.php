<?php

namespace Drupal\image_gallery\Service;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Config\ConfigFactoryInterface;

class CustomBody {
  use StringTranslationTrait;
  protected $configFactory;

  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  public function getSidebarFirst() {
    $render = [
      '#theme' => 'image_gallery_sidebar_first',
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

  public function getSidebarSecond() {
    $render = [
      '#theme' => 'image_gallery_sidebar_second',
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

  public function getSidebarSecondLink() {
    $render = [
      '#theme' => 'image_gallery_sidebar_second_link',
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

  public function getBannerContent() {
    $rows = [];

    $render = [
      '#theme' => 'image_gallery_banner',
    ];
    $style = \Drupal::entityTypeManager()->getStorage('image_style')->load('large');
    $database = \Drupal::database();

    $query = $database->query("SELECT * FROM {banner} ORDER BY slideOrder");
    $count = $database->select('banner','b')->countQuery()->execute()->fetchField();
    $max = \Drupal::config('image_gallery.custom_max_banner_image')->get('max_banner_image');

    if ($count <= $max || $max == null) {
      $max = $count;
    }

    foreach ($query as $key=>$row) {
      if ($key < $max) {
        $rows[] = [
          'id' => $row->id,
          'position' => $row->textPosition,
          'title'=> $row->title,
          'desc'=> $row->description,
          'btnLabel' => $row->btnLabel,
          'actionLink' => $row->actionLink,
          'mode' => $row->mode,
          'status' => $row->status,
          'max' => $max,
          'url'=>$style->buildUrl(\Drupal::entityTypeManager()->getStorage('file')->load($row->image__target_id)->getFileUri()),
        ];
      }
    }

    $render['#banners'] = $rows;
    $render['#overridden'] = TRUE;
    $render['#attached'] = [
      'library' => [
        'image_gallery/custom-header',
        'image_gallery/bootstrap',
      ],
    ];
    $render['#cache'] = [
      'max-age' => 0,
    ];
    return $render;
  }
}
