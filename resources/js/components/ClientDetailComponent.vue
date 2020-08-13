<template>
<div>
    <div class="card card-tikets">
            <div class="ard" >
                <div class="card-info" v-if="tikets.length <= 0">
                    <div class="card-header">
                        <h5 class="text-info"><b>{{client.name}}</b>, no contiene tikets.</h5>
                    </div>
                    <div class="container">
                        <form-add-tiket-component class="mb-3 mt-3"
                            :client="client"
                            @getClient="getClient">
                        </form-add-tiket-component>
                        <!-- <form v-on:submit.prevent="createTiket(client.id)" method="post">
                            <div class="input-group mb-3 mt-3">
                                <input type="text" class="form-control form-control-no-tikets" placeholder="Agregar Tiket" name="newAmount" v-model="newAmount" v-focus>

                                <div v-if="!agregandoTiket" class="input-group-append">
                                    <button class="btn-sm btn-outline-success" type="submit" title="Agregar Tiket"><i class="fas fa-cart-plus"></i></button>
                                </div>
                                <div v-else class="input-group-append">
                                    <button class="btn btn-outline-success" type="button" disabled><span class="spinner-border spinner-border-sm success" role="status" aria-hidden="true"></span></button>
                                </div>
                            </div>
                            <span v-for="error in errors" :key="error" class="text-danger"> {{error}} </span>
                        </form> -->
                    </div>
            </div>

            <div v-else>
                <!-- TABLE TIKETS -->
                <div class="row">
                    <div class="container tikets">
                    <div class="card card-success">
                        <div class="card-header">
                            <div v-if="loading_tikets" class="mx-auto text-center">
                                <div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <h4 v-else class="text-center">{{client.name}}</h4>
                        <hr>
                        <h5>Total $: <span> <b class="text-danger">{{totalTikets}}</b></span> </h5>
                        <p>Cantidad de tikets: {{tikets.length}} </p>
                        <!-- <p class="card-text"><small class="text-muted">Último Tiket: {{lastTiket}} </small></p> -->
                        <button class="btn btn-sm btn-primary">Eliminar Tikets</button>
                        <button class="btn btn-sm btn-primary">PDF</button>
                        <button class="btn btn-sm btn-primary">Imprimir</button>
                        </div>
                        <div class="container">
                            <form-add-tiket-component class="mb-3 mt-3"
                            :client="client"
                            @getClient="getClient">
                            </form-add-tiket-component>
                            <!-- <form v-on:submit.prevent="createTiket(client.id)" method="post">
                                <div class="input-group mb-3 mt-3">
                                    <input type="text" class="form-control" placeholder="Agregar Tiket" name="newAmount" v-model="newAmount" v-focus>

                                    <div v-if="!agregandoTiket" class="input-group-append">
                                        <button class="btn-sm btn-outline-success" type="submit" title="Agregar Tiket"><i class="fas fa-cart-plus"></i></button>
                                    </div>
                                    <div v-else class="input-group-append">
                                        <button class="btn btn-outline-success" type="button" disabled><span class="spinner-border spinner-border-sm success" role="status" aria-hidden="true"></span></button>
                                    </div>

                                </div>
                                    <span v-for="error in errors" :key="error" class="text-danger"> {{error}} </span>
                            </form> -->
                        </div>
                    </div>

                        <table class="table table-hover">
                            <tbody class="icon-action-client">
                                <tiket-component v-for="tiket in tikets" :key="tiket.id"
                                :tiket="tiket"
                                :client="client"
                                @getTikets="getTikets">
                                </tiket-component>
                            </tbody>
                        </table>
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
    import Swal from 'sweetalert2';
    import moment from 'moment';
    export default {
        props: ['tikets','client', 'loading_tikets', 'totalTikets'],
        data() {
            return {
                errors: [],
                agregandoTiket: false,
                newAmount: '',
            };
        },
        mounted() {
        },
        methods: {
            getTikets() {
                this.$emit('getTikets', this.client.id);
            },
            getClient() {
                this.$emit('getClient', this.client.id);
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
                    toastr.success('Tiket Agregado');
                    this.getTikets();
                    this.agregandoTiket = false;
                }).catch(error => {
                    this.errors = error.response.data.errors.amount;
                    this.agregandoTiket = false;
                });
            },
        }
    }
</script>
