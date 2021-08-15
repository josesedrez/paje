<template>
    <div class="w-full h-full justify-center flex">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 :is-full-page="fullPage">
        </loading>

        <div class="w-3/4 h-full flex-none">
            <div class="w-full h-48 flex">
                <div class="w-1/3 h-48 justify-center flex">
                    <input type="file"  accept="image/*" name="image" id="file"  @change="loadFile" style="display: none;">
                    <div class="image-container flex-none">
                        <p><label for="file" style="cursor: pointer;">
                            <img class="h-48 w-48 rounded-full image" :src="'images/profiles/' + profile">
                        </label></p>
                    </div>
                </div>
                <div class="w-2/3 h-48 flex-none">
                    <div class="w-full h-24 pt-10 justify-center flex">
                        <a v-on:click="prepareNameEdit()" style="cursor: pointer;">
                            <span v-if="!editingName" class="text-4xl font-bold text-button">{{ name }}</span>
                        </a>
                        <input v-if="editingName" class="h-8 w-2/5" type="text" v-model="name" placeholder="Novo Nome">
                        <button v-if="editingName" class="bg-green w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="editName()">Confirmar</button>
                        <button v-if="editingName" class="bg-green w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="cancelNameEdit()">Cancelar</button>
                    </div>
                    <div class="w-full h-24 pt-5 justify-center flex">
                        <a v-on:click="prepareEmailEdit()" style="cursor: pointer;">
                            <span v-if="!editingEmail" class="text-2xl font-bold text-button">({{ email }})</span>
                        </a>
                        <input v-if="editingEmail" class="h-8 w-2/5" type="text" v-model="email" placeholder="Novo E-mail">
                        <button v-if="editingEmail" class="bg-green w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="editEmail()">Confirmar</button>
                        <button v-if="editingEmail" class="bg-green w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="cancelEmailEdit()">Cancelar</button>
                    </div>
                </div>
            </div>
            <div class="w-full justify-center h-48 flex mt-3">
                <button v-if="!editingPassword" class="bg-green w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="preparePasswordEdit()">Mudar Senha</button>
                <input v-if="editingPassword" class="h-8 w-2/5" type="password" v-model="newPassword" placeholder="Nova Senha">
                <button v-if="editingPassword" class="bg-green w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="editPassword()">Confirmar</button>
                <button v-if="editingPassword" class="bg-green w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="cancelPasswordEdit()">Cancelar</button>
            </div>

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

                editingName: false,
                editingEmail: false,
                editingPassword: false,

                newPassword: '',
                email: '',
                name: '',
                profile: '',
                image: '',
            }
        },
        components: {
            Loading
        },
        created: function () {
            this.isLoading = true;

            User.getCurrentUser(response => {
                if (response.data) {
                    this.email= response.data.email;
                    this.name= response.data.name;
                    this.profile= response.data.profile;
                    this.profileBackup= response.data.profile;
                    this.isLoading = false;
                } else {
                    this.$router.push('/notFound');
                    this.isLoading = false;
                }
            });
        },
        methods: {
            prepareNameEdit() {
                this.editingName = true;
            },
            prepareEmailEdit() {
                this.editingEmail = true;
            },
            preparePasswordEdit() {
                this.editingPassword = true;
            },
            cancelNameEdit() {
                this.editingName = false;
            },
            cancelEmailEdit() {
                this.editingEmail = false;
            },
            cancelPasswordEdit() {
                this.editingPassword = false;
            },
            editName() {
                this.isLoading = true;

                let payload = {
                    newName: this.name
                };

                this.$https.post('/edit-user-name', payload)
                    .then((response) => {
                        if (response.data === 'failed') {
                            this.isLoading = false;
                            return
                        }

                        this.name= response.data.name;
                        this.editingName = false;

                        this.isLoading = false;
                    });
            },
            editEmail() {
                this.isLoading = true;

                let payload = {
                    newEmail: this.email
                };

                this.$https.post('/edit-user-email', payload)
                    .then((response) => {
                        if (response.data === 'failed') {
                            this.isLoading = false;
                            return
                        }

                        this.email= response.data.email;
                        this.editingEmail = false;

                        this.isLoading = false;
                    });
            },
            editPassword() {
                this.isLoading = true;

                let payload = {
                    newPassword: this.newPassword
                };

                this.$https.post('/edit-user-password', payload)
                    .then((response) => {
                        if (response.data === 'failed') {
                            this.isLoading = false;
                            return
                        }

                        this.editingPassword = false;
                        this.isLoading = false;
                        window.location.reload();
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

                    User.changeProfile(payload, response => {
                        console.log('response: ' + response.data);
                        switch (response.data) {
                            case 'invalidExtension':
                                const options = {title: 'Extensão inválida', size: 'sm'}
                                this.$dialogs.alert('Tente utilizar uma imagem com extensão .png ou .jpg', options)
                                break;
                            default:
                                User.getCurrentUser(response => {
                                    if (response.data) {
                                        this.profile = response.data.profile;

                                        this.isLoading = false;
                                    } else {
                                        window.location.reload();
                                    }
                                });
                        }
                    });
                };

                reader.readAsDataURL(file);
            }
        }
    }
</script>
