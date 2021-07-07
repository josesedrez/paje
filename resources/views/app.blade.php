<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:400,700" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
        @toastr_css
    </head>
    <body class="font-sans bg-purple-dark text-white">
        <div id="app">
            <div class="container px-5">
                <header class="mb-6 w-full min-width-header bg-purple rounded-lg flex">
                    <div class="w-1/5">
                        <h1>
                            <img alt="Paje" src="/images/logo.png" width="100%">
                        </h1>
                    </div>
                    <div class="w-3/5"></div>
                    <div class="w-1/5 justify-center flex">
                        <ul class="list-reset">
                            <!-- Authentication Links -->
                            @guest
                                <li class="text-sm leading-loose"><router-link class="text-white" active-class="font-bold" to="/login">Entrar</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-white" active-class="font-bold" to="/register">Cadastre-se</router-link></li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="text-white" href=""
                                       onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                        Sair
                                    </a>

                                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </header>
                <main class="flex">
                    <aside class="w-1/5 pt-8 bg-purple pl-3 rounded-lg">
                        <section class="mb-10">
                            <h5 class="uppercase font-bold mb-5 text-base">Menu</h5>

                            <ul class="list-reset">
                                <li class="text-sm leading-loose"><router-link class="text-white" active-class="font-bold" to="/" exact>Início</router-link></li>
                                @if(Auth::check() && Auth::user()->is_admin)
                                    <li class="text-sm leading-loose"><router-link class="text-white" active-class="font-bold" to="/categories">Categorias</router-link></li>
                                @endif
                                <li class="text-sm leading-loose"><router-link class="text-white" active-class="font-bold" to="/evaluations">Avaliações</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-white" active-class="font-bold" to="/games">Jogos</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-white" active-class="font-bold" to="/users">Usuários</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-white" active-class="font-bold" to="/profile">Perfil</router-link></li>
                            </ul>
                        </section>

                        <section class="mb-8">
                            <h5 class="uppercase font-bold mb-5 text-base">Sobre</h5>

                            <ul class="list-reset">
                                <li class="text-sm leading-loose"><router-link class="text-white" active-class="font-bold" to="/3">Como avaliar</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-white" active-class="font-bold" to="/4">Likes & Recompensas</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-white" active-class="font-bold" to="/6">Personalização</router-link></li>
                            </ul>
                        </section>

                    </aside>

                    <div class="primary flex-1 w-4/5 min-width flex-1 ml-3 p-3 bg-purple rounded-lg justify-center align-content-center align-items-center">
                        <router-view></router-view>
                    </div>
                </main>
            </div>
        </div>

        <script src="/js/app.js"></script>
    </body>
    @jquery
    @toastr_js
    @toastr_render
</html>
