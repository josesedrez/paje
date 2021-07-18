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
                        <span class="text-4xl font-bold">{{ name }}</span>
                    </div>
                    <div class="w-full h-24 pt-5 justify-center flex">
                        <span class="text-2xl font-bold">({{ email }})</span>
                    </div>
                </div>
            </div>
            <div class="w-full justify-center h-48 flex">

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
