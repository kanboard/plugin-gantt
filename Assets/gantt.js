KB.on('dom.ready', function () {
    function goToLink (selector) {
        if (! KB.modal.isOpen()) {
            var element = KB.find(selector);

            if (element !== null) {
                window.location = element.attr('href');
            }
        }
    }

    KB.onKey('v+g', function () {
        goToLink('a.view-gantt');
    });

    if (KB.exists('#gantt-chart')) {
        var chart = new Gantt();
        chart.show();
    }
});