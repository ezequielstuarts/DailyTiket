<template>
<div>
    <div v-if="cargando" class="container mx-auto text-center mt-5">
        <div class="spinner-grow" role="status">
              <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>
</div>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                clients: null,
                tikets: null,
                loader_clients: true,
                cargando: true
            }
        },
        mounted() {
            this.getClients();
            this.getTikets();
        },
        methods: {
            getClients: function() {
                axios.get('getClients').then(response => {
                    this.clients = response.data.clients;
                    this.cargando = false;
                });
            },
            getTikets: function() {
                axios.get('getTikets').then(response => {
                    this.tikets = response.data.tikets;
                });
            },
        }
    }
</script>
