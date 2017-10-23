<template>
    <table class="table table-bordered table-sm text-center">
        <thead class="thead-dark">
            <tr>
                <th>
                    <i class="fa fa-building"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="floor in floors"
                is="floor-component"
                :floor="floor"
            ></tr>
        </tbody>
    </table>
</template>

<script>
import FloorComponent from './floor.component.vue';

export default {
    data() {
        return {
            floors: [],
        }
    },

    components: {
        'floor-component' : FloorComponent,
    },

    created() {
        let floors = window.elevatorConfiguration.floors;

        for (let index in floors) {
            this.floors.push({
                maintenance: floors[index],
                number: index,
            });
        }

        this.floors.sort(this.sortFloorsArray);
    },

    methods: {
        sortFloorsArray(a, b) {
            if (a.number > b.number) {
                return -1;
            }

            if (a.number < b.number) {
                return 1;
            }

            return 0;
        },
    },
}
</script>
