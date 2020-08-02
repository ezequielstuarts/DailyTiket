
<template>
<div>
    <div class="row">
        <div class="container-fluid">
            <a href="#" class="btn btn-primary float-right mb-3" data-toggle="modal" data-target="#modalNewClient"><i class="fas fa-plus"></i> Nuevo Cliente</a>
        </div>
    </div>

    <form v-on:submit.prevent="createClient" method="post">
    <div class="modal fade" id="modalNewClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="name">Nombre del cliente</label>
                <input type="text" name="name" class="form-control" v-model="newClient">
                <span v-for="error in errors" class="text-danger"> {{error}} </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>
    </form>

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
    import toastr from 'toastr';
    import Swal from 'sweetalert2'
    export default {
        data() {
            return {
                clients: null,
                tikets: null,
                loading_clients: true,
                loading_tiket: true,
                client: null,
                newClient: '',
                errors: [],
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
                Swal.fire({
                title: 'Desea eliminar este mensaje',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#13b7da',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, borrar!'
                }).then((result) => {
                if (result.value) {
                    axios.delete(`deleteTiket/${tiket.id}`).then(response => {
                        this.getTikets(client.id);
                        toastr.success('Tiket eliminado');
                    })
                    .catch(error => toastr.error('Sucedio algun error</b>!'))
                    }
                })
            },
            createClient: function() {
                var url = 'clients';
                axios.post(url, {
                    name: this.newClient,
                }).then(response => {
                    this.getClients();
                    this.newClient = '';
                    this.errors = [];
                    $('#modalNewClient').modal('hide');
                    toastr.success('Cliente Agregado');
                }).catch(error => {
                    this.errors = error.response.data.errors.name
                    console.log(this.errors.errors.name);
                });
            },
        }
    };
</script>