<template>
<div>
    <div class="card card-tikets animate__animated animate__fadeIn">
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
                    </div>
            </div>

            <div v-else>
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
                        <h5>Total $: <span> <b class="text-danger">{{totalAmount}}</b></span> </h5>
                        <p>Cantidad de tikets: {{tikets.length}} </p>
                        <!-- <p class="card-text"><small class="text-muted">Último Tiket: {{lastTiket}} </small></p> -->

                        <button v-if="!deleting_tiket" @click="deleteAllTikets(client)" class="btn btn-sm btn-primary">Eliminar Tikets</button>

                        <button v-else class="btn btn-primary" type="button" disabled> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Eliminando...</button>

                        <!-- <button class="btn btn-sm btn-primary">PDF</button> -->
                        <!-- <button @click="imprimir(client.id)" class="btn btn-sm btn-primary">Imprimir</button> -->
                        </div>
                        <div class="container">
                            <form-add-tiket-component class="mb-3 mt-3"
                            :client="client"
                            @getClient="getClient">
                            </form-add-tiket-component>
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
        props: ['tikets','client', 'loading_tikets', 'totalAmount'],
        data() {
            return {
                errors: [],
                agregandoTiket: false,
                newAmount: '',
                deleting_tiket: false,
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
            imprimir() {
                let url = `/imprimir/${this.client.id}`;
                console.log('imprimiendo');
                window.location.href = url;
            },
            deleteAllTikets(client) {
                Swal.fire({
                title: '¿Desea eliminar todos los tikets de este cliente?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2c3e50',
                cancelButtonColor: '#e74c3c',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, borrar todos!'
                }).then((result) => {
                if (result.value) {
                    this.deleting_tiket = true;
                    axios.delete(`deleteAllTikets/${client.id}`).then(response => {
                        this.$emit('getTikets', this.client.id);
                        toastr.success('Tikets eliminado');
                        this.deleting_tiket = false;
                    })
                    .catch(error => toastr.error('Sucedio algun error</b>!'))
                    }
                })
            }
        }
    }
</script>
