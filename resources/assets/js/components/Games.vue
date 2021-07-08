<template>
    <div class="float-left w-full">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 :is-full-page="fullPage">
        </loading>

<!--        MODAL DE CADASTRO-->
        <div v-if="showCreateModal" class="w-full grid justify-items-center text-white overflow-x-hidden overflow-y-auto over fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex-none full-screen">
            <div class="relative w-auto my-6 mx-auto max-w-6xl flex">
                <div class="w-1/5"></div>
                <!--content-->
                <div class="border-0 rounded-lg shadow-lg relative flex-none flex-col w-3/5 full-screen bg-purple outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-purple-darker rounded-t">
                        <h3 class="text-3xl font-semibold">
                            Cadastrar Jogo
                        </h3>
                        <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" v-on:click="toggleCreateModal()">
                          <span class="bg-transparent text-white opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                          </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="w-full relative p-6 flex-none">
                        <div class="width-high flex-auto">
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <input class="h-10" type="text" v-model="newGameTitle" placeholder="Título do Jogo">
                            </div>
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <select name="parentalRating" v-model="newGameParentalRating">
                                    <option value="0">L</option>
                                    <option value="10">10</option>
                                    <option value="12">12</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                                    <option value="18">18</option>
                                </select>
                            </div>
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <input type="file"  accept="image/*" name="image" id="file"  @change="loadFile" style="display: none;">
                                <div class="image-container">
                                    <p><label for="file" style="cursor: pointer;">
                                        <img class="h-48 w-32 image" :src="'images/covers/' + newGameCover">
                                    </label></p>
                                    <div class="middle">
                                        <p><label for="file" style="cursor: pointer;">
                                            <img class="h-12 w-12 rounded-lg" :src="'images/camera_icon.jpg'">
                                        </label></p>
                                    </div>
                                </div>

                            </div>
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <textarea cols="30" rows="10" required autofocus placeholder="Descrição do Jogo" v-model="newGameDescription"></textarea>
                            </div>
                        </div>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-purple-darker rounded-b">
                        <button class="text-white bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleCreateModal()">
                            Fechar
                        </button>
                        <button class="text-white background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="addNewGame()">
                            Cadastrar Jogo
                        </button>
                    </div>
                </div>
                <div class="w-1/5"></div>
            </div>
        </div>

<!--        MODAL DE EDIÇÃO-->
        <div v-if="showEditModal" class="w-full grid justify-items-center text-white overflow-x-hidden overflow-y-auto over fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex-none full-screen">
            <div class="relative w-auto my-6 mx-auto max-w-6xl flex">
                <div class="w-1/5"></div>
                <!--content-->
                <div class="border-0 rounded-lg shadow-lg relative flex-none flex-col w-3/5 full-screen bg-purple outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-purple-darker rounded-t">
                        <h3 class="text-3xl font-semibold">
                            Editar Jogo
                        </h3>
                        <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" v-on:click="toggleEditModal()">
                          <span class="bg-transparent text-white opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                          </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="w-full relative p-6 flex-none">
                        <div class="width-high flex-auto">
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <input class="h-10" type="text" v-model="editingGameTitle" placeholder="Título do Jogo">
                            </div>
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <select name="parentalRating" v-model="editingGameParentalRating">
                                    <option value="0">L</option>
                                    <option value="10">10</option>
                                    <option value="12">12</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                                    <option value="18">18</option>
                                </select>
                            </div>
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <input type="file"  accept="image/*" name="image" id="fileEdit"  @change="loadFile" style="display: none;">
                                <div class="image-container">
                                    <p><label for="fileEdit" style="cursor: pointer;">
                                        <img class="h-48 w-32 image" :src="'images/covers/' + editingGameCover">
                                    </label></p>
                                    <div class="middle">
                                        <p><label for="file" style="cursor: pointer;">
                                            <img class="h-12 w-12 rounded-lg" :src="'images/camera_icon.jpg'">
                                        </label></p>
                                    </div>
                                </div>

                            </div>
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <textarea cols="30" rows="10" required autofocus placeholder="Descrição do Jogo" v-model="editingGameDescription"></textarea>
                            </div>
                        </div>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-purple-darker rounded-b">
                        <button class="text-white bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleEditModal()">
                            Fechar
                        </button>
                        <button class="text-white background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="editGame()">
                            Cadastrar Jogo
                        </button>
                    </div>
                </div>
                <div class="w-1/5"></div>
            </div>
        </div>







        <div v-if="showCreateModal" class="opacity-25 fixed inset-0 z-40 bg-black full-screen"></div>

        <div class="text-center">
            <h1>Jogos</h1>
        </div>

        <div v-if="isAdmin" class="w-full justify-center flex mt-10 mb-6">
            <button class="bg-green text-white active:bg-green-dark font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleCreateModal()">
                Cadastrar Jogo
            </button>
        </div>

        <div class="w-full justify-center flex mt-10 mb-6">
            <input class="h-10 w-2/5" type="text" v-model="searchGameTitle" placeholder="Nome do Jogo">
            <button class="bg-green w-1/5 h-10 text-white font-bold" v-on:click="">Pesquisar</button>
        </div>

        <div class="flex bg-green m-1 p-1 rounded-lg" v-for="game in games">
            <div class="w-1/5">
                <img class="h-48 w-32 image rounded-sm" :src="'images/covers/' + game.cover">
            </div>
            <div class="w-2/5">
                <h2>{{game.title}}</h2>
                <p>Nota geral: {{game.grade}}</p>
                <p>Classificação indicativa: {{game.parental_rating}}</p>
                <p>Descrição: {{game.description}}</p>
                <p>Categorias: -</p>
            </div>
            <div class="w-2/5">
                <button v-if="isAdmin" class="bg-purple w-1/4 text-white h-8 font-bold rounded-lg" v-on:click="prepareGameCategoriesEdit(game)">Categorias</button>
                <button v-if="isAdmin" class="bg-purple w-1/4 text-white h-8 font-bold rounded-lg" v-on:click="prepareGameEdit(game)">Editar</button>
                <button v-if="isAdmin" class="bg-purple w-1/4 text-white h-8 font-bold rounded-lg" v-on:click="deleteGame(game)">Excluir</button>
            </div>
        </div>

    </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import User from "../services/User";

