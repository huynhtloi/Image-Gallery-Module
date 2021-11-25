<?php

namespace Drupal\image_gallery\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Banner entity.
 *
 * @ContentEntityType(
 *   id = "banner",
 *   label = @Translation("Banner"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\image_gallery\Builder\BannerListBuilder",
 *
 *     "form" = {
 *       "default" = "Drupal\image_gallery\Form\BannerForm",
 *       "add" = "Drupal\image_gallery\Form\BannerForm",
 *       "edit" = "Drupal\image_gallery\Form\BannerForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *    "route_provider" = {
 *      "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider"
 *    }
 *   },
 *   base_table = "banner",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "slideOrder" = "slideOrder",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/banner/{banner}",
 *     "add-form" = "/admin/structure/banner/add",
 *     "edit-form" = "/admin/structure/banner/{banner}/edit",
 *     "delete-form" = "/admin/structure/banner/{banner}/delete",
 *     "collection" = "/admin/structure/banner",
 *   },
 * )
 */
class Banner extends ContentEntityBase implements BannerInterface {

  use EntityChangedTrait;

  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
  }


  public function getTitle()
  {
    return $this->get('title')->value;
  }

  public function setTitle($title)
  {
    $this->set('title', $title);
  }

  public function getDescription()
  {
    return $this->get('description')->value;
  }

  public function setDescription($desc)
  {
    $this->set('description', $desc);
  }


  public function getImageBanner()
  {
    return $this->get('image')->value;
  }

  public function setImageBanner($image)
  {
    $this->set('image', $image);
  }


  public function getSlideOrder()
  {
    return $this->get('slideOrder')->value;
  }

  public function setSlideOrder($order)
  {
    $this->set('slideOrder', $order);
  }


  public function getStatus()
  {
    return $this->get('status')->value;
  }

  public function setStatus($status)
  {
    $this->set('status', $status);
  }

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['description'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Description'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'visible',
        'type' => 'basic_string',
        'weight' => 2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => 2,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setRequired(TRUE);

    $fields['textPosition'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Text Position'))
      ->setRequired(TRUE)
      ->setDefaultValue('center')
      ->setSettings([
        'allowed_values' => [
          'left' => 'Left',
          'center' => 'Center',
          'right' => 'Right',
        ],
      ])
      ->setDisplayOptions('view', [
        'label' => 'visible',
        'type' => 'list_default',
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['slideOrder'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Slide order'))
      ->setSettings([
        'min' => 1,
        'max' => 100,
      ])
      ->setDefaultValue(1)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number_unformatted',
        'weight' => 4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => 4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['mode'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Light/Dark mode'))
      ->setRequired(TRUE)
      ->setDefaultValue('light')
      ->setSettings([
        'allowed_values' => [
          'light' => 'Light',
          'dark' => 'Dark',
        ],
      ])
      ->setDisplayOptions('view', [
        'label' => 'visible',
        'type' => 'list_default',
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 8,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('Is the content published?'))
      ->setDefaultValue(TRUE)
      ->setSettings(['on_label' => 'Published', 'off_label' => 'Unpublished','ken' => 'hii'])
      ->setDisplayOptions('view', [
        'label' => 'visible',
        'type' => 'boolean',
        'weight' => 9,
      ])
      ->setDisplayOptions('form', [
        'weight' => 9,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setRequired(FALSE);

    $fields['image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Image'))
      ->setDescription(t('The product image.'))
      ->setDisplayOptions('form', [
          'type' => 'image_image',
          'weight' => 5,
      ])
      ->setRequired(TRUE);

    $fields['btnLabel'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Button label'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['actionLink'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Action link'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 7,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the banner was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the banner was last edited.'));

    return $fields;
  }
}

