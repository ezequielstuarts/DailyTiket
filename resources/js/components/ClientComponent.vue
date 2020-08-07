
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
                <span v-for="error in errors" :key="error" class="text-danger"> {{error}} </span>
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
                    <card-client-component v-for="client in clients" :key="client.id" :client="client" @getClient="getClient" @deleteClient="deleteClient" @getTikets="getTikets"></card-client-component>
                    <!-- <div class="card" v-for="(client, index) in clients" :key="index">
                        <h6 class="card-header"> {{client.name}} </h6>
                        <div class="card-body">
                            <h5 class="card-title">Total: $ {{client.id}} </h5>
                            <div class="input-group mb-3"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button @click="getClient(client.id)" class="btn-sm btn-info"><i class="far fa-eye"></i></button>
                                </div>
                                <div class="col-md-4">
                                    <button @click="deleteClient(client.id)" class="btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="col-4" v-if="client">
                <client-detail-component :tikets="tikets" :client="client"  :loading_tiket="loading_tiket" @getTikets="getTikets"></client-detail-component>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import axios from 'axios';
    import toastr from 'toastr';
    import Swal from 'sweetalert2';
    import moment from 'moment';
    Vue.directive('focus', {
        inserted: function (el) {
            el.focus()
        }
    });
    export default {
        data() {
            return {
                clients: null,
                tikets: 0,
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
                    this.loading_client = false;
                });
            },
            getTikets(id) {
                axios.get(`getTikets/${id}`).then(response => {
                    this.tikets = response.data.tikets;
                    this.loading_tiket = false;
                });
            },
            deleteClient(client) {
                Swal.fire({
                title: 'Desea eliminar este cliente',
                html:'<b><div class="text-danger">Se borraran todos los tikets <br/> </b>asociados a este cliente!</div>.',
                icon: 'warning',
                showCancelButton: true,
                confirmButton: 'btn-sm btn-success',
                cancelButton: 'btn-sm btn-danger',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, borrar!'
                }).then((result) => {
                if (result.value) {
                    axios.delete(`deleteClient/${client}`).then(response => {
                        this.getClients();
                        toastr.success('Cliente eliminado');
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
                });
            },
        }
    };
</script>