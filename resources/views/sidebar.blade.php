<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Laravel Test</title>
  <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="{{ url('/') }}/assets/css/style.css">
  <link rel="stylesheet" href="{{ url('/') }}/assets/css/app.css">
  <link rel="shortcut icon" href="{{ url('/') }}/assets/images/favicon.png" />
</head>
<body>
<div class="container-scroller">
  <!-- partial:partials/_sidebar.html -->
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
      <a class="sidebar-brand brand-logo" href="index.html"><img src="{{ url('/') }}/assets/images/logo.svg" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini" href="index.html"><img src="{{ url('/') }}/assets/images/logo-mini.svg" alt="logo" /></a>
      </div>
      <ul class="nav">
        <li class="nav-item profile">
          <div class="profile-desc">
            <div class="profile-pic">
              <div class="count-indicator">
              <img class="img-xs rounded-circle " src="{{ url('/') }}/assets/images/face15.jpg" alt="">
              <span class="count bg-success"></span>
            </div>
            <div class="profile-name">
                <h5 class="mb-0 font-weight-normal" style="color:white">{{ isset($logged_in_user->name) ? $logged_in_user->name : "" }} </h5>
                @if(isset($logged_in_user))
                <span>{{ $logged_in_user->user_type == 0 ? "Admin" : "Member"  }}</span>
                @endif
              </div>
          </div>
          </div>
        </li>
    <li class="nav-item nav-category">
      <span class="nav-link">Navigation</span>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ url('/dashboard')}}">
        <span class="menu-icon">
        <i class="mdi mdi-speedometer"></i>
        </span>
        <span class="menu-title">Dashboard</span>
        </a>
    </li>
    </ul>
  </nav>