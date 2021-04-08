<template>
    <div class="w-full h-full justify-center flex">
        <div class="w-3/4 h-full pt-10 justify-center flex-none">
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
                <button class="bg-green w-2/5 h-10 text-white font-bold" @click="register()">Cadastrar-se</button>
            </div>
        </div>
    </div>
</template>

<script>
    import User from '../services/User'

    export default {
        data() {
            return {
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
        methods: {
            register () {
                this.emailError = '';
                this.nameError = '';
                this.passwordError = '';
                this.confirmPasswordError = '';

                if (!this.validatePassword()) {
                    this.confirmPasswordError = "As senhas precisam ser iguais";

                    return;
                }

                var payload = {
                    email: this.email,
                    name: this.name,
                    password: this.password,
                };

                User.register(payload, response => {
                    console.log(response);

                    switch (response.data) {
                        case 'registered':
                            User.login(payload, response2 => {
                                switch (response2.data) {
                                    case 'logged':
                                        this.$router.push('/');
                                        window.location.reload();
                                        break;
                                    case 'emailDontExist':
                                        this.emailError = "E-mail não cadastrado";
                                        break;
                                    case 'passwordInvalid':
                                        this.passwordError = "Senha incorreta";
                                        break;
                                }
                            });
                            break;
                        case 'emailAlreadyExist':
                            this.emailError = "E-mail já cadastrado";
                            break;
                        case 'registerError':
                            this.emailError = "Houve algum problema durante o cadastro";
                            break;
                    }

                });
            },
            validatePassword () {
                return this.password === this.confirmPassword;
            }
        }
    }
</script>
