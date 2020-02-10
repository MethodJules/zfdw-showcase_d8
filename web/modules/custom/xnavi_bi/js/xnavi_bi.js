(function ($,Drupal, drupalSettings) {
    var initialized;
    var basePath = drupalSettings.baseUrl;
    var chartType = drupalSettings.chartType;
    var vocabularies = drupalSettings.vocabularies;
    function init() {
        if(!initialized) {
            initialized = true;
            console.log('C3...');
            console.log(chartType);
            console.log(vocabularies);

            switch (chartType) {
                case 'pie':
                    vocabularies.forEach(generatePieChart);
                    break;
            }
        }
    }
    function generatePieChart(item, index) {
        console.log("generating chart with: #chart" + index + " and item: " + item);
        c3.generate({
            bindto: '#chart' + index,
            data: {
                url: basePath + '/xnavi_bi/data/' + item,
                mimeType: 'json',
                type : 'pie',
                onclick: function (d, i) { console.log("onclick", d, i); },
                onmouseover: function (d, i) { console.log("onmouseover", d, i); },
                onmouseout: function (d, i) { console.log("onmouseout", d, i); }
            }
        });
    }

    Drupal.behaviors.xnavi_bi = {
        attach: function (context, settings) {

            init();
        }
    }
} (jQuery, Drupal, drupalSettings));