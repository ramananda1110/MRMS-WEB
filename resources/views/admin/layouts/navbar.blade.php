<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - DDC Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('template/dist/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/ui-lightness/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>


    <style>
        .btn:hover {
            background-color: #B54D3D;
            /* Change this to your preferred hover color */
            color: white;
        }
    </style>

    <style>
        /* CSS for active sidebar item */
        .nav-link.show {
            background-color: #7bbbff;
            /* Change this to your desired background color */
            color: #fff;

            /* Change this to your desired text color */
        }

        /* Parent label styling for alignment */
        .custom-label {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            cursor: pointer;
        }

        /* Hide the default checkbox */
        .custom-slider {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .custom-slider-indicator {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            border-radius: 34px;
            transition: 0.4s;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            font-size: 14px;
            font-weight: bold;
            padding: 0 10px;
            box-sizing: border-box;
        }

        /* Circle inside the slider */
        .custom-slider-indicator:before {
            content: "";
            position: absolute;
            height: 26px;
            width: 26px;
            background-color: white;
            border-radius: 50%;
            bottom: 4px;
            left: 4px;
            transition: 0.4s;
        }

        /* When the checkbox is checked */
        .custom-slider:checked+.custom-slider-indicator {
            background-color: #373de2;

        }

        .custom-slider:checked+.custom-slider-indicator:before {
            transform: translateX(26px);
            /* Slide to the right */
        }

        /* Labels for on and off states */
        .on-label,
        .off-label {
            position: absolute;
            font-size: 12px;
            font-weight: bold;
            transition: opacity 0.4s;
        }

        .on-label {
            left: 10px;
        }

        .off-label {
            right: 10px;
        }

        /* Hide the inactive label */
        .custom-slider:checked+.custom-slider-indicator .off-label {
            opacity: 0;
        }

        .custom-slider:not(:checked)+.custom-slider-indicator .on-label {
            opacity: 0;
        }
    </style>



</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-light shadow-lg">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 text-center" href="{{ url('/') }}">{{ Auth()->user()->role->name }}</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                {{-- <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" /> --}}
                {{-- <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"> </i> --}}
                {{-- </button> --}}
            </div>
        </form>
        @php
            $lang = app()->getLocale();
        @endphp
        <div class="loader">
            <img src="{{ asset('images/Animation - 1737448447779.gif') }}" alt="">
        </div>
        <div class="form-check form-switch">
            <label class="form-check-label custom-label" for="toggleLanguage">
                <input type="checkbox" class="form-check-input custom-slider" id="toggleLanguage"
                    @if ($lang == 'bn') checked @endif onchange = "toggleLanguageFunction(this)">
                <span class="custom-slider-indicator">
                    <span class="on-label">
                        @if ($lang == 'bn')
                            BN
                        @else
                            EN
                        @endif
                    </span>
                    <span class="off-label">
                        @if ($lang == 'en')
                            EN
                        @else
                            BN
                        @endif
                    </span>
                </span>
            </label>
        </div>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw me-2">

                    </i>{{ Auth()->user()->name }}</a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ Route('user.profile') }}">User Profile</a></li>

                    {{-- <li><a class="dropdown-item" href="#!">Settings</a></li> --}}
                    <li> <a class="dropdown-item" href="{{ Route('change.password.form') }}">Change Password</a>
                    </li>

                    <li>
                        <hr class="dropdown-divider" />
                    </li>


                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </ul>
            </li>
        </ul>

    </nav>
    <script>
        function toggleLanguageFunction(toggle) {
            let lang;
            if (toggle.checked) {
                lang = 'bn';
            } else {
                lang = 'en';
            }

            window.location.href = `{{ url('switch-language') }}/${lang}`;
        }

        const toggleBtn = document.getElementById('toggleLanguage');

        toggleBtn.addEventListener('click', function() {
            const loader = document.querySelector(".loader");
            if (loader.style.display == 'none' || loader.style.display == '') {
                loader.style.display = 'block';
            } else {

                loader.style.display = 'none';
            }
        })
    </script>
