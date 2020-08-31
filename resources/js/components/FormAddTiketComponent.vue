<template>
<div>
    <form v-on:submit.prevent="createTiket(client.id)" method="post">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Agregar Tiket" name="newAmount" v-model="newAmount">
            <div v-if="!agregandoTiket" class="input-group-append">
                <button class="btn-sm btn-outline-success" type="submit" title="Agregar Tiket"><i class="fas fa-cart-plus"></i></button>
            </div>
            <div v-else class="input-group-append">
                <button class="btn btn-outline-success" type="button" disabled><span class="spinner-border spinner-border-sm success" role="status" aria-hidden="true"></span></button>
            </div>
        </div>
    </form>
</div>
</template>

<script>
 import axios from 'axios';
    import toastr from 'toastr';
    export default {
    props:['client', 'loading_tikets', 'totalAmount'],
        data() {
            return {
                newAmount: '',
                errors: [],
                agregandoTiket: false,
            }
        },
        methods: {
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
                    this.getClient();
                    toastr.success('Tiket Agregado');
                    this.agregandoTiket = false;
                }).catch(error => {
                    // this.errors = error.response.data.errors.amount;
                    toastr.error(error.response.data.errors.amount);
                    this.agregandoTiket = false;
                });
            },
        }
    };
</script>

