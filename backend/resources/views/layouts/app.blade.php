<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @vite(['resources/js/echo.js'])

</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <h1 class="site">O'refuge</h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" style="margin:auto 50px;" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link fs-5 " aria-current="page" href="/animaux">Liste animaux</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5 admin-link" aria-current="page" href="/users-list">Utilisateurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5 admin-link" aria-current="page" href="/messages">Contacts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5 " href="show-register">S'enregistrer</a>
                        </li>

                        @auth
                        <!-- L'utilisateur est connecté, on affiche les éléments pour utilisateur connecté -->

                        <li class="nav-item">
                            <a class="nav-link fs-5" aria-current="page" href="/logout">Déconnexion</a>
                        </li>
                        <li class="nav-item_auth ">
                            <div class="nav-link_auth fs-5">Connecté en tant que {{ auth()->user()->email }}</div>
                        </li>


                        @else
                        <!-- L'utilisateur n'est pas connecté, on affiche les éléments pour utilisateur non connecté -->
                        <li class="nav-item">
                            <a class="nav-link  fs-5" aria-current="page" href="login">Se connecter</a>
                        </li>


                        @endauth




                    </ul>
                </div>

            </div>
        </nav>
    </header>
    @yield('content')
    @if(!auth()->user() || !in_array('ROLE_ADMIN', auth()->user()->roles ?? []))
    <div id="accessDenied" class="access-denied hidden">
        <div class="access-box">
            <h2>🚫 Accès refusé</h2>
            <p>Vous devez être administrateur pour accéder à cette page.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Bloquer tous les liens admin du site (layout + pages)
            document.querySelectorAll('.admin-link').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    showAccessDenied();
                });
            });

            // Bloquer les formulaires admin
            document.querySelectorAll('.admin-form').forEach(form => {
                form.addEventListener('submit', e => {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    showAccessDenied();
                });
            });


            function showAccessDenied() {
                const box = document.getElementById('accessDenied');
                box.classList.remove('hidden');
                box.classList.add('fade-in');
                setTimeout(() => {
                    box.classList.remove('fade-in');
                    box.classList.add('fade-out');
                    setTimeout(() => {
                        box.classList.remove('fade-out');
                        box.classList.add('hidden');
                    }, 400);
                }, 2000);
            }
        });
    </script>

    <style>
        .access-denied {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.4);
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .access-denied.hidden {
            display: none;
        }

        .access-denied.fade-in {
            display: flex;
            opacity: 1;
        }

        .access-denied.fade-out {
            opacity: 0;
        }

        .access-box {
            background-color: rgb(53, 66, 84);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            box-shadow: 2px 2px 10px 1px #f9faf9;

            width: min(90%, 400px);
            transform: translateY(-10px);
            animation: slideIn 0.4s ease-out forwards;
        }

        .access-box h2 {
            color: #e74c3c;
            margin-bottom: .5rem;
        }

        .access-box p {
            color: white;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @endif
</body>

</html>