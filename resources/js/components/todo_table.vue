<template lang="">
    <div>
        <v-data-table :items="data" :headers="headers" class="elevation-1">
            <template v-slot:item.status="{ item }">
                <v-chip :color="service_general.getColorChipStatus(item.status)" class="ma-2" label>
                    {{ $filters.uppercase(item.status) }}
                </v-chip>
            </template>

            <template v-slot:item.action="{ item }">
                <v-btn
                    @click="updateToDoItem(item, true)"
                    variant="outlined"
                    color="green"
                    icon
                    class="mx-1"
                    aria-label="Mark as completed"
                >
                    <v-icon icon="mdi-thumb-up" />
                </v-btn>

                <v-btn
                    @click="updateToDoItem(item, false)"
                    variant="outlined"
                    color="orange"
                    icon
                    class="mx-1"
                    aria-label="Mark as pending"
                >
                    <v-icon icon="mdi-thumb-down" />
                </v-btn>

                <v-btn
                    @click="trashToDoItem(item)"
                    variant="outlined"
                    color="red"
                    icon
                    class="mx-1"
                    aria-label="Delete item"
                >
                    <v-icon icon="mdi-trash-can" />
                </v-btn>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import general from "../services/general.js";

export default {
    props: ["data"],
    data() {
        return {
            headers: [
                { title: "Description", key: "description" },
                { title: "Status", key: "status" },
                { title: "Action", key: "action" },
            ],
            service_general: general,
        };
    },
    methods: {
        async updateToDoItem(item, bool) {
            const token = localStorage.getItem("token");
            let response = await axios.put(
                "/api/todoUpdate/" + item.id,
                { status: bool ? "completed" : "pending" },
                { headers: { Authorization: "Bearer " + token } }
            );
            this.$emit("reloadData");
        },

        async trashToDoItem(item) {
            const token = localStorage.getItem("token");
            let response = await axios.delete("/api/todoDelete/" + item.id, { headers: { Authorization: "Bearer " + token } });
            this.$emit("reloadData");
        },
    },
};
</script>

<style lang="css">
.v-data-table {
    border-radius: 8px;
    overflow: hidden;
    background: #fff;
}

.v-chip {
    font-weight: bold;
}

.v-btn {
    transition: background-color 0.3s, color 0.3s;
}

.v-btn:hover {
    background-color: rgba(0, 0, 0, 0.1);
}

.elevation-1 {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}
</style>
