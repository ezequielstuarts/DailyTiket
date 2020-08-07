<template>
<div>
    <div class="card">
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
                    <p>Cantidad de tikets: {{tikets.length}} </p>
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
                                <td class="icon-action-client" width="10px" title="Editar Tiket"><a href=""><i class="fas fa-pen"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
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
        props: ['tikets','client', 'loading_tiket'],
        data() {
            return {
                errors: [],
                editMode: false,
                agregandoTiket: false,
                newAmount: '',
            };
        },
        mounted() {
        },
        methods: {
            createTiket(client, newAmount) {
                this.agregandoTiket = true;
                var url = 'tikets';
                axios.post(url, {
                    amount: this.newAmount,
                    client_id: this.client.id,
                }).then(response => {
                    this.newAmount = '';
                    this.errors = [];
                    this.$emit('getClient', client.id);
                    toastr.success('Tiket Agregado');
                    this.agregandoTiket = false;
                }).catch(error => {
                    this.errors = error.response.data.errors.amount;
                    this.agregandoTiket = false;
                });
            },
            deleteTiket(tiket, client) {
                Swal.fire({
                title: '¿Desea eliminar este tiket?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#13b7da',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, borrar!'
                }).then((result) => {
                if (result.value) {
                    axios.delete(`deleteTiket/${tiket.id}`).then(response => {
                        this.$emit('getTikets', this.client.id);
                        toastr.success('Tiket eliminado');
                    })
                    .catch(error => toastr.error('Sucedio algun error</b>!'))
                    }
                })
            },
            editTiket() {
                this.editMode = true;
            }
        }
    }
</script>
