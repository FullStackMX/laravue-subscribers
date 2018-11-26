<template>
    <div v-if="loading" class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    <p class="m-0">Loading data...</p>
                </div>
            </div>
        </div>
    </div>

    <div v-else class="row">
        <div class="col-12 mb-3 text-center">
            <button @click="addNew" class="btn btn-lg btn-secondary text-uppercase">Add new</button>
        </div>

        <subscriber-component
            v-for="(subscriber, index) in subscribers"
            :fields="fields"
            :subscriber-index="index"
            :subscriber-data="subscriber"
            :key="subscriber.id || subscriber.tempId"
        ></subscriber-component>
    </div>
</template>

<script>
    import SubscriberComponent from './SubscriberComponent.vue';

    export default {
        components: {
            'subscriber-component': SubscriberComponent,
        },

        data: function () {
            return {
                defaultSubscriber: {
                    created_at: null,
                    deleted_at: null,
                    id: null,
                    fields: [],
                    updated_at: null,
                },
                loading: true,
                fields: [],
                subscribers: [],
            }
        },

        mounted() {
            this.getFields();

            this.listenDeleteSubscriber();
        },

        methods: {
            addNew() {
                this.subscribers.unshift(Object.assign({}, this.defaultSubscriber, {
                    tempId: Math.random().toString(36).substr(2, 9),
                }));
            },

            getFields() {
                return axios.get('/api/fields')
                    .then(response => this.fields = response.data.data)
                    .then(() => this.getSubscribers());
            },

            getSubscribers() {
                return axios.get('/api/subscribers')
                    .then(response => this.subscribers = response.data.data)
                    .then(() => this.loading = false);
            },

            listenDeleteSubscriber() {
                this.$on('delete-subscriber', data => this.fields.splice(data.index, 1));
            },
        },
    }
</script>
