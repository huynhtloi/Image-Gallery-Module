<?php

namespace Drupal\image_gallery\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\image_gallery\Service\CustomHeader;
/**
 * Secondary menu block.
 *
 * @Block(
 * id = "image_gallery_primary_menu_block",
 * admin_label = @Translation("Primary menu block"),
 * )
 */
class PrimaryMenuBlock extends BlockBase implements ContainerFactoryPluginInterface {
  protected $header;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, CustomHeader $header) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->header = $header;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('image_gallery.custom_header')
    );
  }

  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  public function build() {
    return $this->header->getSearchPrimaryMenu();
  }
}
