<?php

namespace Drupal\bi\Controller;
use Drupal\bi\Data\BIData;
use Symfony\Component\HttpFoundation\JsonResponse;

class BIController {
    public function content() {

        return ['#markup' => 'BI'];
    }

    public function chart() {

    }

    /**
     * This function provides the data (count of associated nodes)
     * in JSON Format
     * @param $vocabulary
     * @return JsonResponse
     * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
     * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
     */
    public function getData($vocabulary) {

        $data = new BIData();
        $c3_data = $data->getData($vocabulary);
        return new JsonResponse($c3_data);


    }
}