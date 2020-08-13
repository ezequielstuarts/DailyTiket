
<template>
<div>
    <add-client-component
        @getClients="getClients"
        @deleteErrors="deleteErrors">
    </add-client-component>
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div v-if="loading_clients" class="container mx-auto text-center mt-5">
                    <div class="spinner-grow" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-columns">
                    <card-client-component
                        v-for="client in clients" :key="client.id"
                        :client="client" :totalTikets="totalTikets"
                        :loading_tikets="loading_tikets"
                        @getTikets="getTikets"
                        @getClient="getClient"
                        @getClients="getClients">
                    </card-client-component>
                </div>
            </div>
            <div class="col-4" v-if="client">
                <!-- <div v-if="loading_client">
                    <div class="spinner-border mx-auto text-center" style="display: inherit;" role="status"><span class="sr-only">Loading...</span></div>
                </div> -->
                <client-detail-component
                    :tikets="tikets"
                    :client="client"
                    :lastTiket="lastTiket"
                    :totalTikets="totalTikets"
                    :loading_tikets="loading_tikets"
                    @getTikets="getTikets"
                    @getClient="getClient">
                </client-detail-component>
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
                totalTikets: 0,
                lastTiket: '',
                loading_clients: false,
                loading_client: false,
                loading_tikets: false,
                saving_client: false,
                client: null,
                errors: [],
            }
        },
        mounted() {
            this.getClients();
        },
        methods: {
            getClients: function() {
                this.errors = [];
                // this.loading_clients = true;
                axios.get('getClients').then(response => {
                    this.clients = response.data.clients;
                    // this.loading_clients = false;
                });
            },
            getClient(id) {
                this.loading_client = true;
                this.errors = [];
                axios.get(`getClient/${id}`).then(response => {
                    this.client = response.data.client;
                    this.getTikets(id);
                    this.loading_client = false;
                });
            },
            getTikets(id) {
                this.loading_tikets = true;
                this.errors = [];
                axios.get(`getTikets/${id}`).then(response => {
                    this.tikets = response.data.tikets;
                    this.totalTikets = response.data.totalTikets;
                    this.lastTiket = response.data.lastTiket;
                    this.loading_tikets = false;
                });
            },
            deleteErrors: function() {
                this.errors = [];
                console.log('Delete Errors');
            }
        }
    };
</script>