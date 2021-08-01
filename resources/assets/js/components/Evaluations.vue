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
                            Excluir Categoria
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
                            <p>Tem certeza que deseja exluir esta categoria?</p>
                        </div>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-purple-darker rounded-b">
                        <button class="text-white bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleDeleteModal()">
                            Cancelar
                        </button>
                        <button class="text-white background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="deleteEvaluation(deletingEvaluationId)">
                            Excluir
                        </button>
                    </div>
                </div>
                <div class="w-1/5"></div>
            </div>
        </div>
        <div v-if="showDeleteModal" class="opacity-25 fixed inset-0 z-40 bg-black full-screen"></div>


        <!--        MODAL DE Edição-->
        <div v-if="showEditModal" class="w-full grid justify-items-center text-white overflow-x-hidden overflow-y-auto over fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex-none full-screen">
            <div class="relative w-auto my-6 mx-auto max-w-6xl flex">
                <div class="w-1/5"></div>
                <!--content-->
                <div class="border-0 rounded-lg shadow-lg relative flex-none flex-col w-3/5 full-screen bg-purple outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-purple-darker rounded-t">
                        <h3 class="text-3xl font-semibold">
                            Editar Avaliação
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
                                <input class="h-10" type="text" v-model="newEvaluationTitle" placeholder="Título do Jogo">
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
                        <button class="text-white bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleEditModal()">
                            Fechar
                        </button>
                        <button class="text-white background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="editEvaluation()">
                            Editar Avaliação
                        </button>
                    </div>
                </div>
                <div class="w-1/5"></div>
            </div>
        </div>
        <div v-if="showEditModal" class="opacity-25 fixed inset-0 z-40 bg-black full-screen"></div>

        <!--        MODAL DE VISUALIZAÇÃO-->
        <div v-if="showViewModal" class="w-full grid justify-items-center text-white overflow-x-hidden overflow-y-auto over fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex-none full-screen">
            <div class="relative w-auto my-6 mx-auto max-w-6xl flex">
                <div class="w-1/5"></div>
                <!--content-->
                <div class="border-0 rounded-lg shadow-lg relative flex-none flex-col w-3/5 full-screen bg-purple outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-purple-darker rounded-t">
                        <h3 class="text-3xl font-semibold">
                            {{ newEvaluationTitle }}
                        </h3>
                        <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" v-on:click="toggleViewModal()">
                          <span class="bg-transparent text-white opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                          </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="w-full relative p-6 flex-none">
                        <div class="width-high flex-auto">
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <p>Jogo: {{ newEvaluationGameTitle }}</p>
                            </div>
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <p>Nota Geral: {{ newEvaluationGrade }}</p>
                            </div>
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <p>Curtidas: {{ newEvaluationLikes }}</p>
                            </div>

                            <div class="w-full justify-center flex mt-10">
                                <h2>Descrição</h2>
                            </div>
                            <div class="w-full justify-center flex mt-10 mb-6">
                                <p>{{ newEvaluationDescription }}</p>
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
                                        <input type="range" v-model="newEvaluationGMChallenge" disabled>
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
                                        <input type="range" v-model="newEvaluationGMControl" disabled>
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
                                        <input type="range" v-model="newEvaluationGMObjective" disabled>
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
                                        <input type="range" v-model="newEvaluationGMRule" disabled>
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
                                        <input type="range" v-model="newEvaluationSTScenario" disabled>
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
                                        <input type="range" v-model="newEvaluationSTCharacterBuilding" disabled>
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
                                        <input type="range" v-model="newEvaluationSTPlot" disabled>
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
                                        <input type="range" v-model="newEvaluationAVGraphic" disabled>
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
                                        <input type="range" v-model="newEvaluationAVAudio" disabled>
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
                        <button class="text-white bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleViewModal()">
                            Fechar
                        </button>
                        <button class="text-white background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="">

                        </button>
                    </div>
                </div>
                <div class="w-1/5"></div>
            </div>
        </div>
        <div v-if="showViewModal" class="opacity-25 fixed inset-0 z-40 bg-black full-screen"></div>





        <div class="text-center">
            <h1>Avaliações</h1>
        </div>

        <div class="w-full justify-center flex mt-10 mb-6">
            <input class="h-10 w-2/5" type="text" v-model="searchingParameter" placeholder="Título, Autor, Jogo...">
            <button class="bg-green w-1/5 h-10 text-white font-bold" v-on:click="filter()">Filtrar</button>
        </div>

        <div class="flex bg-green m-1 p-1 rounded-lg" v-for="evaluation in filteredEvaluations">
            <div class="w-3/5">
                <h2>{{evaluation.title}}</h2>
                <p>Jogo: {{evaluation.gameTitle}}</p>
                <p>Autor: {{evaluation.userName}}</p>
                <p>Nota geral: {{evaluation.grade}}</p>
                <p>Curtidas: 0</p>
            </div>
            <div class="w-2/5 flex-none">
                <div class="w-full mb-6">
                    <button v-if="isAdmin || userId === evaluation.userId" class="bg-purple w-2/5 text-white h-8 font-bold rounded-lg" v-on:click="prepareEvaluationEdit(evaluation)">Editar</button>
                    <button v-if="isAdmin || userId === evaluation.userId" class="bg-purple w-2/5 text-white h-8 font-bold rounded-lg" v-on:click="prepareEvaluationDelete(evaluation)">Excluir</button>
                </div>
                <div class="w-full">
                    <button class="bg-purple w-2/5 text-white h-8 font-bold rounded-lg" v-on:click="prepareEvaluationView(evaluation)">Ver Detalhes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import axios from 'axios';

