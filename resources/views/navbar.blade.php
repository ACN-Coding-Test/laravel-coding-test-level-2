

<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_navbar.html -->
<nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{ url('/') }}/assets/images/logo-mini.svg" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            
            <ul class="navbar-nav w-100">
              <li class="nav-item w-100">
                <p class="preview-subject mb-1"><a href="{{ url('/dashboard')}}">Laravel Test</p>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              @isset( $logged_in_user)
              <!-- condition to show create new project button to Admin and Product owner only --> 
                @if( $logged_in_user->user_type == 1 || $logged_in_user->user_type == 0)
                  <li class="nav-item dropdown d-none d-lg-block">
                    <!-- data-toggle="modal" data-target="#myModal" -->
                    <a class="nav-link btn btn-success create-new-button" id="cnp" onclick="showMyTaskPopup()">+ Create New Project</a>
                  </li>
                @endif
              @endif
              <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="{{ url('/logout')}}">
                <div class="preview-item-content">
                      <p class="preview-subject mb-1">Log out</p>
                    </div>
                </a>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>

        <script src="{{ url('/') }}/assets/js/app.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>