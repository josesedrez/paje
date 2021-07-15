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
                        <button class="text-white background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="deleteCategory(deletingCategoryId)">
                            Excluir
                        </button>
                    </div>
                </div>
                <div class="w-1/5"></div>
            </div>
        </div>
        <div v-if="showDeleteModal" class="opacity-25 fixed inset-0 z-40 bg-black full-screen"></div>





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
                <button v-if="editingCategoryId != category.id" class="bg-purple w-1/3 text-white h-8 font-bold rounded-lg" v-on:click="prepareCategoryDelete(category)">Excluir</button>
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

                showDeleteModal: false,

                newCategoryName: '',
                editingCategory: '',
                editingCategoryId: 0,

                deletingCategoryId: 0,

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
            toggleDeleteModal: function(){
                this.showDeleteModal = !this.showDeleteModal;
            },
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
            prepareCategoryDelete(category) {
                this.deletingCategoryId = category.id;
                this.toggleDeleteModal();
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
            deleteCategory(categoryId) {
                this.isLoading = true;

                let payload = {
                    category: categoryId
                };

                this.$https.post('/delete-category', payload)
                    .then((response) => {
                        if (response.data !== 'deleted') {
                            this.isLoading = false;
                            return
                        }

                        this.categories.forEach(function (currentCategory, index, categories) {
                           if (currentCategory.id === categoryId) {
                               categories.splice(index, 1);
                           }
                        });

                        this.toggleDeleteModal();
                        this.isLoading = false;
                    });
            }
        }
    }
</script>
