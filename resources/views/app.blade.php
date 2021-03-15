<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:400,700" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body class="font-sans">
        <div id="app">
            <div class="container px-5">
                <header class="py-6 mb-6 bg-red-dark rounded-lg pl-3">
                    <h1>
                        <img alt="Paje" src="/images/logo.png" width="18%">
                    </h1>
                </header>
                <main class="flex">
                    <aside class="w-1/5 pt-8 bg-grey-lighter pl-3 rounded-lg">
                        <section class="mb-10">
                            <h5 class="uppercase font-bold mb-5 text-base">The Brand</h5>

                            <ul class="list-reset">
                                <li class="text-sm leading-loose"><router-link class="text-black" active-class="font-bold" to="/" exact>Início</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-black" active-class="font-bold" to="/evaluations">Avaliações</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-black" active-class="font-bold" to="/games">Jogos</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-black" active-class="font-bold" to="/profile">Perfil</router-link></li>
                            </ul>
                        </section>

                        <section class="mb-8">
                            <h5 class="uppercase font-bold mb-5 text-base">Doodles</h5>

                            <ul class="list-reset">
                                <li class="text-sm leading-loose"><router-link class="text-black" active-class="font-bold" to="/3">Mascot</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-black" active-class="font-bold" to="/4">Illustrations</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-black" active-class="font-bold" to="/5">Loaders & Animations</router-link></li>
                                <li class="text-sm leading-loose"><router-link class="text-black" active-class="font-bold" to="/6">Wallpapers</router-link></li>
                            </ul>
                        </section>

                    </aside>

                    <div class="primary flex-1 ml-3">
                        <router-view></router-view>
                    </div>
                </main>
            </div>
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>
