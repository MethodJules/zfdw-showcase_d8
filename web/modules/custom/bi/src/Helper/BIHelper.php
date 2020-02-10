<?php

namespace Drupal\bi\Helper;
use Drupal\taxonomy\Entity\Vocabulary;


class BIHelper {
    /**
     * Return all vocabularies
     * @return array $vocabularyList
     */
    public function getAllVocabularies()
    {
        $vocabularies = Vocabulary::loadMultiple();
        $vocabulariesList = [];
        foreach($vocabularies as $vid => $vocabulary) {
            $vocabulariesList[$vid] = $vocabulary->get('name');
        }
        return $vocabulariesList;
    }

    /**
     * Counts the frequency of a term that is
     * associated with a node
     * @param mixed $termId
     * @return  int|null $node
     */
    public function getCountOfNodesByTaxonomyTerm($termId) {

    }

    public function getAllTaxonomyTermsOfAVocabulary($vid) {
        $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
        foreach($terms as $term) {
            $term_data[] = [
                'id' => $term->id,
                'name' => $term->name,
            ];
        }
        return $term_data;
    }
}