<?php

namespace Drupal\bi\Data;

use Drupal\bi\Helper\BIHelper;

class BIData {

    public function getData($vocabulary) {
        $helper = new BIHelper;
        $terms = $helper->getAllTaxonomyTermsOfAVocabulary($vocabulary);
        if(!is_null($terms)) {
            foreach ($terms as $term) {
                $term_data[] = [
                    'term' => $term['name'],
                    'count' => $helper->getCountOfNodesByTaxonomyTerm($term['id']),
                ];
            }
            $voc_data[$vocabulary] = $term_data;
            $data[] = $voc_data;
        }
        foreach($data as $dimension) {
            foreach($dimension as $values) {
                foreach($values as $value) {
                    $c3_data[$value['term']] = array($value['count']);
                }
            }
        }
        return $c3_data;
    }


}