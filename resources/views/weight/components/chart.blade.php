<div id="chart">

</div>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // パッケージのロード
    google.charts.load('current', {packages: ['corechart']});
    
    // ロード完了まで待機
    google.charts.setOnLoadCallback(DrawChart);

    function DrawChart(){

        //PHPからjsonデータを取得
        let json_chart_info = <?php echo $chart_info; ?>;

        //get contents from json data
        let chart_title   = json_chart_info[ 'title' ];
        let chart_labels  = json_chart_info[ 'header' ];
        let chart_values  = GetChartValuesFromJson( chart_labels, json_chart_info[ 'values' ] );

        //set chart option
        let options = {
          title     : chart_title,
          seriesType: "Line",
          series    : { 1:  { type: "line"}} 
        };

        //draw chart 
        let chart_obj       = document.getElementById( 'chart' );
        let chart           = new google.visualization.ComboChart( chart_obj );
        chart.draw( chart_values, options );

    }

    //get 'month_day' and 'weight' key's value and convert chart's table
    function GetChartValuesFromJson( m_headers, m_values ){

        //set header label
        let chart_data = [];
        chart_data.push( m_headers );

        //set values
        m_values.forEach( function( row ) {

          month_day = row[ 'month_day'  ];
          weight    = parseFloat( row[ 'weight' ] );
          
          chart_data.push( [ month_day, weight ] ); 
        });

        return google.visualization.arrayToDataTable( chart_data );
    }
</script>