<template>
    <div>
        <div class="row">
            <div class="col-12 mb-3 text-center">
                <button @click="switchTo('fields')" class="btn btn-sm btn-primary text-uppercase">Fields</button>
                <button @click="switchTo('subscribers')" class="btn btn-sm btn-primary text-uppercase">Subscribers</button>
            </div>
        </div>

        <div :is="activeComponent + '-component'"></div>
    </div>
</template>

<script>
    import FieldsComponent from './FieldsComponent.vue';
    import SubscribersComponent from './SubscribersComponent.vue';

    export default {
        components: {
            'fields-component': FieldsComponent,
            'subscribers-component': SubscribersComponent,
        },

        data: function () {
            return {
                activeComponent: 'subscribers',
            }
        },

        methods: {
            switchTo(componentName) {
                this.activeComponent = componentName;
            },
        },
    }
</script>
