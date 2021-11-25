<?php

namespace Drupal\image_gallery\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

class BannerForm extends ContentEntityForm {

  public function getFormId() {
    return 'image_gallery_banner_form';
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $entity = $this->buildEntity($form, $form_state);

    $id = \Drupal::entityTypeManager()->getStorage('banner')->load($entity->get('id')->value);
    $title = $entity->getTitle();
    $desc = $entity->getDescription();
    $slideOrder = $entity->getSlideOrder();

    $database = \Drupal::database();
    $count_edit = $database->select('banner','b')
      ->condition('b.slideOrder', $slideOrder, '=')->condition('b.id', $entity->id(), '<>')->countQuery()->execute()->fetchField();
    $count_create = $database->select('banner','b')
      ->condition('b.slideOrder', $slideOrder, '=')->countQuery()->execute()->fetchField();
    if ($id) {
      if ($count_edit > 0) {
        $form_state->setErrorByName('slide order', $this->t('The slide order already exists'));
      }
    }
    else {
      if ($count_create > 0) {
        $form_state->setErrorByName('slide order', $this->t('The slide order already exists'));
      }
    }
    if (strlen($title) < 5) {
      $form_state->setErrorByName('title', $this->t('The title is too short. Please try again.'));
    }
    if (strlen($title) > 30) {
      $form_state->setErrorByName('title', $this->t('The title is too long. Please try again.'));
    }
    if (strlen($desc) < 5) {
      $form_state->setErrorByName('description', $this->t('The description is too short. Please try again.'));
    }
    if (strlen($desc) > 50) {
      $form_state->setErrorByName('description', $this->t('The description is too long. Please try again.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label banner.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label banner.', [
          '%label' => $entity->label(),
        ]));
    }
    //$form_state->setRedirect('entity.banner.canonical', ['banner' => $entity->id()]);
    $form_state->setRedirect('entity.banner.collection');

    parent::submitForm($form, $form_state);
  }
}
