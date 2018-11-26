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

        <field-component
            v-for="(field, index) in fields"
            :types="types"
            :field-index="index"
            :field-data="field"
            :key="field.id || field.tempId"
        ></field-component>
    </div>
</template>

<script>
    import FieldComponent from './FieldComponent.vue';

    export default {
        components: {
            'field-component': FieldComponent,
        },

        data: function () {
            return {
                defaultField: {
                    created_at: null,
                    deleted_at: null,
                    id: null,
                    meta: null,
                    name: '',
                    protected: 0,
                    required: 1,
                    title: '',
                    type: 'string',
                    updated_at: null,
                },
                loading: true,
                fields: [],
                types: [
                    'boolean',
                    'date',
                    'list',
                    'number',
                    'string',
                ],
            }
        },

        mounted() {
            this.getFields();

            this.listenDeleteField();
        },

        methods: {
            addNew() {
                this.fields.unshift(Object.assign({}, this.defaultField, {
                    type: this.types[Math.floor(Math.random() * this.types.length)],
                    tempId: Math.random().toString(36).substr(2, 9),
                }));
            },

            getFields() {
                return axios.get('/api/fields')
                    .then(response => this.fields = response.data.data)
                    .then(() => this.loading = false);
            },

            listenDeleteField() {
                this.$on('delete-field', data => this.fields.splice(data.index, 1));
            },
        },
    }
</script>
