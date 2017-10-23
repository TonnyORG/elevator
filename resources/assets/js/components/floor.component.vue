<template>
    <tr>
        <td :class="[floor.maintenance ? 'table-active' : '']">{{ floor.number }}</td>
    </tr>
</template>

<script>
export default {
    props: {
        floor: {
            required: true,
            type: Object,
        },
    },
}
</script>