export default {
    data() {
        return {
            isLoading: false,
            fullPage: true,
            isAdmin: false,
            isLogged: false,
            userId: 0,

            showDeleteModal: false,
            showEditModal: false,
            showViewModal: false,

            deletingEvaluationId: 0,


            editingEvaluationId: 0,

            newEvaluationTitle: '',
            newEvaluationDescription: '',
            newEvaluationGameTitle: '',
            newEvaluationGrade: 0,
            newEvaluationLikes: 0,

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

            evaluations: [],
            filteredEvaluations:[]

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
                    this.isLogged = true;
                    this.userId = response.data.id;
                    if (response.data.is_admin) {
                        this.isAdmin = true;
                    } else {
                        this.isAdmin = false;
                    }
                }
            });

        axios.post('/all-evaluations')
            .then((response) => {
                if (response.data) {
                    this.evaluations = response.data;
                    this.filteredEvaluations = this.evaluations;

                    if (typeof this.$root.evaluationSearch !== 'undefined') {
                        this.searchingParameter = this.$root.evaluationSearch;
                        this.filter();
                        this.$root.evaluationSearch = '';
                    }

                    this.isLoading = false;
                } else {
                    this.isLoading = false;
                }
            });
    },
    methods: {
        toggleDeleteModal: function(){
            this.showDeleteModal = !this.showDeleteModal;
        },
        toggleEditModal: function(){
            this.showEditModal = !this.showEditModal;
        },
        toggleViewModal: function(){
            this.showViewModal = !this.showViewModal;
        },
        prepareEvaluationEdit(evaluation) {
            this.editingEvaluationId = evaluation.id;
            this.newEvaluationTitle = evaluation.title;
            this.newEvaluationDescription = evaluation.description;
            this.newEvaluationGMObjective = evaluation.objective;
            this.newEvaluationGMChallenge = evaluation.challenge;
            this.newEvaluationGMRule = evaluation.rule;
            this.newEvaluationGMControl = evaluation.control;
            this.newEvaluationSTScenario = evaluation.scenario;
            this.newEvaluationSTCharacterBuilding = evaluation.characterBuilding;
            this.newEvaluationSTPlot = evaluation.plot;
            this.newEvaluationAVGraphic = evaluation.graphic;
            this.newEvaluationAVAudio = evaluation.audio;
            this.newEvaluationGameTitle = evaluation.gameTitle;

            this.toggleEditModal();
        },
        prepareEvaluationView(evaluation) {
            this.newEvaluationTitle = evaluation.title;
            this.newEvaluationDescription = evaluation.description;
            this.newEvaluationGMObjective = evaluation.objective;
            this.newEvaluationGMChallenge = evaluation.challenge;
            this.newEvaluationGMRule = evaluation.rule;
            this.newEvaluationGMControl = evaluation.control;
            this.newEvaluationSTScenario = evaluation.scenario;
            this.newEvaluationSTCharacterBuilding = evaluation.characterBuilding;
            this.newEvaluationSTPlot = evaluation.plot;
            this.newEvaluationAVGraphic = evaluation.graphic;
            this.newEvaluationAVAudio = evaluation.audio;
            this.newEvaluationGameTitle = evaluation.gameTitle;
            this.newEvaluationGrade = evaluation.grade;

            this.toggleViewModal();
        },
        prepareEvaluationDelete(evaluation) {
            this.deletingEvaluationId = evaluation.id;
            this.toggleDeleteModal();
        },
        cancelEvaluationEdit() {
            this.editingEvaluationId = 0;
            this.newEvaluationTitle = '';
            this.newEvaluationDescription = '';
            this.newEvaluationGMObjective = 0;
            this.newEvaluationGMChallenge = 0;
            this.newEvaluationGMRule = 0;
            this.newEvaluationGMControl = 0;
            this.newEvaluationSTScenario = 0;
            this.newEvaluationSTCharacterBuilding = 0;
            this.newEvaluationSTPlot = 0;
            this.newEvaluationAVGraphic = 0;
            this.newEvaluationAVAudio = 0;
            this.newEvaluationGameTitle = '';
        },
        editEvaluation() {
            this.isLoading = true;

            let payload = {
                evaluationId: this.editingEvaluationId,
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

            axios.post('/edit-evaluation', payload)
                .then((response) => {
                    if (response.data === 'failed') {
                        this.isLoading = false;
                        return
                    }

                    const evaluationId = this.editingEvaluationId;

                    this.evaluations.forEach(function (currentEvaluation, index, evaluations) {
                        if (currentEvaluation.id === evaluationId) {
                            evaluations[index] = response.data;
                        }
                    });

                    this.filteredEvaluations = this.evaluations

                    this.toggleEditModal();
                    this.cancelEvaluationEdit();

                    this.isLoading = false;
                });
        },
        deleteEvaluation(evaluationId) {
            this.isLoading = true;

            let payload = {
                evaluation: evaluationId
            };

            axios.post('/delete-evaluation', payload)
                .then((response) => {
                    if (response.data !== 'deleted') {
                        this.isLoading = false;
                        return
                    }

                    this.evaluations.forEach(function (currentEvaluation, index, evaluations) {
                        if (currentEvaluation.id === evaluationId) {
                            evaluations.splice(index, 1);
                        }
                    });

                    this.filteredEvaluations = this.evaluations

                    this.toggleDeleteModal();
                    this.isLoading = false;
                });
        },
        filter() {
            this.isLoading = true;

            const filter = this.searchingParameter;

            this.filteredEvaluations = this.evaluations.filter(function (item) {
                return item.title.toLowerCase().includes(filter.toLowerCase()) || item.userName.toLowerCase().includes(filter.toLowerCase()) || item.gameTitle.toLowerCase().includes(filter.toLowerCase());
            });

            this.isLoading = false;
        }
    }
}
</script>
