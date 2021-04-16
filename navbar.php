<?php
//Editar isto
if (isset($_SESSION['username'])) {
?>
<nav class="navbar navbar-expand-md navbar-dark corNav">
        <a class="navbar-brand" href="index.php">Games R Us</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="games.php">Games</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="playersOnline.php">Players Online</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Welcome, <?php echo $_SESSION['username'] ?>
                </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <?php
                        if ($_SESSION['isAdmin'] == '0') { ?>
                            <a class="dropdown-item" href="matchhistory.php">Match History</a>
                        <?php
                        }
                        ?>
                        <?php
                        if ($_SESSION['isAdmin'] == '1') { ?>
                            <a class="dropdown-item" href="manageusers.php">Manage Users</a>
                        <?php
                        }
                        ?>
                        <?php
                        if ($_SESSION['isAdmin'] == '1') { ?>
                            <a class="dropdown-item" href="manageprofileimages.php">Manage Profile Pictures</a>
                        <?php
                        }
                        ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="?logout">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
<?php
} else {
?>
    <nav class="navbar navbar-expand-md navbar-dark corNav">
        <a class="navbar-brand" href="index.php">Games R Us</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            </ul>
        </div>
    </nav>
<?php
}
?>