<header class="site-header header" role="banner">
  <div class="top-bar container-fluid">
    <div class="top-bar-left">
      <div class="grid-x align-middle">
        <div class="site-title cell auto">
          @if (is_front_page())
            <h1>
              <a class="logo" href="{{ home_url('/') }}">
                {{ get_bloginfo('name', 'display') }}
              </a>
            </h1>
          @else
            <span class="h1">
              <a class="logo" href="{{ home_url('/') }}">
                {{ get_bloginfo('name', 'display') }}
              </a>
            </span>
          @endif
          <span class="subheader">
            <span class="text black">An Online Catalogue Raisonné of the Late Works, 1984-2016</span> <span class="site_author">by Irena Zdanowicz</span>
          </span>
        </div>
        <div class="hide-for-large cell shrink">
          <a class="mburger mburger--collapse" id="menu-trigger">
              <b></b>
              <b></b>
              <b></b>
              <span>Menu</span>
          </a>
        </div>
      </div>
    </div>
    <div class="top-bar-right">
      <div class="grid-x align-top">
        <nav class="nav-primary cell">
          @if (has_nav_menu('primary_navigation'))
            {!! wp_nav_menu([
              'theme_location' => 'primary_navigation',
              'container'=> false,
              'menu_class' => 'vertical large-horizontal menu',
              //'walker' => new \App\NavWalker()
            ])!!}
          @endif
        </nav>
      </div>
    </div>
  </div>
</header>

