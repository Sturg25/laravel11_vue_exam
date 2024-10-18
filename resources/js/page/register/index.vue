<template lang="">
    <v-card width="400" class="mx-auto my-5 elevation-12">
        <template v-slot:title>
            <span class="font-weight-black text-h5">REGISTER</span>
            <v-btn to="/login" variant="text" class="float-right">Login</v-btn>
        </template>
        <v-card-text class="pt-4">
            <v-form @submit.prevent="submit" ref="registerForm">
                <v-text-field v-model="username" :rules="rules" label="Username" outlined></v-text-field>
                <v-text-field v-model="email" :rules="emailRules" label="Email" outlined></v-text-field>
                <v-text-field v-model="firstname" :rules="rules" label="First Name" outlined></v-text-field>
                <v-text-field v-model="lastname" :rules="rules" label="Last Name" outlined></v-text-field>
                <v-text-field v-model="password" :rules="rules" type="password" label="Password" outlined></v-text-field>
                <v-btn class="mt-4" type="submit" block color="primary">Submit</v-btn>
            </v-form>
        </v-card-text>
    </v-card>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            username: "",
            firstname: "",
            lastname: "",
            email: "",
            password: "",
            emailRules: [
                (value) => !!value || "E-mail is required.",
                (value) => /.+@.+\..+/.test(value) || "E-mail must be valid.",
            ],
            rules: [(v) => !!v || "Field is required"],
        };
    },
    methods: {
        async submit() {
            try {
                const response = await axios.post("/api/register", {
                    username: this.username,
                    password: this.password,
                    email: this.email,
                    firstname: this.firstname,
                    lastname: this.lastname,
                });
                if (response.data.message === "success") {
                    this.$router.push({ name: "login" });
                }
            } catch (error) {
                console.log(error);
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
