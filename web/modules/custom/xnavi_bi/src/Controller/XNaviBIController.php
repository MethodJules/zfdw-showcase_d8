<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 31.05.19
 * Time: 18:07
 */

namespace Drupal\xnavi_bi\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\xnavi_bi\Data\Data;
use Drupal\xnavi_bi\Logic\XNaviBILogic;
use Symfony\Component\HttpFoundation\JsonResponse;

class XNaviBIController extends ControllerBase
{
    public function content($chartType) {
        global $base_url;
        //$vocabularies = $this->getAllVocabularies();
        $logic = new XNaviBILogic();
        $vocabularies = $logic->getAllVocabularies();
        //filter vocabularies
        //$filter_elements = ['tags', 'forums'];
        $config = \Drupal::config('xnavi.bi.adminsettings');
        $filter_elements = explode(" ", $config->get('vocabularies'));

        foreach ($filter_elements as $filter_element) {
            unset($vocabularies[$filter_element]);
        }

        //reindex $vaocabularies
        $vocabularies = array_values($vocabularies);
        //dsm($vocabularies);

        //create HTML Container for the charts
        $html = '<div>';

        for($i=0;$i<count($vocabularies);$i++) {
            $html .= '<h1>' . $vocabularies[$i] .'</h1><div id="chart' . $i . '"></div>';
        }

        $html .= '</div>';

        //Create the Drupal specific render array
        $render_html = ['#markup' => $html];
        $render_html['#attached']['library'][] = 'xnavi_bi/xnavi-bi';
        $render_html['#attached']['drupalSettings']['baseUrl'] = $base_url;
        $render_html['#attached']['drupalSettings']['chartType'] = $chartType;
        $render_html['#attached']['drupalSettings']['vocabularies'] = $vocabularies;


        return $render_html;
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

        $data = new Data();
        $c3_data = $data->getData($vocabulary);
        return new JsonResponse($c3_data);


    }








}