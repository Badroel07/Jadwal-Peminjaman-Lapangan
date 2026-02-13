<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Peminjaman Lapangan</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bulma CSS (Local) -->
    <link rel="stylesheet" href="{{ asset('css/bulma.css') }}">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS (with versioning) -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

    <!-- Air Datepicker (Modern Date Picker) - Local to avoid tracking prevention -->
    <link rel="stylesheet" href="{{ asset('css/air-datepicker.min.css') }}">
</head>
<body>
    <nav class="navbar is-dark shadow-sm" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item brand-logo" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Technocrat" style="max-height: 40px;">
                    <strong>Booking Lapangan</strong>
                </a>

                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMain">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarMain" class="navbar-menu">
                <div class="navbar-end">
                    <a href="{{ url('/') }}" class="navbar-item font-medium">
                        Jadwal
                    </a>
                    <div class="navbar-item">
                        <div class="buttons">
                            <a href="{{ url('/book') }}" class="button is-primary is-rounded font-medium">
                                <strong>Booking Sekarang</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="container is-fluid px-5 py-5">
            @if(session('success'))
                <div class="notification is-success is-light shadow-sm">
                    <button class="delete"></button>
                    <span class="icon-text">
                        <span class="icon has-text-success"><i class="fas fa-check-circle"></i></span>
                        <span>{{ session('success') }}</span>
                    </span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="notification is-danger is-light shadow-sm">
                    <button class="delete"></button>
                    <span class="icon-text">
                        <span class="icon has-text-danger"><i class="fas fa-exclamation-circle"></i></span>
                        <span>{{ session('error') }}</span>
                    </span>
                </div>
            @endif

            @if($errors->any())
                <div class="notification is-danger is-light shadow-sm">
                    <button class="delete"></button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <footer class="footer">
        <div class="content has-text-centered">
            <p>
                <strong>Sistem Peminjaman Lapangan</strong>
                <br>
                Dikelola oleh <strong class="has-text-warning">UKM Technocrat ITG</strong> &copy; {{ date('Y') }}
            </p>
        </div>
    </footer>

    <script src="{{ asset('js/air-datepicker.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Air Datepicker for ID locale
            new AirDatepicker('.datepicker', {
                locale: {
                    days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                    daysShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    daysMin: ['Mi', 'Se', 'Sl', 'Ra', 'Ka', 'Ju', 'Sa'],
                    months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    today: 'Hari ini',
                    clear: 'Hapus',
                    dateFormat: 'yyyy-MM-dd',
                    timeFormat: 'HH:mm',
                    firstDay: 1
                },
                minDate: new Date(),
                autoClose: true,
                classes: 'is-dark', // Add a custom class for easier targeting
            });

            // Notification delete logic
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });

            // Navbar Burger logic
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
            if ($navbarBurgers.length > 0) {
                $navbarBurgers.forEach( el => {
                    el.addEventListener('click', () => {
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');
                    });
                });
            }
        });
    </script>
</body>
</html>
