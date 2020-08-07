<template>
    <div>
        <div class="card">
            <h6 class="card-header"> {{client.name}} </h6>
            <div class="card-body">
                <h5 class="card-title">Total: $ {{client.id}} </h5>
                <div class="input-group mb-3">
                    <form v-on:submit.prevent="createTiket(client.id)" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Agregar Tiket" name="newAmount" v-model="newAmount">

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
</template>

<script>
 import axios from 'axios';
    import toastr from 'toastr';
    import Swal from 'sweetalert2';
    import moment from 'moment';
    export default {
    props:['client'],
        data() {
            return {
                newAmount: '',
                newClient: '',
                errors: [],
                agregandoTiket: false,
            }
        },
        methods: {
            getClient() {
                this.$emit('getClient', this.client.id);
            },
            deleteClient() {
                this.$emit('deleteClient', this.client.id);
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
                    this.getClient();
                    toastr.success('Tiket Agregado');
                    this.agregandoTiket = false;
                }).catch(error => {
                    this.errors = error.response.data.errors.amount;
                    toastr.error('Ocurrio algún error');
                    this.agregandoTiket = false;
                });
            },
        }
    };
</script>
