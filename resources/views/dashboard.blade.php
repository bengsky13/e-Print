@php
$path = explode("/", url()->current())
@endphp
<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <title>Dashboard - e-Print</title>
 <x-header/>
</head>
<body>
<div class="layout-wrapper layout-content-navbar">
<div class="layout-container">
<x-sidebar/>
<div class="layout-page">
<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">
@switch(end($path))
    @case("outlet")
        <x-outlet/>
        @break
    @case("setting")
        <x-setting/>
        @break
    @default
        <x-dashboard/>
@endswitch
</div>
</div>
</div>
</div>
</div>
</body>