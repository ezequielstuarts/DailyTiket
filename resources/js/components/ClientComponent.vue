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
                            <p class="card-text">
                            <p> </p>
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
                                            <td class="icon-action-client" width="10px"><a href="" @click.prevent="deleteTiket(tiket, client)">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg></a></td>
                                            <td class="icon-action-client" width="10px"><a href=""><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.707 13.707a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391L10.086 2.5a2 2 0 0 1 2.828 0l.586.586a2 2 0 0 1 0 2.828l-7.793 7.793zM3 11l7.793-7.793a1 1 0 0 1 1.414 0l.586.586a1 1 0 0 1 0 1.414L5 13l-3 1 1-3z"/><path fill-rule="evenodd" d="M9.854 2.56a.5.5 0 0 0-.708 0L5.854 5.855a.5.5 0 0 1-.708-.708L8.44 1.854a1.5 1.5 0 0 1 2.122 0l.293.292a.5.5 0 0 1-.707.708l-.293-.293z"/><path d="M13.293 1.207a1 1 0 0 1 1.414 0l.03.03a1 1 0 0 1 .03 1.383L13.5 4 12 2.5l1.293-1.293z"/></svg></a></td>
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



