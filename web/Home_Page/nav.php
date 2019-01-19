<?php
// Got this code from sburton42
$file = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
// now $file will contain something like "about" and we can check later
// for this variable and use it to include the "active" class on the appropriate
// link item.
?>

    <!-- Navbar Code -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarTogglerDemo01"
        aria-controls="navbarTogglerDemo01"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="#">Austin Kincade</a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item <?php if ($file === 'home_page_main') echo 'active' ?>">
            <a class="nav-link" href="#"
              >Home <span class="sr-only">(current)</span></a
            >
          </li>
          <li class="nav-item <?php if ($file === 'github') echo 'active' ?>"><a class="nav-link" href="https://github.com/solodrpepper">About Me</a></li>
          <li class="nav-item <?php if ($file === 'cs313_assign_page') echo 'active' ?>"><a class="nav-link" href="#">GitHub</a></li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input
            class="form-control mr-sm-2"
            type="search"
            placeholder="Search"
            aria-label="Search"
          />
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
            Search
          </button>
        </form>
      </div>
    </nav>