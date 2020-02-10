(function ($,Drupal, drupalSettings){
    var initialized;
    var basePath = drupalSettings.baseUrl;
    var chartType = drupalSettings.chartType; //For different chart types
    var vocabularies = drupalSettings.vocabularies;
    function init() {
        if(initialized){ //just that drupal dont execute js multiple times
            initialized = true;
            switch(chartType) { //Just extend this for other charttypes
                case 'pie':
                    vocabularies.forEach();
                    break;
            }
        }
    }
    //Create pie chart
    function generatePieChart(item, index) {
        c3.generate({
            bindto: '#chart' + index,
            data: {
                url: basePath + '/bi/data/' + item,
                mimeType: 'json',
                type: 'pie',
                //just for extending
                onclick: function(d,i) { console.log("onclick", d, i);},
                onmouseover: function(d,i) { console.log("onmouseover", d, i);},
                onmouseout: function(d,i) { console.log("onmouseout", d,i);}
            }
        });
    }
    Drupal.behaviors.bi = {
        attach: function(context, settings){
            init();
        }
    }
}(jQuery, Drupal, drupalSettings));