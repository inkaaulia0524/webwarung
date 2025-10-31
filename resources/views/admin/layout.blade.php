<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - GudangMu</title>
    
    <style>
        :root {
            --primary-color:  #003366; 
            --primary-hover: #002244;
            --bg-light: #f4f7f6;
            --white: #ffffff;
            --text-dark: #333;
            --text-light: #f0f0f0;
            --border-color: #e0e0e0;
        }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* --- Sidebar --- */
        .sidebar {
            width: 250px;
            background-color: var(--primary-color);
            color: var(--text-light);
            display: flex;
            flex-direction: column;
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
        
        /* Ini untuk menandai link yang aktif */
        .sidebar-menu li.active a {
            background-color: var(--primary-hover);
            font-weight: 700;
        }

        /* --- Main Content --- */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* --- Top Header --- */
        .top-header {
            height: 60px;
            background-color: var(--white);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 2rem;
        }

        .profile-dropdown {
            position: relative;
            cursor: pointer;
        }
        
        .profile-icon {
            /* Ganti dengan <i class="fas fa-user-circle"></i> jika pakai FontAwesome */
            font-size: 1.8rem;
            color: var(--text-dark);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 45px;
            background-color: var(--white);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            width: 180px;
            overflow: hidden;
            z-index: 100;
        }

        .profile-dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu a, .dropdown-menu form button {
            display: block;
            padding: 12px 15px;
            text-decoration: none;
            color: var(--text-dark);
            font-size: 0.95rem;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-menu a:hover, .dropdown-menu form button:hover {
            background-color: #f0f0f0;
        }
        
        .dropdown-divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 5px 0;
        }

        /* --- Content Area --- */
        .content-area {
            padding: 2rem;
            flex-grow: 1;
        }
    </style>
</head>
<body>

    <div class="admin-layout">
        
        <aside class="sidebar">
            <div class="sidebar-header">
                GudangMu
            </div>
            
            <ul class="sidebar-menu">
                <li class="{{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
                </li>
                
                <li class="{{ Request::is('admin/data-barang*') ? 'active' : '' }}">
                    <a href="#">📦 Data Barang</a>
                </li>
                
                <li class="{{ Request::is('admin/data-supplier*') ? 'active' : '' }}">
                    <a href="#">👥 Data Supplier</a>
                </li>

                <li class="{{ Request::is('admin/barang-masuk*') ? 'active' : '' }}">
                    <a href="#">📥 Barang Masuk</a>
                </li>
                
                <li class="{{ Request::is('admin/barang-keluar*') ? 'active' : '' }}">
                    <a href="#">📤 Barang Keluar</a>
                </li>
                
                <li class="{{ Request::is('admin/laporan*') ? 'active' : '' }}">
                    <a href="#">📄 Laporan</a>
                </li>
                
                <li class="{{ Request::is('admin/grafik*') ? 'active' : '' }}">
                    <a href="#">📊 Grafik</a>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            
            <header class="top-header">
                <div class="profile-dropdown">
                    <div class="profile-icon">
                        🧑‍💼
                    </div>
                    <div class="dropdown-menu">
                        <a href="#">👤 Profile</a>
                        <div class="dropdown-divider"></div>
                        
                       <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">🚪 Logout</button>
    </form>
                    </div>
                </div>
            </header>
            
            <section class="content-area">
                
                @yield('content')
                
            </section>
        </main>
        
    </div>

</body>
</html>