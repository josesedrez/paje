<template>
    <div class="float-left w-full">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 :is-full-page="fullPage">
        </loading>

        <div class="text-center">
            <h1>Categorias</h1>
        </div>

        <div class="w-full justify-center flex mt-10 mb-6">
            <input class="h-10 w-2/5" type="text" v-model="newCategoryName" placeholder="Nova Categoria">
            <button class="bg-green w-1/5 h-10 text-white font-bold" v-on:click="addNewCategory()">Adicionar</button>
        </div>

        <div class="h-10 flex bg-green m-1 p-1 rounded-lg" v-for="category in categories">
            <div class="w-3/5">
                <span v-if="editingCategoryId != category.id">{{category.name}}</span>
                <input v-if="editingCategoryId === category.id" class="h-8 w-2/5" type="text" v-model="editingCategory" placeholder="Novo Nome">
            </div>
            <div class="w-2/5">
                <button v-if="editingCategoryId != category.id" class="bg-purple w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="prepareCategoryEdit(category)">Editar</button>
                <button v-if="editingCategoryId === category.id" class="bg-purple w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="editCategory(category)">Confirmar</button>
                <button v-if="editingCategoryId === category.id" class="bg-purple w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="cancelCategoryEdit()">Cancelar</button>
                <button v-if="editingCategoryId != category.id" class="bg-purple w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="deleteCategory(category)">Excluir</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        data() {
            return {
                isLoading: false,
                fullPage: true,

                newCategoryName: '',
                editingCategory: '',
                editingCategoryId: 0,
                categories:[]
            }
        },
        components: {
            Loading
        },
        created: function () {
            this.isLoading = true;

            this.$https.post('/current-user')
                .then((response) => {
                    console.log(response.data);
                    if (response.data) {
                        if (!response.data.is_admin) {
                            this.$router.push('/notFound');
                            this.isLoading = false;
                        }
                    } else {
                        this.$router.push('/notFound');
                        this.isLoading = false;
                    }
            });

            this.$https.post('/all-categories')
                .then((response) => {
                console.log(response.data);
                    if (response.data) {
                        let categories = response.data;

                        categories.forEach(function (category, index, categories) {
                            categories[index] = {
                                id: category.id,
                                name: category.name
                            };
                        });

                        this.categories = categories;

                        this.isLoading = false;
                    } else {
                        this.$router.push('/notFound');
                        this.isLoading = false;
                    }
            });
        },
        methods: {
            addNewCategory() {
                this.isLoading = true;

                let payload = {
                    category: this.newCategoryName
                };

                this.$https.post('/add-category', payload)
                    .then((response) => {
                        this.categories.unshift({
                            'id': response.data.id,
                            'name': response.data.name
                        });

                        this.newCategoryName = '';
                        this.isLoading = false;
                    });
            },
            prepareCategoryEdit(category) {
                console.log('FOI?');
                this.editingCategory = category.name;
                this.editingCategoryId = category.id;
            },
            cancelCategoryEdit() {
                this.editingCategory = '';
                this.editingCategoryId = 0;
            },
            editCategory(category) {
                this.isLoading = true;

                let payload = {
                    category: category.id,
                    newName: this.editingCategory
                };

                this.$https.post('/edit-category', payload)
                    .then((response) => {
                        if (response.data === 'failed') {
                            this.isLoading = false;
                            return
                        }

                        this.categories.forEach(function (currentCategory, index, categories) {
                            if (currentCategory.id === category.id) {
                                categories[index].name = response.data.name;
                            }
                        });

                        this.cancelCategoryEdit();

                        this.isLoading = false;
                    });
            },
            deleteCategory(category) {
                this.isLoading = true;

                let payload = {
                    category: category.id
                };

                this.$https.post('/delete-category', payload)
                    .then((response) => {
                        if (response.data !== 'deleted') {
                            this.isLoading = false;
                            return
                        }

                        this.categories.forEach(function (currentCategory, index, categories) {
                           if (currentCategory.id === category.id) {
                               categories.splice(index, 1);
                           }
                        });

                        this.isLoading = false;
                    });
            }
        }
    }
</script>
