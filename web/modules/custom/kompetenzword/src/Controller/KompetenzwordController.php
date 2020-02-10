<?php

namespace Drupal\kompetenzword\Controller;

use Drupal\Core\Url;

class KompetenzwordController {

    public function content() {
        $node_storage = \Drupal::entityTypeManager()->getStorage('node');

        $query = \Drupal::entityQuery('node')->condition('type', 'projekt');
        $nids = $query->execute();
        $graphdata = [];
        $nodes = $node_storage->loadMultiple($nids);

        $index = 0;
        foreach($nodes as $n) {
            //dsm($n->body->value);
            $wordsFound = [];
            preg_match_all('/[\w-]*kompetenz[\w-]*/iu', $n->body->value, $wordsFound);
            // Array-Format key = gefundenes Kompetenzwort, value = wie oft das Wort im Text vorkommt wurde
            if ($wordsFound[0]) {
                $projectTitle = $n->title->value;
                $projectUrl = $n->toUrl()->toString();//Url::fromUri('internal:/node/' . $n->nid);
                $wordsFrequency = array_count_values($wordsFound[0]);

                $graphdata['nodes'][] = ['name' => $projectTitle, 'type' => 'project', 'link' => $projectUrl];
                $projectIndex = $index++;

                foreach ($wordsFrequency as $word => $wordcount) {
                  // if it's a new 'kompetenz' word, add it as a node
                  $wordIndex = array_search($word, array_column($graphdata['nodes'], 'name'));
                  if ($wordIndex === false) {
                    $graphdata['nodes'][] = ['name' => $word, 'type' => 'word'];
                    $wordIndex = $index++;
                  }

                  $graphdata['edges'][] = ['source' => $projectIndex, 'target' => $wordIndex];
                  $graphdata['praedikate'][] = $wordcount;
                }
            }

        }

        //dsm(array('graphdata' => $graphdata));

        $render_html = ['#markup' => '<h1>Kompetenzbegriffe</h1><div id="kompetenzword_graphic"></div>'];
        $render_html['#attached']['library'][] = 'kompetenzword/kompetenzword_graphic';
        //$render_html['#attached']['drupalSettings']['baseUrl'] = $base_url;
        $render_html['#attached']['drupalSettings']['kompetenz_word_visual']['graphdata'] = $graphdata;




        return $render_html;
    }
}