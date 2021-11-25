<?php

namespace Drupal\image_gallery\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

interface BannerInterface extends ContentEntityInterface, EntityChangedInterface {
  public function getTitle();
  public function setTitle($title);

  public function getImageBanner();
  public function setImageBanner($image);

  public function getDescription();
  public function setDescription($desc);

  public function getCreatedTime();
  public function setCreatedTime($timestamp);

  public function getSlideOrder();
  public function setSlideOrder($order);

  public function getStatus();
  public function setStatus($status);
}
