<template>
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
            <form class="card-body border-top">
                <div v-for="field in subscriber.fields" class="form-group">
                    <label>{{ field.title }}</label>
                    <input
                        v-if="['date', 'string'].indexOf(field.type) >= 0"
                        v-model="field.pivot.value"
                        type="text"
                        class="form-control"
                        :aria-label="field.title"
                    >
                    <input
                        v-else-if="['number'].indexOf(field.type) >= 0"
                        v-model="field.pivot.value"
                        type="number"
                        class="form-control"
                        :aria-label="field.title"
                    >
                    <select
                        v-else-if="['list'].indexOf(field.type) >= 0"
                        v-model="field.pivot.value"
                        class="form-control form-control-sm"
                    >
                        <option v-for="option in field.meta.options" :value="option">{{ option }}</option>
                    </select>
                    <select
                        v-else-if="['boolean'].indexOf(field.type) >= 0"
                        v-model="field.pivot.value"
                        class="form-control form-control-sm"
                    >
                        <option :value="0">False</option>
                        <option :value="1">True</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <button
                            @click="storeOrUpdateSubscriber"
                            type="button"
                            :disabled="loading"
                            class="btn btn-sm btn-outline-success"
                        >{{ subscriber.id ? 'Update' : 'Save' }}</button>

                        <button
                            @click="deleteSubscriber"
                            type="button"
                            :disabled="!subscriber.id || loading"
                            :class="['btn btn-sm', {'btn-outline-danger': subscriber.id, 'btn-outline-secondary': !subscriber.id}]"
                        >Delete</button>
                    </div>

                    <small class="text-muted text-uppercase">{{ subscriber.id ? 'Id: ' + subscriber.id : 'New' }}</small>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                defaultPivotData: {
                    created_at: null,
                    deleted_at: null,
                    field_id: null,
                    subscriber_id: null,
                    updated_at: null,
                    value: '',
                },
                loading: false,
                subscriber: null,
            }
        },

        props: {
            fields: Array,
            subscriberData: Object,
            subscriberIndex: Number,
        },

        created() {
            this.subscriber = this.subscriberData;
            this.mapSubscriberFieldsData(Object.assign({}, this.subscriberData))
        },

        methods: {
            catchErrors(error) {
                let errors = [];
                errors.push(error.response.data.message + "\n");

                if (typeof error.response.data.errors === 'object') {
                    Object.keys(error.response.data.errors).forEach(key => {
                        errors = errors.concat(error.response.data.errors[key]);
                    });
                }

                alert(errors.join("\n").replace(/^\s+|\s+$/g, ''));

                this.loading = false;
            },

            deleteSubscriber() {
                this.loading = true;

                return axios.delete('/api/subscribers/' + this.subscriber.id, this.subscriber)
                    .then(response => this.emitDeleteSubscriber())
                    .catch(error => this.catchErrors(error));
            },

            emitDeleteSubscriber() {
                this.$parent.$emit('delete-subscriber', {index: this.subscriberIndex});
            },

            findFieldDataById(id, fieldsData) {
                let data = null;

                fieldsData.map(fieldData => {
                    if (fieldData.id == id) {
                        data = fieldData;

                    }
                });

                return data;
            },

            mapSubscriberFieldsData(subscriberData) {
                this.subscriber.fields = [];

                this.fields.map(field => {
                    field.pivot = Object.assign({}, this.defaultPivotData);
                    if (field.type == 'boolean') {
                        field.pivot.value = 0;
                    }

                    let fieldData = this.findFieldDataById(field.id, subscriberData.fields);
                    this.subscriber.fields.push(fieldData ? fieldData : field)
                });
            },

            storeSubscriber() {
                return axios.post('/api/subscribers', this.subscriber)
                    .then(response => this.subscriber = response.data.data)
                    .then(() => this.loading = false)
                    .catch(error => this.catchErrors(error));
            },

            storeOrUpdateSubscriber() {
                this.loading = true;

                if (!this.subscriber.id) {
                    return this.storeSubscriber();
                }

                return this.updateSubscriber();
            },

            updateSubscriber() {
                return axios.put('/api/subscribers/' + this.subscriber.id, this.subscriber)
                    .then(response => this.subscriber = response.data.data)
                    .then(() => this.loading = false)
                    .catch(error => this.catchErrors(error));
            },
        },
    }
</script>
