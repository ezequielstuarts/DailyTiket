
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
                    <div class="card" v-for="(client, index) in clients" :key="index">
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
                    </div>
                </div>
            </div>
            <div class="col-4" v-if="client">
                <div v-if="tikets.length <= 0" >
                    <h6 class="card-header text-success mb-3"><b>{{client.name}}</b>, no contiene tikets. </h6>
                        <form v-on:submit.prevent="createTiket(client.id)" method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Agregar Tiket" name="newAmount" v-model="newAmount" v-focus>

                                <div v-if="!agregandoTiket" class="input-group-append">
                                    <button class="btn-sm btn-outline-success" type="submit" title="Agregar Tiket"><i class="fas fa-cart-plus"></i></button>
                                </div>
                                <div v-else class="input-group-append">
                                    <button class="btn btn-outline-success" type="button" disabled><span class="spinner-border spinner-border-sm success" role="status" aria-hidden="true"></span></button>
                                </div>

                                <span v-for="error in errors" :key="error" class="text-danger"> {{error}} </span>
                            </div>
                        </form>
                </div>

                <div class="card" v-else>
                    <div v-if="loading_tiket" class="container mx-auto text-center mt-5">
                        <div class="spinner-grow" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <!-- TABLE TIKETS -->
                    <div class="row" v-else>
                        <div class="container tikets">
                        <div class="card-header mb-3">
                            <p class="text-center">{{client.name}}</p>
                            <p>Catidad de tikets: {{tikets.length}} </p>
                            </div>

                        <form v-on:submit.prevent="createTiket(client.id)" method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Agregar Tiket" name="newAmount" v-model="newAmount" v-focus>

                                <div v-if="!agregandoTiket" class="input-group-append">
                                    <button class="btn-sm btn-outline-success" type="submit" title="Agregar Tiket"><i class="fas fa-cart-plus"></i></button>
                                </div>
                                <div v-else class="input-group-append">
                                    <button class="btn btn-outline-success" type="button" disabled><span class="spinner-border spinner-border-sm success" role="status" aria-hidden="true"></span></button>
                                </div>

                                <span v-for="error in errors" :key="error" class="text-danger"> {{error}} </span>
                            </div>
                        </form>

                            <table class="table table-hover">
                                <tbody class="icon-action-client">
                                    <tr v-for="(tiket, index) in tikets" :key="index">
                                        <td v-if="editMode" >INPUT</td>
                                        <td v-else>$ {{tiket.amount}}</td>
                                        <td class="icon-action-client" width="10px"><a href="" @click.prevent="deleteTiket(tiket, client)" title="Eliminar Tiket">
                                            <i class="far fa-trash-alt"></i></a></td>
                                        <!-- <td class="icon-action-client" width="10px" title="Editar Tiket"><a href=""><i class="fas fa-pen"></i></a></td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TABLE TIKETS -->
                </div>
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
                agregandoTiket: false,
                client: null,
                newClient: '',
                newAmount: '',
                errors: [],
                editMode: false,
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
            sumarTikets(arrTikets){
                var total = 0;
                for(let i = 0; i <= arrTikets.length; i++);
                    this.total+=arrTikets[this.i];
                    console.log(this.total);
                    console.log('total = '+total);
            },
            getTikets(id) {
                axios.get(`getTikets/${id}`).then(response => {
                    this.tikets = response.data.tikets;
                    this.loading_tiket = false;
                    this.sumarTikets(this.tikets);
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
            createTiket(client, newAmount) {
                this.agregandoTiket = true;
                var url = 'tikets';
                axios.post(url, {
                    amount: this.newAmount,
                    client_id: this.client.id,
                }).then(response => {
                    this.newAmount = '';
                    this.errors = [];
                    this.getTikets(client);
                    toastr.success('Tiket Agregado');
                    this.agregandoTiket = false;
                }).catch(error => {
                    this.errors = error.response.data.errors.amount;
                    this.agregandoTiket = false;
                });
            },
            editTiket() {
                this.editMode = true;
            }
        }
    };
</script>