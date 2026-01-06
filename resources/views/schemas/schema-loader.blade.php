@php
  $schemaMap = config('tool-schema');
  $path = request()->getPathInfo(); // e.g. "/tool/css-caching-test"
@endphp

@if (!empty($schemaMap[$path]))
  @include($schemaMap[$path])
@endif
