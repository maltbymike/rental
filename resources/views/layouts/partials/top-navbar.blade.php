<nav class="navbar fixed-top navbar-expand-md navbar-light bg-light navbar-laravel fixed-top">
  <a class="navbar-brand" href="{{ url('/') }}">
      <img class="img-responsive mr-4" src="/img/ingersoll_rent_all_logo.png" />
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav mr-auto">

        <li class="nav-item">
            <a class="nav-link font-weight-bold" href="/product/category">Rental Equipment</a>
        </li>

        <li class="nav-item">
            <a class="nav-link font-weight-bold" href="/#contact">Contact Us</a>
        </li>

      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ml-auto">

        @auth
        <li class="nav-item">
          <a class="nav-link font-weight-bold" href="/webadmin">Admin Home</a>
        </li>

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle font-weight-bold" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Inventory<span class="caret"></span>
          </a>

          <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/product/category">View Products</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/product/create">Add New Product</a>
            <a class="dropdown-item" href="/product/category/create">Add New Product Categories</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/product/upload">Upload Products from CSV</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle font-weight-bold" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Options <span class="caret"></span>
          </a>

          <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/settings/homepage">Homepage Options</a>
          </div>
        </li>
        @endauth

          <!-- Authentication Links -->
          @guest
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
              @if (Route::has('register'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>
              @endif
          @else


              <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      {{ Auth::user()->name }} <span class="caret"></span>
                  </a>

                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                  </div>
              </li>
          @endguest
      </ul>
  </div>
</nav>
