<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <!-- レスポンシブデザイン -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title 属性値 -->
    <title>{{ config('app.name', 'Vue Laravel SPA') }}</title>

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <header-component></header-component>
    <div class="container">
        <example-component></example-component>
        <router-view></router-view>
    </div>
</div>
<!-- Scripts -->
<script src="{{ mix('/js/app.js') }}" defer></script>
</body>
</html>