export default {
    data() {
        return {
            isLoading: false,
            fullPage: true,
            showCreateModal: false,
            showEditModal: false,

            isAdmin: false,

            newGameTitle: '',
            newGameDescription: '',
            newGameCover: 'default_cover.png',
            newGameParentalRating: 0,

            editingGameId: 0,
            editingGameTitle: '',
            editingGameDescription: '',
            editingGameCover: 'default_cover.png',
            editingGameParentalRating: 0,

            searchGameTitle: '',

            games:[]
        }
    },
    components: {
        Loading
    },
    created: function () {
        this.isLoading = true;

        this.$https.post('/current-user')
            .then((response) => {
                if (response.data) {
                    if (response.data.is_admin) {
                        this.isAdmin = true;
                    } else {
                        this.isAdmin = false;
                    }
                }
            });

        this.$https.post('/all-games')
            .then((response) => {
                console.log(response.data);
                if (response.data) {
                    let games = response.data;

                    games.forEach(function (game, index, games) {
                        games[index] = {
                            id: game.id,
                            title: game.title,
                            description: game.description,
                            grade: game.grade,
                            cover: game.cover,
                            parental_rating: game.parental_rating
                        };
                    });

                    this.games = games;

                    this.isLoading = false;
                } else {
                    this.$router.push('/notFound');
                    this.isLoading = false;
                }
            });
    },
    methods: {
        toggleCreateModal: function(){
            this.showCreateModal = !this.showCreateModal;
        },
        toggleEditModal: function(){
            this.showEditModal = !this.showEditModal;
        },
        addNewGame() {
            this.isLoading = true;

            let payload = {
                title: this.newGameTitle,
                parentalRating: this.newGameParentalRating,
                cover: this.newGameCover,
                description: this.newGameDescription
            };

            this.$https.post('/add-game', payload)
                .then((response) => {
                    this.games.unshift({
                        'id': response.data.id,
                        'title': response.data.title,
                        'parental_rating': response.data.parental_rating,
                        'cover': response.data.cover,
                        'description': response.data.description,
                        'grade': response.data.grade
                    });

                    this.newGameTitle = '';
                    this.newGameParentalRating = '';
                    this.newGameCover = '';
                    this.newGameDescription = '';

                    this.toggleCreateModal();
                    this.isLoading = false;
                });
        },
        prepareGameEdit(game) {
            this.editingGameId = game.id;
            this.editingGameTitle = game.title;
            this.editingGameDescription = game.description;
            this.editingGameCover = game.cover;
            this.editingGameParentalRating = game.parental_rating;
            this.toggleEditModal();
        },
        // prepareGameCategoriesEdit(category) {
        //     console.log('FOI?');
        //     this.editingCategory = category.name;
        //     this.editingCategoryId = category.id;
        // },
        cancelGameEdit() {
            this.editingGameId = 0;
            this.editingGameTitle = '';
            this.editingGameDescription = '';
            this.editingGameCover = '';
            this.editingGameParentalRating = 0;
        },
        editGame() {
            this.isLoading = true;

            let payload = {
                game: this.editingGameId,
                newTitle: this.editingGameTitle,
                newCover: this.editingGameCover,
                newParentalRating: this.editingGameParentalRating,
                newDescription: this.editingGameDescription,
            };

            this.$https.post('/edit-game', payload)
                .then((response) => {
                    if (response.data === 'failed') {
                        this.isLoading = false;
                        return
                    }

                    const gameId = this.editingGameId;

                    this.games.forEach(function (currentGame, index, games) {
                        if (currentGame.id === gameId) {
                            games[index].title = response.data.title;
                            games[index].cover = response.data.cover;
                            games[index].parental_rating = response.data.parental_rating;
                            games[index].description = response.data.description;
                        }
                    });

                    this.toggleEditModal();
                    this.cancelGameEdit();

                    this.isLoading = false;
                });
        },
        deleteGame(game) {
            this.isLoading = true;

            let payload = {
                game: game.id
            };

            this.$https.post('/delete-game', payload)
                .then((response) => {
                    if (response.data !== 'deleted') {
                        this.isLoading = false;
                        return
                    }

                    this.games.forEach(function (currentGame, index, games) {
                        if (currentGame.id === game.id) {
                            games.splice(index, 1);
                        }
                    });

                    this.isLoading = false;
                });
        },
        loadFile(event) {
            let file = event.target.files[0];

            var reader = new FileReader;

            reader.onload = (event) => {
                this.isLoading = true;

                this.image = event.target.result;

                let payload = {
                    image: event.target.result
                };

                this.$https.post('/load-cover', payload)
                    .then((response) => {
                    console.log('response: ' + response.data);
                    switch (response.data) {
                        case 'invalidExtension':
                            const options = {title: 'Extensão inválida', size: 'sm'}
                            this.$dialogs.alert('Tente utilizar uma imagem com extensão .png ou .jpg', options)
                            break;
                        default:
                            if (this.showCreateModal)
                                this.newGameCover = response.data;
                            if (this.showEditModal)
                                this.editingGameCover = response.data;
                            this.isLoading = false;
                    }
                });
            };

            reader.readAsDataURL(file);
        },
    }
}
</script>
