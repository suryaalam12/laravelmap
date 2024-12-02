<!DOCTYPE html>
<html  lang="en">
<head>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.pm@latest/dist/leaflet.pm.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.pm@latest/dist/leaflet.pm.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<style>
  #map { height: 100vh;
  z-index: 1000;}
</style>
<body>
  <x-peta-dashboard></x-peta-dashboard>
</body>
<script>
  var map;
  var lyrZnt;
  var dataPeta = JSON.parse(@json($data))
</script>
<script src="{{ asset('js/peta_dasar.js') }}"></script>
<script src="{{ asset('js/gambar_peta.js') }}"></script>
</html>