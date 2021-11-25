<?php
namespace Drupal\image_gallery\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;

class BannerGalleryController extends ControllerBase {
  public function content() {
    $service_statically = Drupal::service('image_gallery.custom_body');

    return $service_statically->getBannerContent();
  }
}
