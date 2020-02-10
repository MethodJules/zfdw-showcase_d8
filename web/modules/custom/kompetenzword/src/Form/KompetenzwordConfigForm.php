<?php

namespace Drupal\kompetenzword\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class kompetenzwordConfigForm extends ConfigFormBase {
    protected function getEditableConfigNames()
    {
        return ['kompetenzword.settings'];
    }

    public function getFormId()
    {
        return 'kompetenzword_config_form';
    }

    public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state)
    {
        $config = $this->config('kompetenzword.settings');

        $form['keyword'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Keyword'),
            '#description' => $this->t('Please enter here your Keyword for the Network Visualization'),
            '#default_value' => $config->get('network_keyword'),
        ];

        return parent::buildForm($form, $form_state);
    }

    public function submitForm(array &$form, \Drupal\Core\Form\FormStateInterface $form_state)
    {
        $this->config('kompetenzword.settings')->set('network_keyword', $form_state->getValue('keyword'))->save();
    }
}