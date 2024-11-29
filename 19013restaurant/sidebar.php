    <div class="sidebar">
        <h2>Yummy Yippie</h2>
        <a href="index.php?page=beranda" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'beranda') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> Beranda
        </a>
        <a href="menu.php?page=menu" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'menu') ? 'active' : ''; ?>">
            <i class="fas fa-utensils"></i> Daftar Menu
        </a>
        <a href="order.php?page=order" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'order') ? 'active' : ''; ?>">
            <i class="fas fa-receipt"></i> Order
        </a>
        <a href="transaksi.php?page=transaksi" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'transaksi') ? 'active' : ''; ?>">
            <i class="fas fa-exchange-alt"></i> Transaksi
        </a>
        <a href="logout.php" class="nav-link logout-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
