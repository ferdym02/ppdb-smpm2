<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ $title }} | PPDB SMPM 2 Kalianda</title>
    <!-- Favicon-->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('dashboard_user_assets/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/087ab49e30.js" crossorigin="anonymous"></script>
    <style>
        body {
            overflow: hidden;
        }

        #wrapper {
            height: 100vh;
            overflow: hidden;
        }

        /* SIDEBAR */
        /* SIDEBAR */
        #sidebar-wrapper {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1040;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        /* Hide default (desktop only via toggled) */
        #wrapper.toggled #sidebar-wrapper {
            left: -250px;
        }

        /* PAGE CONTENT */
        #page-content-wrapper {
            margin-left: 250px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        #wrapper.toggled #page-content-wrapper {
            margin-left: 0;
        }

        /* NAVBAR HARUS LEBIH TINGGI */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1050;
        }

        /* CONTENT */
        .content-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        /* OVERLAY (mobile only) */
        .overlay {
            display: none;
        }

        #wrapper.show-sidebar .overlay {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1030;
        }

        /* MOBILE */
        @media (max-width: 768px) {

            #sidebar-wrapper {
                left: -250px;
                z-index: 1040;
            }

            #wrapper.show-sidebar #sidebar-wrapper {
                left: 0;
            }

            #page-content-wrapper {
                margin-left: 0;
            }
        }

        .list-group-item.active {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }
    </style>
    @yield('css')
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="overlay"></div>
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light d-flex align-items-center">
                <img src="{{ asset('storage/' . $profile->logo_sekolah) }}" alt="Logo Sekolah" height="25"
                    class="me-2">
                <span>SMPM 2 Kalianda</span>
            </div>
            <div class="list-group list-group-flush">
                <a href="/user/dashboard"
                    class="list-group-item list-group-item-action p-3 {{ request()->is('user/dashboard*') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="/user/pendaftaran"
                    class="list-group-item list-group-item-action p-3 {{ request()->is('user/pendaftaran*') ? 'active' : '' }}">
                    Pendaftaran
                </a>
                <a href="/user/informasi"
                    class="list-group-item list-group-item-action p-3 {{ request()->is('user/informasi*') ? 'active' : '' }}">
                    Informasi Pendaftaran
                </a>
                <a href="/user/pengumuman"
                    class="list-group-item list-group-item-action p-3 {{ request()->is('user/pengumuman*') ? 'active' : '' }}">
                    Pengumuman
                </a>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-secondary" id="sidebarToggle"><i class="fa-solid fa-list"></i></button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><span
                            class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                        class="bi bi-person-circle"></i> {{ Auth::user()->name }}</a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('user.profile') }}">Profil</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item logout-link" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                </div>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="content-scroll">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('dashboard_user_assets/js/scripts.js') }}"></script>
    <script>
        const wrapper = document.getElementById("wrapper");
        const toggleBtn = document.getElementById("sidebarToggle");
        const overlay = document.querySelector(".overlay");

        toggleBtn.addEventListener("click", function() {
            if (window.innerWidth <= 768) {
                wrapper.classList.toggle("show-sidebar");
            } else {
                wrapper.classList.toggle("toggled");
            }
        });

        overlay.addEventListener("click", function() {
            wrapper.classList.remove("show-sidebar");
        });
    </script>
    @yield('scripts')
</body>

</html>
