<template>
    <div class="col-12">
        <div class="card card-success">
            <a href="#" @click.prevent="getClient(client.id)"><h5 class="card-header"> {{client.name}}</h5></a>
            <div class="card-body">
                <div class="mb-3">
                    <form-add-tiket-component
                        :client="client"
                        @getClient="getClient">
                    </form-add-tiket-component>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button @click="getClient(client.id)" class="btn-sm btn-primary mr-2"><i class="far fa-eye"></i></button>
                        
                        <!-- <button @click="$emit('tiketsDetail', client.id)" class="btn-sm btn-primary mr-2"><i class="far fa-eye"></i> Detalle completo</button> -->
                        
                        <button @click="tiketsDetail(client.id)" class="btn-sm btn-primary mr-2"><i class="far fa-eye"></i> Detalle completo</button>
                        
                        <button @click="deleteClient(client.id)" class="btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>
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
    props:['client', 'loading_tikets', 'totalAmount'],
        data() {
            return {
                newAmount: '',
                newClient: '',
                agregandoTiket: false,
            }
        },
        methods: {
            getClient() {
                this.$emit('getClient', this.client.id);
            },
            getClients() {
                this.$emit('getClients');
            },
            tiketsDetail() {
                this.$emit('tiketsDetail', this.client.id);
                $('#tiketDetailModal').modal('show');
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
        }
    };
</script>
