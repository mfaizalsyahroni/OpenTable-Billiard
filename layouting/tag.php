<header>
    <div>
        <a href="detailtable.php">MENYALA BILLIARD HALL</a>
    </div>
    <div>
        <?php
        if (isset($_SESSION['is_login'])) {
            echo "<div class='right'>";
            echo "<a href='reportdata.php'>REPORT</a>";
            echo "<a href='logoutclient.php'>LOGOUT</a>";
            echo "</div>";
        } else {
            echo "<a href='login.php'>login</a>";
        }
        ?>
    </div>
</header>