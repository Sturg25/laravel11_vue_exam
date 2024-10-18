<template lang="">
    <v-card width="400" class="mx-auto my-5 elevation-12">
        <template v-slot:title>
            <span class="font-weight-black text-h5">LOGIN</span>
            <v-btn to="/register" variant="text" class="float-right">Register</v-btn>
        </template>
        <v-card-text class="pt-4">
            <v-form @submit.prevent="submit" ref="loginForm">
                <v-text-field v-model="username" :rules="rules" label="Username" outlined></v-text-field>
                <v-text-field v-model="password" type="password" :rules="rules" label="Password" outlined></v-text-field>
                <v-btn class="mt-4" type="submit" block color="primary">Submit</v-btn>
            </v-form>
        </v-card-text>
        <v-snackbar v-model="snackbar" color="error" timeout="3000">
            {{ text }}
            <template v-slot:actions>
                <v-btn variant="text" @click="snackbar = false">Close</v-btn>
            </template>
        </v-snackbar>
    </v-card>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            username: "",
            password: "",
            snackbar: false,
            text: "",
            rules: [(v) => !!v || "Field is required"],
        };
    },
    methods: {
        async submit() {
            try {
                const response = await axios.post("/api/login", {
                    username: this.username,
                    password: this.password,
                });
                if (response.data.status === "success") {
                    const token = response.data.authorisation.token;
                    localStorage.setItem("token", token);
                    localStorage.setItem("user", JSON.stringify(response.data.user));
                    this.$router.push({ name: "todo" });
                } else {
                    this.text = response.data.message;
                    this.snackbar = true;
                }
            } catch (error) {
                this.text = "Login failed. Please try again.";
                this.snackbar = true;
            }
        },
    },
};
</script>

<style lang="css">
.v-card {
    border-radius: 12px;
}

.v-btn {
    font-weight: bold;
}
</style>
