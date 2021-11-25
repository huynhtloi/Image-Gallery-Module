<?php

namespace Drupal\image_gallery\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class MaxBannerForm extends ConfigFormBase {

  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
    );
  }

  protected function getEditableConfigNames() {
    return ['image_gallery.custom_max_banner_image'];
  }

  public function getFormId() {
    return 'max_banner_image_configuration_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, $extra = NULL) {
    $config = $this->config('image_gallery.custom_max_banner_image');
    $form['max_banner_image'] = array(
      '#type' => 'number',
      '#title' => $this->t('The maximum number of images shown'),
      '#default_value' => $config->get('max_banner_image'),
    );

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('image_gallery.custom_max_banner_image')
      ->set('max_banner_image', $form_state->getValue('max_banner_image'))
      ->save();

    parent::submitForm($form, $form_state);

    $form_state->setRedirect('entity.banner.collection');
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $salutation = $form_state->getValue('salutation');
    if (strlen($salutation) > 20) {
      $form_state->setErrorByName('max_banner_image', $this->t('The maximum number of banners is 20 images'));
    }
  }
}
