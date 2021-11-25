<?php

namespace Drupal\image_gallery\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\image_gallery\Service\CustomBody;
/**
 * Sidebar second block.
 *
 * @Block(
 * id = "image_gallery_sidebar_second_block",
 * admin_label = @Translation("Sidebar second block"),
 * )
 */
class SidebarSecondBlock extends BlockBase implements ContainerFactoryPluginInterface {
  protected $body;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, CustomBody $body) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->body = $body;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('image_gallery.custom_body')
    );
  }

  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  public function build() {
    return $this->body->getSidebarSecond();
  }
}
