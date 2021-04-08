<template>
    <div class="float-left w-full">
        <div class="text-center">
            <h1>Usuários</h1>
        </div>


        <div class=" flex-none bg-green m-1 p-1 rounded-lg" v-for="user in users">
            <span>Nome: {{user.name}}</span><br>
            <span>E-mail: {{user.email}}</span><br>
            <span>Imagem: {{user.image}}</span><br>
            <span>Qtd. Avalidações: {{user.evaluations_count}}</span><br><br>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form:{
                    type: '',
                    asasa: ''
                },
                users:[
                    {
                        name:'José',
                        email: "jose@gmail.com",
                        image:'A',
                        evaluations_count:'4'
                    },
                    {
                        name:'Fabio',
                        email: "fabio@gmail.com",
                        image:'B',
                        evaluations_count:'7'
                    },
                    {
                        name:'Xablau',
                        email: "xablau@gmail.com",
                        image:'C',
                        evaluations_count:'54354353'
                    },
                    {
                        name:'José',
                        email: "jose@gmail.com",
                        image:'A',
                        evaluations_count:'4'
                    },
                    {
                        name:'Fabio',
                        email: "fabio@gmail.com",
                        image:'B',
                        evaluations_count:'7'
                    },
                    {
                        name:'Xablau',
                        email: "xablau@gmail.com",
                        image:'C',
                        evaluations_count:'54354353'
                    },
                    {
                        name:'José',
                        email: "jose@gmail.com",
                        image:'A',
                        evaluations_count:'4'
                    },
                    {
                        name:'Fabio',
                        email: "fabio@gmail.com",
                        image:'B',
                        evaluations_count:'7'
                    },
                    {
                        name:'Xablau',
                        email: "xablau@gmail.com",
                        image:'C',
                        evaluations_count:'54354353'
                    }
                ]
            }
        }
    }
</script>
