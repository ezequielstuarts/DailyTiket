<template>

<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div v-if="loading_clients" class="container mx-auto text-center mt-5">
                    <div class="spinner-grow" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-columns">
                    <div class="card" v-for="client in clients" :key="client.id">
                        <h5 class="card-header"> {{client.name}} </h5>
                        <div class="card-body">
                            <h5 class="card-title">Total: $ {{client.total}} </h5>
                            <p class="card-text">
                            <p> </p>
                            <a href="#" class="btn btn-primary">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 fix">
                <div v-if="loading_tikets" class="container mx-auto text-center mt-5">
                    <div class="spinner-grow" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Featured
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                clients: null,
                tikets: null,
                loading_clients: true,
                loading_tikets: true,
                id: 5,
            }
        },
        mounted() {
            this.getClients();
            this.getTikets();
        },
        methods: {
            getClients: function() {
                axios.get('getClients').then(response => {
                    this.clients = response.data.clients;
                    this.loading_clients = false;
                    console.log(this.clients);
                });
            },
            getTikets: function() {
                axios.get('getTikets').then(response => {
                    this.tikets = response.data.tikets;
                    this.loading_tikets = false;
                })
                .catch(function(error) {
                // handle error
                console.log(error);
                });
            },
        }
    }
</script>
