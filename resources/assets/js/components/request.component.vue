<template>
    <form @submit.prevent="submitRequest">
        <h4>New Request</h4>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="fromFloor">From</label>
                    <select
                        v-model="request.from"
                        name="fromFloor"
                        id="fromFloor"
                        class="form-control"
                    >
                        <option
                            v-for="floor in floors"
                            :value="floor.number"
                            :disabled="floor.maintenance"
                        >{{ floor.number }}</option>
                    </select>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="toFloor">To</label>
                    <select
                        v-model="request.to"
                        name="toFloor"
                        id="toFloor"
                        class="form-control"
                    >
                        <option
                            v-for="floor in floors"
                            :value="floor.number"
                            :disabled="floor.maintenance"
                        >{{ floor.number }}</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</template>

<script>
import FloorComponent from './floor.component.vue';
import FloorsMixin from './mixins/floors';

export default {
    mixins: [FloorsMixin],

    data() {
        return {
            request: {
                from: null,
                to: null,
            },
        }
    },

    created() {
        this.initFloorsArray()
            .then(response => {
                this.initDefaultValues();
            });
    },

    methods: {
        initDefaultValues() {
            let floor = this.getFirstAvailableFloor();

            if (typeof this.request.from !== 'string') {
                this.request.from = floor.number;
            }

            if (typeof this.request.to !== 'string') {
                this.request.to = floor.number;
            }
        },

        submitRequest() {
            axios.post(this.$el.getAttribute('action'), {
                    from: this.request
                })
                .then(response => {
                    alert('Request scheduled!');
                })
                .catch(error => {
                    alert(error);
                });
        },
    },
}
</script>
