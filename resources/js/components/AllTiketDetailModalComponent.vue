<template>
    <div class="modal fade" id="tiketDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cliente: {{clientName}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{clientId}}</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['client'],
        mounted() {
            console.log('Component modal.');
            console.log(this.clientId);
            // console.log(this.client);
        },
        computed: {
            clientName: function() {
                if (this.client) {
                    return this.client.name
                }
            },
            clientId: function() {
                if (this.client) {
                    return this.client.id
                }
            }
        },
        methods: {
        }
    }
</script>
