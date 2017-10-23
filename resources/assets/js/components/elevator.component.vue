<template>
    <div>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center text-uppercase" colspan="2" scope="col">
                        Elevator #{{ elevator.id }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">Current Floor</th>
                    <td>{{ elevator.current_floor }}</td>
                </tr>
                <tr>
                    <th scope="row">Direction</th>
                    <td>{{ elevator.direction }}</td>
                </tr>
                <tr>
                    <th scope="row">Signal</th>
                    <td>{{ elevator.signal }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import FloorComponent from './floor.component.vue';

export default {
    props: {
        elevator: {
            required: true,
            type: Object,
        },
    },
}
</script>
