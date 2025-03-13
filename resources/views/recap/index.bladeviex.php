<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EasyPieChart with Bootstrap 5</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- EasyPieChart CSS (optionnel pour le style personnalisé) -->
  <style>
    .chart {
      width: 120px;
      height: 120px;
      line-height: 120px;
      text-align: center;
      margin: 0 auto;
      position: relative;
    }
    .chart canvas {
      position: absolute;
      top: 0;
      left: 0;
    }
    .chart .percent {
      font-size: 24px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container my-5">
    <h1 class="text-center mb-4">EasyPieChart with Bootstrap 5</h1>
    <div class="row">
      <!-- Chart 1 -->
      <div class="col-md-4 text-center">
        <div class="chart" data-percent="75" data-bar-color="#0d6efd">
          <span class="percent">75%</span>
        </div>
        <p class="mt-2">Progress 1</p>
      </div>
      <!-- Chart 2 -->
      <div class="col-md-4 text-center">
        <div class="chart" data-percent="50" data-bar-color="#198754">
          <span class="percent">50%</span>
        </div>
        <p class="mt-2">Progress 2</p>
      </div>
      <!-- Chart 3 -->
      <div class="col-md-4 text-center">
        <div class="chart" data-percent="90" data-bar-color="#dc3545">
          <span class="percent">90%</span>
        </div>
        <p class="mt-2">Progress 3</p>
      </div>
    </div>
  </div>

  <script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>
  <script src="{{ url('assets/js/scripts.bundle.js') }}"></script>
  <script src="{{ url('assets/plugins/easypie.min.js') }}" type="text/javascript"></script>
  <!-- Custom JS -->
  <script>
    $(document).ready(function () {
      $('.chart').easyPieChart({
        scaleColor: false,
        trackColor: '#f5f5f5',
        size: 120,
        lineWidth: 8,
        animate: 1000
      });
    });
  </script>
</body>
</html>
