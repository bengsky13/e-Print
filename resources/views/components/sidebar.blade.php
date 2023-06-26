@php
$path = explode("/", url()->current())

@endphp
{{end($path)}}
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="/dashboard" class="app-brand-link">
      <span class="app-brand-text display-5 fw-bolder ms-2">ePrint</span>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>
  <ul class="menu-inner py-1">
    <li class="menu-item{{end($path) == 'dashboard' ? ' active' : ''}}">
      <a href="/dashboard" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    <li class="menu-item{{end($path) == 'setting' ? ' active' : ''}}">
      <a href="/dashboard/setting" class="menu-link">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Analytics">Setting</div>
      </a>
    </li>
    <li class="menu-item{{end($path) == 'outlet' ? ' active' : ''}}">
      <a href="/dashboard/outlet" class="menu-link">
        <i class="menu-icon tf-icons bx bx-map-pin"></i>
        <div data-i18n="Analytics">Outlet</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="/logout" class="menu-link">
        <i class="menu-icon tf-icons bx bx-log-out-circle"></i>
        <div data-i18n="Analytics">Logout</div>
      </a>
    </li>
  </ul>
</aside>

