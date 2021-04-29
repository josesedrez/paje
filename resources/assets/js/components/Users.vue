<template>
    <div class="float-left w-full">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 :is-full-page="fullPage">
        </loading>

        <div class="text-center">
            <h1>Usuários</h1>
        </div>
        <div class=" flex-none bg-green m-1 p-1 rounded-lg" v-for="user in users">
            <span>Nome: {{user.name}}</span><br>
            <span>E-mail: {{user.email}}</span><br>
            <span>Imagem: {{user.profile}}</span><br>
            <span>Qtd. Avalidações: {{user.evaluationsCount}}</span><br><br>
        </div>
    </div>
</template>

<script>
    import User from "../services/User";
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        data() {
            return {
                isLoading: false,
                fullPage: true,

                users:[]
                // users:[
                //     {
                //         name:'Xablau',
                //         email: "xablau@gmail.com",
                //         image:'C',
                //         evaluations_count:'54354353'
                //     }
                // ]
            }
        },
        components: {
            Loading
        },
        created: function () {
            this.isLoading = true;

            User.getAllUsers(response => {
                if (response.data) {
                    let preUsers = response.data;

                    preUsers.forEach(function (user, index, users) {
                        users[index].evaluationsCount = 0;
                    });

                    this.users = preUsers;

                    this.users.forEach(function (user, index, users) {
                        User.getUserEvaluationsCount({userId: user.id}, response => {
                            users[index].evaluationsCount = response.data;
                            console.log(users[index].id);
                            console.log(user['id']);
                        });
                    });

                    this.isLoading = false;
                } else {
                    this.$router.push('/notFound');
                    this.isLoading = false;
                }
            });
        }
    }
</script>
