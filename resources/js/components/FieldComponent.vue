<template>
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
            <form class="card-body border-top">
                <div class="form-group">
                    <label>Type</label>
                    <select v-model="field.type" class="form-control form-control-sm">
                        <option v-for="type in types" :value="type">{{ type | capitalize }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input v-model="field.name" type="text" class="form-control" aria-label="Name">
                </div>

                <div class="form-group">
                    <label>Title</label>
                    <input v-model="field.title" type="text" class="form-control" aria-label="Title">
                </div>

                <div class="form-group">
                    <label>Meta</label>
                    <textarea v-model="field.meta" required="required" class="form-control" aria-label="Content"></textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <button
                            @click="storeOrUpdateField"
                            type="button"
                            :disabled="loading"
                            class="btn btn-sm btn-outline-success"
                        >{{ field.id ? 'Update' : 'Save' }}</button>

                        <button
                            @click="deleteField"
                            type="button"
                            :disabled="!field.id || loading"
                            :class="['btn btn-sm', {'btn-outline-danger': field.id, 'btn-outline-secondary': !field.id}]"
                        >Delete</button>
                    </div>

                    <small class="text-muted text-uppercase">{{ field.id ? 'Id: ' + field.id : 'New' }}</small>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                field: null,
                loading: false,
            }
        },

        props: {
            fieldData: Object,
            fieldIndex: Number,
            types: Array,
        },

        filters: {
            capitalize: function (value) {
                if (!value) {
                    return '';
                }

                value = value.toString();

                return value.charAt(0).toUpperCase() + value.slice(1)
            },
        },

        watch: {
            'field.meta': function(newValue, oldValue) {
                if (typeof newValue === 'object') {
                    this.field.meta = newValue ? JSON.stringify(newValue) : null;
                }
            },
        },

        created() {
            this.field = this.fieldData;
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

            deleteField() {
                this.loading = true;

                return axios.delete('/api/fields/' + this.field.id, this.field)
                    .then(response => this.emitDeleteField())
                    .catch(error => this.catchErrors(error));
            },

            emitDeleteField() {
                this.$parent.$emit('delete-field', {index: this.fieldIndex});
            },

            storeField() {
                return axios.post('/api/fields', this.field)
                    .then(response => this.field = response.data.data)
                    .then(() => this.loading = false)
                    .catch(error => this.catchErrors(error));
            },

            storeOrUpdateField() {
                this.loading = true;

                if (!this.field.id) {
                    return this.storeField();
                }

                return this.updateField();
            },

            updateField() {
                return axios.put('/api/fields/' + this.field.id, this.field)
                    .then(response => this.field = response.data.data)
                    .then(() => this.loading = false)
                    .catch(error => this.catchErrors(error));
            },
        },
    }
</script>
