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
                    <div class="card" v-for="(client, index) in clients" :key="index">
                        <h6 class="card-header"> {{client.name}} </h6>
                        <div class="card-body">
                            <h5 class="card-title">Total: $ {{client.total}} </h5>
                            <div class="input-group mb-3">

                                <input type="text" class="form-control" placeholder="Agregar Tiket">
                                <div class="input-group-append">
                                    <button class="btn-sm btn-outline-secondary" type="button" id="addTiket" title="Agregar Tiket"><i class="fas fa-cart-plus"></i></button>
                                </div>

                            </div>
                            <button @click="getClient(client.id)" class="btn-sm btn-primary">Ver Detalle</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4" v-if="client">
                <!-- <client-detail-component :client="client" :id="client.id"></client-detail-component> -->
                <div class="card">
                    <div v-if="loading_tiket" class="container mx-auto text-center mt-5">
                        <div class="spinner-grow" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                        <!-- <h5 class="card-title" ></h5> -->
                        <div class="row">
                            <div class="container tikets">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                        <th colspan="3" v-text="client.name"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="icon-action-client">
                                        <tr v-for="(tiket, index) in tikets" :key="index">
                                            <td>{{tiket.amount}}</td>
                                            <td class="icon-action-client" width="10px"><a href="" @click.prevent="deleteTiket(tiket, client)" title="Eliminar Tiket">
                                                <i class="far fa-trash-alt"></i></a></td>
                                            <td class="icon-action-client" width="10px" title="Editar Tiket"><a href=""><i class="fas fa-pen"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                loading_tiket: true,
                client: null,
            }
        },
        mounted() {
            this.getClients();
        },
        methods: {
            getClients: function() {
                axios.get('getClients').then(response => {
                    this.clients = response.data.clients;
                    this.loading_clients = false;
                });
            },
            getClient(id) {
                axios.get(`getClient/${id}`).then(response => {
                    this.client = response.data.client;
                    this.getTikets(id);
                });
            },
            suma(ti){
                console.log(ti);
            },
            getTikets(id) {
                axios.get(`getTikets/${id}`).then(response => {
                    this.tikets = response.data.tikets;
                    this.suma(this.tikets);
                    this.loading_tiket = false;
                });
            },
            deleteTiket(tiket, client) {
                console.log(tiket.id);
                axios.delete(`deleteTiket/${tiket.id}`).then(response => {
                    this.getTikets(client.id);
                });
            },
        }
    };
</script>



