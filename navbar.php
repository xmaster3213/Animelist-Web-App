<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">
            <img
            src="public/logo.png"
            height="30"
            alt="Logo"
            loading="lazy"
            />
        </a>
        <form class="d-flex input-group w-auto" id="searchform" action="search.php" method="GET">
            <input
                type="search"
                class="form-control rounded"
                placeholder="Search"
                aria-label="Search"
                aria-describedby="search-addon"
                name="param"
            />
            <span style="cursor: pointer;" onclick="searchform.submit()" class="input-group-text border-0" id="search-addon">
                <i class="fas fa-search"></i>
            </span>
        </form>
        <div class="d-flex align-items-center">
            <a
                class="dropdown-toggle d-flex align-items-center hidden-arrow"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-mdb-toggle="dropdown"
                aria-expanded="false"
            >
                <img
                src="<?php echo $_SESSION['immagine']; ?>"
                class="rounded-circle"
                height="25"
                alt="Profile image"
                loading="lazy"
                />
            </a>
            <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="navbarDropdownMenuLink"
            >
                <li>
                <a class="dropdown-item" href="profile.php">Profilo</a>
                </li>
                <li>
                <a class="dropdown-item" href="animelist.php">My Animelist</a>
                </li>
                <li>
                <a class="dropdown-item" href="signout.php">Disconnettiti</a>
                </li>
            </ul>
        </div>
    </div>
</nav>