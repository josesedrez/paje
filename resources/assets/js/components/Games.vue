<template>
    <div class="float-left w-full">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 :is-full-page="fullPage">
        </loading>

        <!--        MODAL DE EXCLUSÃO-->
        <div v-if="showDeleteModal" class="w-full grid justify-items-center text-white overflow-x-hidden overflow-y-auto over fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex-none full-screen">
            <div class="relative w-auto my-6 mx-auto max-w-6xl flex">
                <div class="w-1/5"></div>
                <!--content-->
                <div class="border-0 rounded-lg shadow-lg relative flex-none flex-col w-3/5 full-screen bg-purple outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-purple-darker rounded-t">
                        <h3 class="text-3xl font-semibold">
                            Excluir Jogo
                        </h3>
                        <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" v-on:click="toggleDeleteModal()">
                          <span class="bg-transparent text-white opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                          </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="w-full relative p-6 flex-none">
                        <div class="flex-auto">
                            <p>Tem certeza que deseja exluir este jogo?</p>
                        </div>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-purple-darker rounded-b">
                        <button class="text-white bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleDeleteModal()">
                            Cancelar
                        </button>
                        <button class="text-white background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="deleteGame(deletingGameId)">
                            Excluir
                        </button>
                    </div>
                </div>
                <div class="w-1/5"></div>
            </div>
        </div>
        <div v-if="showDeleteModal" class="opacity-25 fixed inset-0 z-40 bg-black full-screen"></div>


        <!--        MODAL DE GRAFICO-->
        <div v-if="showGraphModal" class="w-full grid justify-items-center text-white overflow-x-hidden overflow-y-auto over fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex-none full-screen">
            <div class="relative w-auto my-6 mx-auto max-w-6xl flex">
                <div class="w-1/5"></div>
                <!--content-->
                <div class="border-0 rounded-lg shadow-lg relative flex-none flex-col w-3/5 full-screen bg-purple outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-purple-darker rounded-t">
                        <h3 class="text-3xl font-semibold">
                            Métricas do Jogo
                        </h3>
                        <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" v-on:click="toggleGraphModal()">
                          <span class="bg-transparent text-white opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                          </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="w-full relative p-6 flex-none">
                        <div class="flex-auto mb-3">
                            <h3>Mecânica de Jogo</h3>
                            <GChart
                                type="ColumnChart"
                                :data="graphGM"
                                :options="chartOptions"
                            />
                        </div>
                        <div class="flex-auto mb-3">
                            <h3>História</h3>
                            <GChart
                                type="ColumnChart"
                                :data="graphST"
                                :options="chartOptions"
                            />
                        </div>
                        <div class="flex-auto">
                            <h3>Audio-Visual</h3>
                            <GChart
                                type="ColumnChart"
                                :data="graphAU"
                                :options="chartOptions"
                            />
                        </div>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-purple-darker rounded-b">
                        <button class="text-white bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleGraphModal()">
                            Cancelar
                        </button>
                    </div>
                </div>
                <div class="w-1/5"></div>
            </div>
        </div>
        <div v-if="showGraphModal" class="opacity-25 fixed inset-0 z-40 bg-black full-screen"></div>


        <!--        MODAL DE CATEGORIAS-->
        <div v-if="showCategoriesModal" class="w-full grid justify-items-center text-white overflow-x-hidden overflow-y-auto over fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex-none full-screen">
            <div class="relative w-auto my-6 mx-auto max-w-6xl flex">
                <div class="w-1/5"></div>
                <!--content-->
                <div class="border-0 rounded-lg shadow-lg relative flex-none flex-col w-3/5 full-screen bg-purple outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-purple-darker rounded-t">
                        <h3 class="text-3xl font-semibold">
                            Categorias do Jogo
                        </h3>
                        <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" v-on:click="closeCategoriesModal()">
                          <span class="bg-transparent text-white opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                          </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="w-full relative p-6 flex-none">
                        <div class="flex-auto">
                            <div v-for="category in categories">
                                <input type="checkbox" v-model="category.bool">
                                <span>{{ category.name }}</span>
                            </div>
                        </div>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-purple-darker rounded-b">
                        <button class="text-white bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="closeCategoriesModal()">
                            Cancelar
                        </button>
                        <button class="text-white background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="editGameCategories()">
                            Aplicar
                        </button>
                    </div>
                </div>
                <div class="w-1/5"></div>
            </div>
        </div>
        <div v-if="showCategoriesModal" class="opacity-25 fixed inset-0 z-40 bg-black full-screen"></div>


        <!--        MODAL DE AVALIAÇÃO-->
        <div v-if="showEvaluationModal" class="w-full grid justify-items-center text-white overflow-x-hidden overflow-y-auto over fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex-none full-screen">
            <div class="relative w-auto my-6 mx-auto max-w-6xl flex">
                <div class="w-1/5"></div>
                <!--content-->
                <div class="border-0 rounded-lg shadow-lg relative flex-none flex-col w-3/5 full-screen bg-purple outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-purple-darker rounded-t">
                        <h3 class="text-3xl font-semibold">
                            Avaliar Jogo
                        </h3>
                        <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" v-on:click="toggleEvaluationModal()">
                          <span class="bg-transparent text-white opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                          </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="w-full relative p-6 flex-none">
                        <div class="width-high flex-auto">
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <input class="h-10" type="text" v-model="newEvaluationTitle" placeholder="Título da Avaliação">
                            </div>
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <textarea cols="30" rows="10" required autofocus placeholder="Descrição da Avaliação" v-model="newEvaluationDescription"></textarea>
                            </div>

                            <div class="w-full justify-center flex mt-10">
                                <h2>Notas Técnicas</h2>
                            </div>
                            <div class="w-full justify-center flex mb-6">
                                <div class="w-1/3">
                                    <div class="w-full justify-center flex mt-10">
                                        <label>Desafio</label>
                                    </div>
                                    <div class="w-full justify-center flex ">
                                        <p>0</p>
                                        <input type="range" v-model="newEvaluationGMChallenge">
                                        <p>100</p>
                                    </div>
                                    <div class="w-full justify-center flex mb-6">
                                        <label>{{ newEvaluationGMChallenge }}</label>
                                    </div>

                                    <div class="w-full justify-center flex mt-10">
                                        <label>Jogabilidade</label>
                                    </div>
                                    <div class="w-full justify-center flex ">
                                        <p>0</p>
                                        <input type="range" v-model="newEvaluationGMControl">
                                        <p>100</p>
                                    </div>
                                    <div class="w-full justify-center flex mb-6">
                                        <label>{{ newEvaluationGMControl }}</label>
                                    </div>

                                    <div class="w-full justify-center flex mt-10">
                                        <label>Objetivo</label>
                                    </div>
                                    <div class="w-full justify-center flex ">
                                        <p>0</p>
                                        <input type="range" v-model="newEvaluationGMObjective">
                                        <p>100</p>
                                    </div>
                                    <div class="w-full justify-center flex mb-6">
                                        <label>{{ newEvaluationGMObjective }}</label>
                                    </div>

                                    <div class="w-full justify-center flex mt-10">
                                        <label>Regras</label>
                                    </div>
                                    <div class="w-full justify-center flex ">
                                        <p>0</p>
                                        <input type="range" v-model="newEvaluationGMRule">
                                        <p>100</p>
                                    </div>
                                    <div class="w-full justify-center flex mb-6">
                                        <label>{{ newEvaluationGMRule }}</label>
                                    </div>
                                </div>

                                <div class="w-1/3">
                                    <div class="w-full justify-center flex mt-10">
                                        <label>Cenário</label>
                                    </div>
                                    <div class="w-full justify-center flex ">
                                        <p>0</p>
                                        <input type="range" v-model="newEvaluationSTScenario">
                                        <p>100</p>
                                    </div>
                                    <div class="w-full justify-center flex mb-6">
                                        <label>{{ newEvaluationSTScenario }}</label>
                                    </div>

                                    <div class="w-full justify-center flex mt-10">
                                        <label>Construção de Personagem</label>
                                    </div>
                                    <div class="w-full justify-center flex ">
                                        <p>0</p>
                                        <input type="range" v-model="newEvaluationSTCharacterBuilding">
                                        <p>100</p>
                                    </div>
                                    <div class="w-full justify-center flex mb-6">
                                        <label>{{ newEvaluationSTCharacterBuilding }}</label>
                                    </div>

                                    <div class="w-full justify-center flex mt-10">
                                        <label>Enredo</label>
                                    </div>
                                    <div class="w-full justify-center flex ">
                                        <p>0</p>
                                        <input type="range" v-model="newEvaluationSTPlot">
                                        <p>100</p>
                                    </div>
                                    <div class="w-full justify-center flex mb-6">
                                        <label>{{ newEvaluationSTPlot }}</label>
                                    </div>
                                </div>

                                <div class="w-1/3">
                                    <div class="w-full justify-center flex mt-10">
                                        <label>Gráfico</label>
                                    </div>
                                    <div class="w-full justify-center flex ">
                                        <p>0</p>
                                        <input type="range" v-model="newEvaluationAVGraphic">
                                        <p>100</p>
                                    </div>
                                    <div class="w-full justify-center flex mb-6">
                                        <label>{{ newEvaluationAVGraphic }}</label>
                                    </div>

                                    <div class="w-full justify-center flex mt-10">
                                        <label>Áudio</label>
                                    </div>
                                    <div class="w-full justify-center flex ">
                                        <p>0</p>
                                        <input type="range" v-model="newEvaluationAVAudio">
                                        <p>100</p>
                                    </div>
                                    <div class="w-full justify-center flex mb-6">
                                        <label>{{ newEvaluationAVAudio }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-purple-darker rounded-b">
                        <button class="text-white bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleEvaluationModal()">
                            Fechar
                        </button>
                        <button class="text-white background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="evaluateGame()">
                            Avaliar Jogo
                        </button>
                    </div>
                </div>
                <div class="w-1/5"></div>
            </div>
        </div>
        <div v-if="showEvaluationModal" class="opacity-25 fixed inset-0 z-40 bg-black full-screen"></div>




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
        <div v-if="showCreateModal" class="opacity-25 fixed inset-0 z-40 bg-black full-screen"></div>

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
        <div v-if="showEditModal" class="opacity-25 fixed inset-0 z-40 bg-black full-screen"></div>




        <div class="text-center">
            <h1>Jogos</h1>
        </div>

        <div v-if="isAdmin" class="w-full justify-center flex mt-10 mb-6">
            <button class="bg-green text-white active:bg-green-dark font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleCreateModal()">
                Cadastrar Jogo
            </button>
        </div>

        <div class="w-full justify-center flex mt-10 mb-6">
            <input class="h-10 w-2/5" type="text" v-model="searchingParameter" placeholder="Título, Nota, Classificação Indicativa, Categoria...">
            <button class="bg-green w-1/5 h-10 text-white font-bold" v-on:click="filter()">Filtrar</button>
        </div>

        <div class="flex bg-green m-1 p-1 rounded-lg" v-for="game in filteredGames">
            <div class="w-1/5">
                <img class="h-48 w-32 image rounded-sm" :src="'images/covers/' + game.cover">
            </div>
            <div class="w-2/5">
                <h2>{{game.title}}</h2>
                <p>Nota geral: {{game.grade}}</p>
                <p>Classificação indicativa: {{game.parentalRating}}</p>
                <p>Descrição: {{game.description}}</p>
                <p>Categorias: <span v-for="category in game.categories">{{ category.name }}, </span></p>
            </div>
            <div class="w-2/5 flex-none">
                <div class="w-full mb-6">
                    <button v-if="isAdmin" class="bg-purple w-1/4 text-white h-8 font-bold rounded-lg" v-on:click="prepareGameCategoriesEdit(game)">Categorias</button>
                    <button v-if="isAdmin" class="bg-purple w-1/4 text-white h-8 font-bold rounded-lg" v-on:click="prepareGameEdit(game)">Editar</button>
                    <button v-if="isAdmin" class="bg-purple w-1/4 text-white h-8 font-bold rounded-lg" v-on:click="prepareGameDelete(game)">Excluir</button>
                </div>
                <div class="w-full">
                    <button class="bg-purple w-2/5 text-white h-8 font-bold rounded-lg" v-on:click="prepareGraph(game)">Ver Detalhes</button>
                    <button v-if="isLogged" class="bg-purple w-2/5 text-white h-8 font-bold rounded-lg" v-on:click="prepareEvaluation(game)">Avaliar</button>
                    <button v-if="!isLogged" class="bg-grey w-2/5 text-white h-8 font-bold rounded-lg" v-on:click="">Avaliar</button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import axios from 'axios';
import { GChart } from 'vue-google-charts'

export default {
    data() {
        return {
            isLoading: false,
            fullPage: true,
            showCreateModal: false,
            showEditModal: false,
            showDeleteModal: false,
            showEvaluationModal: false,
            showCategoriesModal: false,
            showGraphModal: false,

            isAdmin: false,
            isLogged: false,
            isCategoryEdit: false,

            newGameTitle: '',
            newGameDescription: '',
            newGameCover: 'default_cover.png',
            newGameParentalRating: 0,

            editingGameId: 0,
            editingGameTitle: '',
            editingGameDescription: '',
            editingGameCover: 'default_cover.png',
            editingGameParentalRating: 0,

            deletingGameId: 0,
            evaluatingGameId: 0,


            newEvaluationTitle: '',
            newEvaluationDescription: '',

            newEvaluationGMObjective: 50,
            newEvaluationGMChallenge: 50,
            newEvaluationGMRule: 50,
            newEvaluationGMControl: 50,

            newEvaluationSTScenario: 50,
            newEvaluationSTCharacterBuilding: 50,
            newEvaluationSTPlot: 50,

            newEvaluationAVGraphic: 50,
            newEvaluationAVAudio: 50,


            searchingParameter: '',

            games: [],
            filteredGames: [],
            categories: [],

            graphGM: [],
            graphST: [],
            graphAU: [],

            chartOptions: {}
        }
    },
    components: {
        Loading,
        GChart
    },
    created: function () {
        this.isLoading = true;

        this.$https.post('/current-user')
            .then((response) => {
                if (response.data) {
                    this.isLogged = true;
                    if (response.data.is_admin) {
                        this.isAdmin = true;
                    } else {
                        this.isAdmin = false;
                    }
                }
            });

        axios.post('/all-games')
            .then((response) => {
                if (response.data) {
                    this.games = response.data;

                    this.filteredGames = this.games;

                    this.isLoading = false;
                } else {
                    this.$router.push('/notFound');
                    this.isLoading = false;
                }
            });

        axios.post('/all-categories')
            .then((response) => {
                if (response.data) {
                    let categories = response.data;

                    categories = categories.map((category, index) => {
                        return {
                            id: category.id,
                            name: category.name,
                            bool: false
                        };
                    });

                    this.categories = categories;
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
        toggleDeleteModal: function(){
            this.showDeleteModal = !this.showDeleteModal;
        },
        toggleEvaluationModal: function(){
            this.showEvaluationModal = !this.showEvaluationModal;
        },
        toggleCategoriesModal: function(){
            this.showCategoriesModal = !this.showCategoriesModal;
        },
        toggleGraphModal: function(){
            this.showGraphModal = !this.showGraphModal;
        },
        closeCategoriesModal: function(){
            this.toggleCategoriesModal();
            this.resetCategories();
        },
        prepareGraph: function(game){
            this.graphGM = game.graphGM;
            this.graphST = game.graphST;
            this.graphAU = game.graphAU;

            this.toggleGraphModal();
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
                    this.games.unshift(response.data);

                    this.filteredGames = this.games;

                    this.newGameTitle = '';
                    this.newGameParentalRating = '';
                    this.newGameCover = '';
                    this.newGameDescription = '';

                    this.toggleCreateModal();
                    this.isLoading = false;
                });
        },
        evaluateGame() {
            this.isLoading = true;

            let payload = {
                gameId: this.evaluatingGameId,
                title: this.newEvaluationTitle,
                description: this.newEvaluationDescription,
                objective: this.newEvaluationGMObjective,
                challenge: this.newEvaluationGMChallenge,
                rule: this.newEvaluationGMRule,
                control: this.newEvaluationGMControl,
                scenario: this.newEvaluationSTScenario,
                characterBuilding: this.newEvaluationSTCharacterBuilding,
                plot: this.newEvaluationSTPlot,
                graphic: this.newEvaluationAVGraphic,
                audio: this.newEvaluationAVAudio,
            };

            axios.post('/add-evaluation', payload)
                .then((response) => {
                    if (response.data === 'evaluated') {
                        this.$router.push('/evaluations');
                    }

                    this.toggleEvaluationModal();
                    this.isLoading = false;
                });
        },
        prepareGameEdit(game) {
            this.editingGameId = game.id;
            this.editingGameTitle = game.title;
            this.editingGameDescription = game.description;
            this.editingGameCover = game.cover;
            this.editingGameParentalRating = game.parentalRating;
            this.toggleEditModal();
        },
        prepareGameDelete(game) {
            this.deletingGameId = game.id;
            this.toggleDeleteModal();
        },
        prepareEvaluation(game) {
            this.evaluatingGameId = game.id;
            this.toggleEvaluationModal();
        },
        prepareGameCategoriesEdit(game) {
            this.editingGameId = game.id;

            this.categories = this.categories.map((currentCategory, index) => {
                game.categories.forEach(function (category, i) {
                    if (currentCategory.id === category.id) {
                        currentCategory.bool = true;
                    }
                });

                return currentCategory;
            });

            this.isCategoryEdit = true;

            this.toggleCategoriesModal();
        },
        editGameCategories() {
            this.isLoading = true;

            let selectedCategories = [];
            let formatedCategories = [];

            this.categories.forEach(function (category, index) {
                if (category.bool  === true) {
                    selectedCategories.push(category.id);
                    formatedCategories.push({
                        id: category.id,
                        name: category.name
                    });
                }
            });

            let payload = {
                gameId: this.editingGameId,
                selectedCategories: selectedCategories
            };

            axios.post('/edit-game-categories', payload)
            .then((response) => {
                if (response.data === 'edited') {
                    this.games.map((game, i) => {
                        if (game.id === payload.gameId) {
                            game.categories = formatedCategories;
                        }

                        return game;
                    });

                    this.filteredGames = this.games;

                    this.toggleCategoriesModal();
                    this.resetCategories();
                    this.isLoading = false;
                }
            });
        },
        resetCategories() {
            this.categories = this.categories.map((category, i) => {
                category.bool = false;
                return category;
            });
        },
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
                            games[index] = response.data;
                        }
                    });

                    this.filteredGames = this.games;

                    this.toggleEditModal();
                    this.cancelGameEdit();

                    this.isLoading = false;
                });
        },
        deleteGame(gameId) {
            this.isLoading = true;

            let payload = {
                game: gameId
            };

            this.$https.post('/delete-game', payload)
                .then((response) => {
                    if (response.data !== 'deleted') {
                        this.isLoading = false;
                        return
                    }

                    this.games.forEach(function (currentGame, index, games) {
                        if (currentGame.id === gameId) {
                            games.splice(index, 1);
                        }
                    });

                    this.filteredGames = this.games;

                    this.toggleDeleteModal();
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
        filter() {
            this.isLoading = true;

            let filter = this.searchingParameter;

            this.filteredGames = this.games.filter(function (item) {
                if (item.title.toLowerCase().includes(filter.toLowerCase()))
                    return true;
                if (item.grade.toString().toLowerCase().includes(filter.toLowerCase()))
                    return true;
                if (item.parentalRating.toString().toLowerCase().includes(filter.toLowerCase()))
                    return true;

                let hasCategory = false;

                item.categories.forEach((category) => {
                    if (category.name.toLowerCase().includes(filter.toLowerCase()))
                        hasCategory = true;
                });

                return hasCategory;
            });

            this.isLoading = false;
        }
    }
}
</script>
