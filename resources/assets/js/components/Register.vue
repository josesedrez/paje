<template>
    <div class="w-full h-full justify-center flex">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 :is-full-page="fullPage">
        </loading>

        <div class="w-3/4 h-full pt-10 justify-center flex-none">
            <form @submit="verify" method="POST" action="/register">
                <input type="hidden" name="_token" v-bind:value="csrf">

                <div class="w-full justify-center flex">
                    <input class="h-10 w-2/5" name="email" type="email" v-model="email" placeholder="E-mail">
                </div>
                <div class="w-full h-2 justify-center flex">
                    <span class="text-red text-sm font-bold">{{ emailError }}</span>
                </div>
                <div class="w-full justify-center flex mt-8">
                    <input class="h-10 w-2/5" name="name" type="text" v-model="name" placeholder="Nome">
                </div>
                <div class="w-full h-2 justify-center flex">
                    <span class="text-red text-sm font-bold">{{ nameError }}</span>
                </div>
                <div class="w-full justify-center flex mt-8">
                    <input class="h-10 w-2/5" name="password" type="password" v-model="password" placeholder="Senha">
                </div>
                <div class="w-full h-2 justify-center flex">
                    <span class="text-red text-sm font-bold">{{ passwordError }}</span>
                </div>
                <div class="w-full justify-center flex mt-8">
                    <input class="h-10 w-2/5" name="confirmPassword" type="password" v-model="confirmPassword" placeholder="Confirme a senha">
                </div>
                <div class="w-full h-2 justify-center flex">
                    <span class="text-red text-sm font-bold">{{ confirmPasswordError }}</span>
                </div>
                <div class="w-full justify-center flex mt-8">
                    <button class="bg-green w-2/5 h-10 text-white font-bold" type="submit">Cadastrar-se</button>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
    import User from '../services/User'
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        data() {
            return {
                isLoading: false,
                fullPage: true,

                //csrf token
                csrf: '',

                email: '',
                name: '',
                password: '',
                confirmPassword: '',

                emailError: '',
                nameError: '',
                passwordError: '',
                confirmPasswordError: '',
            }
        },
        components: {
            Loading
        },
        created() {
            this.$https.post('/get-csrf')
                .then((response) => {
                    this.csrf = response.data;
                });
        },
        methods: {
            verify (e) {
                this.resetErrors();

                if (!this.isValidInputs()) {
                    e.preventDefault();
                }

                return true;
                // var payload = {
                //     email: this.email,
                //     name: this.name,
                //     teste: this.password,
                // };
                //
                // this.isLoading = true;
                // this.$https.post('/register', payload)
                //     .then((response) => {
                //     console.log(response.data);
                //         switch (response.data.status) {
                //             case 'registered':
                //                 // this.$https.post('/login', payload)
                //                 //     .then((response) => {
                //                 //
                //                 //     });
                //                 // const options = {title: 'Usuário Cadastrado!', size: 'sm'}
                //                 // this.$dialogs.alert('Sua conta foi registrada com sucesso. Agora tente realizar o login.', options)
                //                 //     .then(function () {
                //                 //         window.location.reload();
                //                 //     });
                //                 // this.email = '';
                //                 // this.name = '';
                //                 // this.password = '';
                //                 // this.confirmPassword = '';
                //                 // this.$router.push('/login');
                //                 break;
                //             case 'emailAlreadyExist':
                //                 this.emailError = "E-mail já cadastrado";
                //                 break;
                //             case 'registerError':
                //                 this.emailError = "Houve algum problema durante o cadastro";
                //                 break;
                //         }
                //
                //         this.isLoading = false;
                // });
                // User.register(payload, response => {
                //     console.log(response);
                //
                //     switch (response.data) {
                //         case 'registered':
                //             const options = {title: 'Usuário Cadastrado!', size: 'sm'}
                //             this.$dialogs.alert('Sua conta foi registrada com sucesso. Agora tente realizar o login.', options);
                //             this.email = '';
                //             this.name = '';
                //             this.password = '';
                //             this.confirmPassword = '';
                //             break;
                //         case 'emailAlreadyExist':
                //             this.emailError = "E-mail já cadastrado";
                //             break;
                //         case 'registerError':
                //             this.emailError = "Houve algum problema durante o cadastro";
                //             break;
                //     }
                //
                //     this.isLoading = false;
                // });
            },
            resetErrors() {
                this.emailError = '';
                this.nameError = '';
                this.passwordError = '';
                this.confirmPasswordError = '';
            },
            isValidInputs() {
                let errors = 0;

                if (!this.isValidEmail(this.email)) {
                    this.emailError = 'O e-mail inserido é inválido';
                    errors += 1;
                }

                if (this.password !== this.confirmPassword) {
                    this.confirmPasswordError = 'Este campo e o da senha devem ser iguais';
                    errors += 1;
                }

                if (this.email === '') {
                    this.emailError = 'Este campo deve ser preenchido';
                    errors += 1;
                }

                if (this.name === '') {
                    this.nameError = 'Este campo deve ser preenchido';
                    errors += 1;
                }

                if (this.password === '') {
                    this.passwordError = 'Este campo deve ser preenchido';
                    errors += 1;
                }

                if (this.confirmPassword === '') {
                    this.confirmPasswordError = 'Este campo deve ser preenchido';
                    errors += 1;
                }

                return errors === 0;
            },
            isValidEmail(email) {
                const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        }
    }
</script>
