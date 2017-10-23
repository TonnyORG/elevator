export default {
    data() {
        return {
            floors: [],
        }
    },

    methods: {
        getFirstAvailableFloor() {
            for (let index in this.floors) {
                if (!this.floors[index].maintenance) {
                    return this.floors[index];
                }
            }
        },

        initFloorsArray() {
            return new Promise((resolve, reject) => {
                let floors = window.elevatorConfiguration.floors;

                for (let index in floors) {
                    this.floors.push({
                        maintenance: !floors[index],
                        number: index,
                    });
                }

                this.floors.sort(this.sortFloorsArray);

                resolve(true);
            });
        },

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
