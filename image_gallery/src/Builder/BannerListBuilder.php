<?php

namespace Drupal\image_gallery\Builder;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

class BannerListBuilder extends EntityListBuilder {
  public function buildHeader() {
    $header['thumbnail'] = $this->t('Thumbnail');
    $header['title'] = $this->t('Title');
    $header['order'] =  $this->t('Order');
    $header['updated'] =  $this->t('Updated');
    $header['publish'] = $this->t('Publish');
    return $header + parent::buildHeader();
  }

  public function buildRow(EntityInterface $entity) {

    $database = \Drupal::database();

    $obj = $database->query("SELECT * FROM {banner} WHERE id = :id", [':id' => $entity->id()])->fetchObject();
    $style = \Drupal::entityTypeManager()->getStorage('image_style')->load('thumbnail');
    $image_url = $style->buildUrl(\Drupal::entityTypeManager()->getStorage('file')->load($obj->image__target_id)->getFileUri());

    $row['thumbnail']['data'] = [
      '#theme' => 'image_gallery_thumbnail_style',
      '#url' => $image_url,
      '#height' => 150,
      '#attached' => [
        'library' => [
          'image_gallery/bootstrap',
        ],
      ],
    ];
    $row['title'] = $entity->toLink();
    $row['order'] = $entity->getSlideOrder();
    $row['updated'] = \Drupal::service('date.formatter')->format($entity->get("changed")->getString(), 'long');
    if ($entity->getStatus() == 1)
      $row['publish'] = 'Published';
    else
      $row['publish'] = 'Unpublished';

    return $row + parent::buildRow($entity);
  }
}
