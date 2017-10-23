<template>
    <div class="row">
        <div
            v-for="elevator in elevators"
            :elevator="elevator"
            is="elevator-component"
            class="col col-sm-6"
        ></div>
    </div>
</template>

<script>
import ElevatorComponent from './elevator.component.vue';

export default {
    data() {
        return {
            elevators: [],
        }
    },

    components: {
        'elevator-component' : ElevatorComponent,
    },

    created() {
        this.loadElevators();
    },

    methods: {
        loadElevators() {
            axios.get('/api/elevators')
                .then(response => {
                    this.elevators = response.data;
                });
        },
    },
}
</script>
