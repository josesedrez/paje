<template>
    <div class="float-left w-full">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 :is-full-page="fullPage">
        </loading>

        <div class="text-center">
            <h1>Usuários</h1>
        </div>

        <div class="w-full justify-center flex mt-10 mb-6">
            <input class="h-10 w-2/5" type="text" v-model="searchingParameter" placeholder="Nome, E-mail, Qtd. Avaliações...">
            <button class="bg-green w-1/5 h-10 text-white font-bold" v-on:click="filter()">Filtrar</button>
        </div>

        <div class="flex bg-green m-1 p-1 rounded-lg" v-for="user in filteredUsers">
            <div class="w-1/6 justify-center">
                <img class="h-24 w-25 rounded-full" :src="'images/profiles/' + user.profile">
            </div>
            <div class="w-2/5">
                <h2>{{user.name}}</h2><br>
                <span>E-mail: {{user.email}}</span><br>
                <span>Qtd. Avalidações: {{user.evaluationsCount}}</span><br><br>
            </div>
            <div class="w-2/5">
                <button class="bg-purple w-2/5 text-white h-8 font-bold rounded-lg" v-on:click="goToEvaluations(user.name)">Ver Avaliações</button>
            </div>
        </div>
    </div>
</template>

<script>
    import User from "../services/User";
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    import axios from 'axios';

    export default {
        data() {
            return {
                isLoading: false,
                fullPage: true,

                searchingParameter: '',

                users: [],
                filteredUsers: []
            }
        },
        components: {
            Loading
        },
        created: function () {
            this.isLoading = true;

            axios.post('/all-users')
                .then((response) => {
                if (response.data) {
                    this.users = response.data;
                    this.filteredUsers = this.users;

                    this.isLoading = false;
                } else {
                    this.$router.push('/notFound');
                    this.isLoading = false;
                }
            });
        },
        methods: {
            filter() {
                this.isLoading = true;

                let filter = this.searchingParameter;

                this.filteredUsers = this.users.filter(function (item) {
                    return item.name.toLowerCase().includes(filter.toLowerCase()) || item.email.toLowerCase().includes(filter.toLowerCase()) || item.evaluationsCount.toString().toLowerCase().includes(filter.toLowerCase());
                });

                this.isLoading = false;
            },
            goToEvaluations(name) {
                this.$parent.evaluationSearch = name;
                this.$router.push('/evaluations');
            }
        }
    }
</script>
