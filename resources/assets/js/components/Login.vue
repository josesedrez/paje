<template>
    <div class="w-full h-full justify-center flex">
        <div class="w-3/4 h-full pt-20 justify-center flex-none">
            <div class="w-full justify-center flex">
                <input class="h-10 w-2/5" name="email" type="email" v-model="email" placeholder="E-mail">
            </div>
            <div class="w-full h-2 justify-center flex">
                <span class="text-red text-sm font-bold">{{ emailError }}</span>
            </div>
            <div class="w-full justify-center flex mt-10">
                <input class="h-10 w-2/5" name="password" type="password" v-model="password" placeholder="Senha">
            </div>
            <div class="w-full h-2 justify-center flex">
                <span class="text-red text-sm font-bold">{{ passwordError }}</span>
            </div>
            <div class="w-full justify-center flex mt-10">
                <button class="bg-green w-2/5 h-10 text-white font-bold" @click="login()">Entrar</button>
            </div>
        </div>
    </div>
</template>

<script>
import User from "../services/User";

export default {
    data() {
        return {
            form:{
                type: '',
                asasa: ''
            },

            email: '',
            password: '',

            emailError: '',
            passwordError: '',
        }
    },
    methods: {
        login () {
            this.resetErrors();

            if (!this.isValidInputs()) {
                return;
            }

            var payload = {
                email: this.email,
                password: this.password,
            };

            User.login(payload, response => {
                switch (response.data) {
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
        },
        resetErrors() {
            this.emailError = '';
            this.passwordError = '';
        },
        isValidInputs() {
            let errors = 0;

            if (!this.isValidEmail(this.email)) {
                this.emailError = 'O e-mail inserido é inválido';
                errors += 1;
            }

            if (this.email === '') {
                this.emailError = 'Este campo deve ser preenchido';
                errors += 1;
            }

            if (this.password === '') {
                this.passwordError = 'Este campo deve ser preenchido';
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
