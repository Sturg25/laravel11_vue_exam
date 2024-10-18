<template lang="">
    <div>
        <v-data-table :items="formatData" :headers="headers">
            <template v-slot:item.usertype="{ item }">
                <v-btn @click="updateUserStatusItem(item)" variant="plain" :color="service_general.getColorChipRole(item.usertype)">
                    <v-chip :color="service_general.getColorChipRole(item.usertype)"> {{ $filters.uppercase(item.usertype) }} </v-chip>
                </v-btn>
            </template>
            <template v-slot:item.action="{ item }">
                <v-btn @click="trashToDoItem(item, false)" variant="plain" color="red" icon><v-icon icon="mdi-trash-can" /></v-btn>
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
            // items: [],
            headers: [
                { title: "Fullname", key: "fullname" },
                { title: "Username", key: "username" },
                { title: "Email", key: "email" },
                { title: "Role", key: "usertype" },
                { title: "Action", key: "action" },
            ],
            user: {},
            service_general: general,
        };
    },

    watch: {},
    async mounted() {
        console.log("user", this.data);
    },
    methods: {
        async updateUserStatusItem(item) {
            const token = localStorage.getItem("token");

            let response = await axios.put(
                "/api/userUpdate/" + item.id,
                {
                    role: item.usertype.toLowerCase() === "admin" ? "user" : "admin",
                },
                { headers: { Authorization: "Bearer " + token } }
            );
            this.$emit("reloadData");
        },

        async trashToDoItem(item) {
            const token = localStorage.getItem("token");
            let response = await axios.delete("/api/userDelete/" + item.id, { headers: { Authorization: "Bearer " + token } });
            this.$emit("reloadData");
        },
    },
    computed: {
        formatData() {
            return this.data.map((e) => {
                console.log(e.user_details);
                return { ...e, fullname: e.user_details.firstname + " " + e.user_details.lastname };
            });
        },
    },
};
</script>
<style lang=""></style>
