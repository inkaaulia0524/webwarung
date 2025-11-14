<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WarungKu - Admin</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-color: #003366;
      --primary-hover: #002244;
      --bg-light: #f4f7f6;
      --white: #ffffff;
      --text-dark: #333;
      --text-light: #f0f0f0;
      --border-color: #e0e0e0;
      --danger-color: #cc0000;
      --danger-hover: #990000;
    }

    body {
      margin: 0;
      font-family: "Crimson Pro", serif;
      background-color: var(--bg-light);
      color: var(--text-dark);
    }

    .admin-layout {
      display: flex;
      min-height: 100vh;
    }

    /* SIDEBAR */
    .sidebar {
      width: 250px;
      background-color: var(--primary-color);
      color: var(--text-light);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      overflow: hidden;
    }

    .sidebar-header {
      padding: 1.5rem 1.25rem;
      font-size: 1.75rem;
      font-weight: 700;
      text-align: left;
      border-bottom: 1px solid var(--primary-hover);
      color: var(--white);
    }

    .sidebar-menu {
      list-style: none;
      padding: 1rem 0;
      margin: 0;
      flex-grow: 1;
    }

    .sidebar-menu li a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 1rem 1.25rem;
      color: var(--text-light);
      text-decoration: none;
      font-weight: 500;
      transition: background-color 0.3s ease;
    }

    .sidebar-menu li a:hover {
      background-color: var(--primary-hover);
    }

    .sidebar-menu li.active a {
      background-color: var(--primary-hover);
      font-weight: 700;
    }

    /* FOOTER SIDEBAR */
    .sidebar-footer {
      border-top: 1px solid var(--primary-hover);
      display: flex;
      flex-direction: column;
      width: 100%;
    }

    .sidebar-footer a,
    .sidebar-footer form button {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 1rem 1.25rem;
      color: var(--text-light);
      text-decoration: none;
      font-weight: 500;
      background: none;
      border: none;
      text-align: left;
      width: 100%;
      cursor: pointer;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .sidebar-footer a:hover {
      background-color: var(--primary-hover);
    }

    .sidebar-footer form button:hover {
      background-color: var(--danger-color);
      color: var(--white);
    }

    .sidebar-footer form button:active {
      background-color: var(--danger-hover);
    }

    /* MAIN CONTENT */
    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .top-header {
      height: 60px;
      background-color: var(--white);
      border-bottom: 1px solid var(--border-color);
      display: flex;
      justify-content: flex-end;
      align-items: center;
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .content-area {
      padding: 2rem;
      flex-grow: 1;
    }
  </style>
</head>
<body>

  <div class="admin-layout">
    
    <aside class="sidebar">
      <div>
        <div class="sidebar-header">WarungKu</div>
        <ul class="sidebar-menu">
          <li class="{{ Request::is('admin/dashboard*') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
          </li>
          <li class="{{ Request::is('admin/barang*') ? 'active' : '' }}">
            <a href="{{ route('barang.index') }}">📦 Data Barang</a>
          </li>
          <li class="{{ Request::is('admin/supplier*') ? 'active' : '' }}">
            <a href="{{ route('supplier.index') }}">👥 Data Supplier</a>
          </li>
          <li class="{{ Request::is('admin/pembelian*') ? 'active' : '' }}">
            <a href="{{ route('pembelian.index') }}">📥 Barang Masuk</a>
          </li>
          <li class="{{ Request::is('admin/pengeluaran*') ? 'active' : '' }}">
            <a href="{{ route('pengeluaran.index') }}">📤 Barang Keluar</a>
          </li>
          <li class="{{ Request::is('admin/laporan*') ? 'active' : '' }}">
            <a href="{{ route('laporan.index') }}">📄 Laporan</a>
          </li>
          <li class="{{ Request::is('admin/grafik*') ? 'active' : '' }}">
            <a href="{{ route('grafik.index') }}">📊 Grafik</a>
          </li>
        </ul>
      </div>

      <div class="sidebar-footer">
        <a href="{{ route('profile.edit') }}">👤 Profil</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit">🚪 Logout</button>
        </form>
      </div>
    </aside>

    <main class="main-content">
      <header class="top-header">
        <span>Admin Dashboard</span>
      </header>

      <section class="content-area">
        @yield('content')
      </section>
    </main>
  </div>

  @stack('scripts')

</body>
</html>