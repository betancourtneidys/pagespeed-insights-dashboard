@extends('template')

@section('content')

  <div class="container">
    <form id="pageSpeedForm">
      <div class="row g-3">

        <!-- Campo de entrada para URL con validación para asegurarse de que el input sea una URL válida -->
        <div class="col-md-3">
          <div class="form-floating">
            <input type="url" name="url" class="form-control" id="floatingInputGrid" required>
            <label for="floatingInputGrid">URL</label>
          </div>
        </div>

        <!-- Checkbox para cada categoría disponible. Itera sobre el array $categories para generar un checkbox por cada uno. -->
        <div class="col align-items-center">
          <p class="mb-2">CATEGORIES</p>
          @foreach ($categories as $category)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="category_{{ $category->name }}" name="categories[]" value="{{ $category->name }}">
              <label class="form-check-label" for="category_{{ $category->name }}">{{ $category->name }}</label>
            </div>
          @endforeach
        </div>

        <!-- Selector de estrategia con validación para asegurarse de que se elija una -->
        <div class="col-md-3">
          <div class="form-floating">
            <select class="form-select" id="floatingSelectGrid" name="strategy" required>
              @foreach($strategies as $strategy)
                <option value="{{ $strategy->name }}">{{ $strategy->name }}</option>
              @endforeach
            </select>
            <label for="floatingSelectGrid">STRATEGY</label>
          </div>
        </div>

      </div>
      <button type="submit" class="btn btn-outline-secondary mt-3">GET METRICS</button>
    </form>

    <div class="mt-5 mb-3">
      <div id="results"></div>
    </div>
    

    <div id="categoryError" class="text-danger"></div>
    <!-- Loader para mostrar mientras se carga la respuesta AJAX -->
    <div class="spinner-border m-5" role="status" style="display: none;">
      <span class="visually-hidden">Loading...</span>
    </div>

    <!-- Botón para guardar los resultados, inicialmente oculto y se muestra tras recibir la respuesta AJAX -->
    <button id="saveMetricRun" class="btn btn-outline-secondary my-8" style="display: none;">SAVE METRIC RUN</button>
    
    <!-- Contenedor para mostrar alertas de éxito o error -->
    <div id="alertContainer"></div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      var metric = null;
      $('#pageSpeedForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        // Verificar si al menos un checkbox de categoría está seleccionado
        var isAnyCategorySelected = $('.form-check-input:checked').length > 0;
        
        // Si no se seleccionó ninguna categoría, mostrar un mensaje y detener el proceso
        if (!isAnyCategorySelected) {
          $('#categoryError').html('Please select at least one category.').show();
          return false; // Detener la ejecución aquí
        } else {
          $('#categoryError').hide(); // Asegurarse de ocultar el mensaje si la validación es exitosa
        }

        // Deshabilitar botón y mostrar loader
        $('button[type="submit"]').prop('disabled', true).text('Loading...');
        $('.spinner-border').show();
        
        $.ajax({
          url: '/get-page-speed-metrics',
          type: 'GET',
          data: formData,
          success: function(response) {
            // Restablecer botón y ocultar loader
            $('button[type="submit"]').prop('disabled', false).text('GET METRICS');
            $('.spinner-border').hide();
            // Procesar respuesta
            if(response.lighthouseResult && response.lighthouseResult.categories) {
              metric = response.lighthouseResult.categories;
              var metricsHtml = '<div class="row">';
              
              // Generar HTML con los resultados
              Object.keys(metric).forEach(function(key) {
                var category = metric[key];
                var score = category.score ? category.score : 'Not available';

                // Crear tarjeta para cada categoría
                metricsHtml += `
                  <div class="col-md-2">
                    <div class="card mb-2 box-shadow">
                      <div class="card-header">
                        <h4 class="my-0 fw-normal">${category.title}</h4>
                      </div>
                      <div class="card-body">
                        <h1 class="fw-medium d-flex justify-content-center">${typeof score === 'number' ? score.toFixed(2) : score}</h1>
                      </div>
                    </div>
                  </div>
                `;
              });

              metricsHtml += '</div>'; // Cierra la fila
              $('#results').html(metricsHtml);
              $('#saveMetricRun').show();
            } else {
              // Manejar el caso en que no existan categorías disponibles
              $('#results').html('<p>No results found.</p>');
            }
          },
          error: function(error) {
            // Restablecer botón y ocultar loader en caso de error
            $('button[type="submit"]').prop('disabled', false).text('GET METRICS');
            $('.spinner-border').hide();
            $('#results').html('<p>There was an error processing your request.</p>');
          }
        });
      });

      // Manejar el clic del botón para guardar los resultados fuera de la función submit
      $('#saveMetricRun').on('click', function() {
          var url = $('input[name="url"]').val();
          var strategy = $('select[name="strategy"]').val();
          
         // Enviar solicitud AJAX para guardar los resultados
          $.ajax({
              url: '/save-metric-run',
              type: 'POST',
              data: {
                  _token: $('meta[name="csrf-token"]').attr('content'),
                  url: url,
                  strategy: strategy,
                  performance_metric: metric["performance"]?.score,
                  accessibility_metric: metric["accessibility"]?.score,
                  best_practices_metric: metric["best-practices"]?.score,
                  seo_metric: metric["seo"]?.score,
                  pwa_metric: metric["pwa"]?.score,
              },
              success: function(result) {
                // Mostrar alerta de éxito
                var alertHTML = '<div class="alert alert-success" role="alert">Metric successfully saved in <a href="/metric-history" class="alert-link">History</a>.</div>';
                $('#alertContainer').html(alertHTML);

                // Opción para ocultar la alerta automáticamente después de un tiempo
                setTimeout(function() {
                  $('#alertContainer').fadeOut('slow');
                }, 5000); // La alerta desaparece después de 5 segundos
              },
              error: function(error) {
                  alert('Error saving metric run');
              }
          });
      });
    });
  </script>

@endsection
