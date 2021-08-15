<template>
    <div class="w-full h-full justify-center flex">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 :is-full-page="fullPage">
        </loading>

        <div class="w-3/4 h-full pt-20 justify-center flex-none">
            <div class="w-full h-2 justify-center flex">
                <h3 class="text-white font-bold">Digite o e-mail da sua conta para a recuperação de senha</h3>
            </div>
            <div class="w-full h-2 justify-center flex mt-10 ">
                <h3 class="text-white font-bold">{{ successMessage }}</h3>
            </div>
            <div class="w-full justify-center flex mt-10">
                <input class="h-10 w-2/5" name="email" type="email" v-model="email" placeholder="E-mail">
            </div>
            <div class="w-full h-2 justify-center flex">
                <span class="text-red text-sm font-bold">{{ emailError }}</span>
            </div>
            <div class="w-full justify-center flex mt-5">
                <button class="bg-green w-2/5 h-10 text-white font-bold" @click="send()">Enviar</button>
            </div>
        </div>
    </div>
</template>

<script>
import User from "../services/User";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import axios from "axios";

export default {
    data() {
        return {
            isLoading: false,
            fullPage: true,

            email: '',
            emailError: '',
            successMessage: '',
        }
    },
    components: {
        Loading
    },
    created: function () {
        this.isLoading = true;

        User.getCurrentUser(response => {
            if (response.data) {
                this.$router.push('/');
            }
                this.isLoading = false;
        });
    },
    methods: {
        send () {
            this.resetErrors();

            if (!this.isValidInputs()) {
                return;
            }

            var payload = {
                email: this.email
            };

            this.isLoading = true;

            axios.post("forgot-password-send-email", payload)
                .then(response => {
                switch (response.data) {
                    case 'success':
                        this.successMessage = "E-mail enviado!"
                        break;
                    case 'noUser':
                        this.emailError = "E-mail não cadastrado";
                        break;
                }
                this.isLoading = false;
            });
        },
        resetErrors() {
            this.emailError = '';
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

            return errors === 0;
        },
        isValidEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    }
}
</script>
