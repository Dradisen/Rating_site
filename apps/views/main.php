
<!DOCTYPE html> 
<html lang=ru> 
<head> 
  <meta charset=utf-8>
  <meta content="IE=edge" http-equiv=X-UA-Compatible>
  <meta content="width=device-width,initial-scale=1" name=viewport>
  <meta content="Индивидуальные учебные планы" name=description>

  <title>Таблица рейтинга веб-мастеров</title> 

  <link rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
        crossorigin="anonymous">

  <link href=/static/bootstrap/css/bootstrap.min.css rel=stylesheet>
  <link href=/static/bootstrap/css/docs.min.css rel=stylesheet>
  <link href=/apple-touch-icon.png rel=apple-touch-icon> 
  <link href=/favicon.ico rel=icon> 

  <style>
  .red{background-color:#d9534f; color: white;}
  .green{background-color: #5cb85c!important;color: white;}
  .blue{background-color: #5bc0de!important;color: white;}
  .a{text-decoration:underline;}
  </style>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head> 

<body>
<!-- HEADER -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark m-0 d-flex justify-content-end">

  <ul class="navbar-nav">
    <!-- Dropdown -->
    <li class="nav-item">
      <a class="nav-link" href="/admin">Войти</a>
    </li>
  </ul>
</nav>

  <div class=bs-docs-header id=content tabindex=-1>
    <div class=container> 
      <h1>Таблица рейтинга веб-мастеров</h1> 
    </div> 
  </div>
<!-- ENDHEADER -->

<!-- CONTENT -->
  <div style="margin: 0 auto;"> 
  <script type="text/javascript">
    var namesOfMaster = [];
    <?php while($row = $data['workers']->fetch()): ?>
          namesOfMaster.push('<?=$row['worker'];?>');
    <?php endwhile ?>

  </script>       

  <div id="columnchart_values" style="width: 90%; height: 300px; margin: 0 auto;"></div>
    <table class="table table-striped" style="margin: 200px auto 50px; max-width: 1000px;">
      <tr>
        <th>Фамилия</th>
        <th>Рейтинг</th>
		    <th>Место</th>
      </tr>	  
      <?php	while($row = $data['ratings_last_month']->fetch()){
        echo "<tr><td>".$row['worker'].
            "</td> <td>Рейтинг: ".$row['rating']."</td><td>Место: ".$row['place']."</td></tr>";
      }
    ?>
    </table>
    <div id="line_top_x" style="width: 70%; margin: 0 0 0 25%;"></div>
  </div> 

  <script type="text/javascript">

  google.charts.load("current", {packages:['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  var color;
  function drawChart() {    
    function colorRatting(n){
      if (n >= 80){
        color = "#2ee80e";
        return color;        
      } else if (n < 80 && n >= 50){
        color = "#fff292";
        return color;        
        }
          else {
            color = "#bb1717";
            return color;           
          };
    };    
    var data = google.visualization.arrayToDataTable([
      ["Веб-мастер", "Рейтинг", { role: "style" } ],
      <?php $data['ratings_last_month']->reset_pointer(); 
        while($row = $data['ratings_last_month']->fetch() ){
          echo "['".$row['worker']."', ".$row['rating'].", colorRatting(".$row['rating'].")],";
        }
      ?>     
    ]); 

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" },
                     2]);
    <?php $data['ratings_last_month']->reset_pointer(); ?>
    <?php $row = $data['ratings_last_month']->fetch(); ?>

    var options = {
      title: "Рейтинг за " + " <?php echo $data['month'][$row['month']]; ?> месяц" ,      
      height: 400,
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
    chart.draw(view, options);
}

</script>

<script type="text/javascript">

  google.charts.load('current', {'packages':['line']});
  google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = new google.visualization.DataTable();  

  data.addColumn('date', 'Month');
  namesOfMaster.forEach(
    function(item, i, namesOfMaster){
      data.addColumn('number', item); 
    });   

  data.addRows([
    <?php for($i = 0; $i < (int)date('m'); $i++): ?>
      [new Date(<?=(int)"20".date('y')?>, <?=$i?>),
        <?php $data['workers']->reset_pointer();?>

        <?php while($row_worker = $data['workers']->fetch() ): ?>
            <?php $data['ratings'][$i]->reset_pointer();$check = false; ?>

            <?php while($row_rating = $data['ratings'][$i]->fetch() ): ?>
                <?php if($row_rating['worker'] == $row_worker['worker']): ?>
                    <?=$row_rating['rating']?>,
                    <?php $check = true; break;?>
                <?php endif ?>
            <?php endwhile ?>
            
            <?php if(!$check): ?>
                null,
            <?php endif ?>
        <?php endwhile ?>
      ],
     <?php endfor ?>
  ]);

  var options = {
    chart: {
      title: 'Рейтинг за 2019',
      subtitle: 'в процентах %'
    },
    width: 900,    
    height: 500,
    axes: {
      x: {
        0: {side: 'bottom'}
      }
    }
  };

  var chart = new google.charts.Line(document.getElementById('line_top_x'));

  chart.draw(data, google.charts.Line.convertOptions(options));
}

</script>
<!-- ENDCONTENT -->

<!-- FOOTER -->
<footer class=bs-docs-footer> 
  <div class=container> 
    <p style="color:white;">&copy; Таблица рейтинга веб-мастеров 2017-2019</p> 
  </div>
</footer>
<!-- END FOOTER -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" 
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" 
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" 
        crossorigin="anonymous"></script>
<script src=https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js></script> 
<script src=/static/bootstrap/js/bootstrap.min.js></script>
<script src=/static/bootstrap/js/docs.min.js></script>
<script src=/static/bootstrap/js/customize.min.js></script> 
<script>var 
__configBridge={
  autoprefixerBrowsers:[
    "Android 2.3","Android >= 4",
    "Chrome >= 20","Firefox >= 24",
    "Explorer >= 8","iOS >= 6",
    "Opera >= 12","Safari >= 6"],
    jqueryCheck:[
      "if (typeof jQuery === 'undefined') {"
      ,"  throw new Error('Bootstrap\\'s JavaScript requires jQuery')"
      ,"}\n"
    ],
    jqueryVersionCheck:[
      "+function ($) {",
      "  'use strict';",
      "  var version = $.fn.jquery.split(' ')[0].split('.')",
      "  if ((version[0] < 2 && version[1] < 9) || (version[0] == 1 && version[1] == 9 && version[2] < 1) || (version[0] > 3)) {"
      ,"    throw new Error('Bootstrap\\'s JavaScript requires jQuery version 1.9.1 or higher, but lower than version 4')",
      "  }",
      "}(jQuery);\n\n"
      ]
  }
</script>
<script>var _gauges=_gauges||[];!function(){var e=document.createElement("script");e.async=!0,e.id="gauges-tracker",e.setAttribute("data-site-id","4f0dc9fef5a1f55508000013"),e.src="//secure.gaug.es/track.js";var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)}()</script> 
</body>
</html>