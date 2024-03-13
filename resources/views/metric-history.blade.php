@extends('template')

@section('content')
<div class="container">
  <table class="table">
    <thead>
      <tr class="table-dark">
        <th>URL</th>
        <th>Accessibility</th>
        <th>PWA</th>
        <th>SEO</th>
        <th>Performance</th>
        <th>Best Practices</th>
        <th>Strategy</th>
        <th>Datetime</th>
      </tr>
    </thead>
    <tbody>
      @foreach($metricRun as $run)
        <tr>
          <td>{{ $run->url }}</td>
          <td>{{ $run->accessibility_metric }}</td>
          <td>{{ $run->pwa_metric }}</td>
          <td>{{ $run->seo_metric }}</td>
          <td>{{ $run->performance_metric }}</td>
          <td>{{ $run->best_practices_metric }}</td>
          <td>{{ $run->strategy->name }}</td>
          <td>{{ $run->created_at }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection