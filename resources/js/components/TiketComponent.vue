<template>
        <tr v-if="editMode">
            <td>
                <input type="text" class="form-control" v-model="tiket.amount" v-focus>
                    <span v-for="error in errors" :key="error" class="text-danger"> {{error}} </span>
            </td>
            <td v-if="actualizandoTiket" width="10px">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </td>

            <td v-else width="10px"><a class="icon-action-tiket" v-on:click.prevent="updateTiket(tiket.id)" href="" title="Guardar Cambios">
                <i class="fas fa-save"></i></a>
            </td>

            <td width="10px" title="Editar Tiket"><a href="" @click.prevent="cancel(tiket, client)"><i class="fas fa-ban"></i></a></td>
        </tr>

        <tr v-else>
            <td>$ {{tiket.amount}}</td>
            <td width="10px" title="Editar Tiket"><a href="" @click.prevent="editTiket(tiket, client)"><i class="fas fa-pen"></i></a></td>
            <td width="10px"><a class="icon-action-tiket" href="" @click.prevent="deleteTiket(tiket, client)" title="Eliminar Tiket">
                <i class="far fa-trash-alt"></i></a></td>
        </tr>

</template>

<script>
    import axios from 'axios';
    import toastr from 'toastr';
    import Swal from 'sweetalert2';
    import moment from 'moment';
    export default {
        props:['tiket', 'client'],
        data(){
            return {
                editMode: false,
                actualizandoTiket: false,
                errors: [],
                amount: '',
            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        methods: {
            editTiket() {
                this.editMode = true;
            },
            // createTiket() {
            //     this.editMode = true;
            // },
            cancel() {
                this.editMode = false;
                this.errors = [];
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
            updateTiket(tiketId) {
                this.actualizandoTiket = true;
                const params = {
                    amount: this.tiket.amount
                };
                axios.put(`tikets/${tiketId}`, params).then(response => {
                    this.$emit('getTikets', this.client.id);
                    toastr.info('Tiket Actualizado');
                    this.editMode = false;
                }).catch(error => {
                    this.errors = error.response.data.errors.amount;
                    toastr.error('Ocurrio algún error');
                    this.actualizandoTiket = false;
                });
            },
        }
    }
</script>
