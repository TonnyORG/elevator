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
import FloorsMixin from './mixins/floors';

export default {
    mixins: [FloorsMixin],

    components: {
        'floor-component' : FloorComponent,
    },

    created() {
        this.initFloorsArray();
    },
}
</script>
