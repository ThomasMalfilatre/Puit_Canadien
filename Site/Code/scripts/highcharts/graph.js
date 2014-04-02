$(function () { 
    $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Température'
        },
        xAxis: {
            categories: ['28 Jan', '29 Jan', '30 Jan']
        },
        yAxis: {
            title: {
                text: 'T (°C)'
            }
        },
        series: [{
            name: 'Sonde B1-1',
            data: [1, 0, 4]
        }, {
            name: 'Sonde B2-1',
            data: [5, 7, 3]
        }]
    });
});