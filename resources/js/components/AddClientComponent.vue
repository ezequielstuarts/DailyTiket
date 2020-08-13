<template>
<div>
    <div class="row">
        <div class="container">
            <a href="#" class="btn btn-primary float-right mb-3" data-toggle="modal" data-target="#modalNewClient"><i class="fas fa-plus"></i> Nuevo Cliente</a>
        </div>
    </div>

    <form v-on:submit.prevent="createClient" method="post">
    <div class="modal fade" id="modalNewClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="name">Nombre del cliente</label>
                <input type="text" name="name" class="form-control" v-model="newClient" v-focus autofocus>
                <span v-for="error in errors" :key="error" class="text-danger"> {{error}} </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-if="!saving_client" type="submit" class="btn btn-primary">Guardar</button>

                <button v-else class="btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Agregando...</button>
            </div>
            </div>
        </div>
    </div>
    </form>
</div>

</template>

<script>
    import axios from 'axios';
    import toastr from 'toastr';
    Vue.directive('focus', {
        inserted: function (el) {
            el.focus()
        }
    });
    export default {
        data() {
            return {
                saving_client: false,
                client: null,
                newClient: '',
                errors: [],
            }
        },
        mounted() {
            },
        methods: {
            getClients() {
                this.$emit('getClients');
            },
            deleteErrors() {
                this.$emit('deleteErrors');
            },
            createClient: function() {
                this.saving_client = true;
                var url = 'clients';
                axios.post(url, {
                    name: this.newClient,
                }).then(response => {
                    this.getClients();
                    this.newClient = '';
                    this.errors = [];
                    $('#modalNewClient').modal('hide');
                    toastr.success('Cliente Agregado');
                    this.saving_client = false;
                }).catch(error => {
                    this.saving_client = false;
                    this.errors = error.response.data.errors.name
                });
            },
        }
    };
</script>

