<template>
<div>
    <div class="card">
        <div class="card-header"><h4 v-text="client.name"></h4> </div>
        <div class="card-body">
            <h5 class="card-title" ></h5>

            <div v-if="loading_tiket" class="container mx-auto text-center mt-5">
                <div class="spinner-grow" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div class="tikets" >
                <ul v-for="(tiket, index) in tikets" :key="index">
                    <li> {{tiket.amount}} </li>
                </ul>
            </div>

            <a href="#" class="btn btn-primary">ClientDetail</a>
        </div>
    </div>
</div>
</template>

<script>
    import axios from 'axios';
    export default {
        props: ['client'],
        data() {
            return {
                client: {
                    // name: '',
                    // id: '',
                },
                tikets: null,
                loading_tiket: true,
                // id = client.id,
            };
        },
        mounted() {
            getTikets(5)
        },
        methods: {
            getTikets(id) {
                axios.get(`getTikets/${client.id}`).then(response => {
                    this.tikets = response.data.tikets;
                    this.loading_tiket = false;
                    console.log(this.tikets);

                });
            },
        }
    }
</script>
