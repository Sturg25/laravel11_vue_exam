<template lang="">
    <v-card min-width="700">
        <v-card-title class="d-flex justify-space-between">
            <div>
                <span class="font-weight-black" v-if="toggleTable">
                    User List
                    <v-btn @click="(toggleTable = !toggleTable), reloadData()" variant="plain" v-if="user.usertype == 'admin'">To Do List</v-btn>
                </span>
                <span class="font-weight-black" v-else>
                    To Do List
                    <v-btn @click="(toggleTable = !toggleTable), reloadData()" variant="plain" v-if="user.usertype == 'admin'">User List</v-btn>
                </span>
            </div>

            <div>
                <v-btn @click="toggleTable ? (dialog_user = true) : (dialog = true)" variant="plain">{{ !toggleTable ? "Create To Do" : "Create User" }}</v-btn>
            </div>
        </v-card-title>
        <v-card-text class="pt-4">
            <user_table :data="items" @reloadData="reloadData()" v-if="toggleTable && showTable" />
            <todo_table :data="items" @reloadData="reloadData()" v-else-if="showTable" />
        </v-card-text>

        <v-dialog v-model="dialog" width="500">
            <v-card min-width="500">
                <v-form @submit.prevent="createToDoItem" ref="myForm">
                    <v-card-title>
                        <span class="font-weight-black"> Create To Do </span>
                    </v-card-title>
                    <v-card-text class="pt-4">
                        <v-textarea v-model="description" :rules="rules" required label="Description"></v-textarea>
                    </v-card-text>
                    <v-card-action class="d-flex justify-end">
                        <v-btn class="mb-2 mr-2" type="submit">Submit</v-btn>
                    </v-card-action>
                </v-form>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialog_user" width="400">
            <v-card width="400">
                <template v-slot:title>
                    <span class="font-weight-black"> REGISTER </span>
                </template>
                <v-card-text class="pt-4">
                    <v-form @submit.prevent="submit">
                        <v-text-field v-model="username" :rules="rules" label="Username"></v-text-field>
                        <v-text-field v-model="email" :rules="emailRules" label="Email"></v-text-field>
                        <v-text-field v-model="firstname" :rules="rules" label="First Name"></v-text-field>
                        <v-text-field v-model="lastname" :rules="rules" label="Last Name"></v-text-field>
                        <v-select v-model="roletype" :items="['admin', 'user']" :rules="rules" label="Role Type"></v-select>
                        <v-text-field v-model="password" :rules="rules" type="password" label="Password"></v-text-field>
                        <v-btn class="mt-2" type="submit" block>Create New User</v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-snackbar v-model="snackbar" :color="snackbarColor">
            {{ snackbarText }}
            <template v-slot:actions>
                <v-btn variant="text" @click="snackbar = false"> Close </v-btn>
            </template>
        </v-snackbar>
    </v-card>
</template>
<script>
import todo_table from "../../components/todo_table.vue";
import user_table from "../../components/user_table.vue";
export default {
    components: {
        todo_table,
        user_table,
    },
    data() {
        return {
            user: {},
            dialog_user: false,
            toggleTable: false,
            snackbar: false,
            snackbarColor: "",
            snackbarText: "",
            dialog: false,
            description: "",
            rules: [(v) => !!v || "Field is required"],
            items: [],
            showTable: false,

            username: "",
            firstname: "",
            roletype: "",
            lastname: "",
            email: "",
            password: "",

            emailRules: [
                (value) => {
                    if (value) return true;

                    return "E-mail is requred.";
                },
                (value) => {
                    if (/.+@.+\..+/.test(value)) return true;

                    return "E-mail must be valid.";
                },
            ],
        };
    },
    async mounted() {
        const token = localStorage.getItem("token");
        console.log(token);
        this.user = JSON.parse(localStorage.getItem("user"));
        if (!token) {
            this.$router.push({ name: "page-not-found" });
        }

        this.user = JSON.parse(localStorage.getItem("user"));
        this.reloadData();
    },
    methods: {
        async reloadData() {
            this.showTable = false;
            const token = localStorage.getItem("token");
            let response = {};
            if (this.toggleTable) {
                response = await axios.get("/api/userall", { headers: { Authorization: "Bearer " + token } });
            } else {
                response = await axios.get("/api/todo" + "/" + this.user.id, { headers: { Authorization: "Bearer " + token } });
            }
            this.items = response.data;
            console.log("this.items", this.items);
            this.showTable = true;
        },
        async createToDoItem() {
            const token = localStorage.getItem("token");
            const { valid } = await this.$refs.myForm.validate();
            if (!valid) {
                this.snackbarText = "Description is required";
                this.snackbarColor = "error";
                this.snackbar = true;
                return;
            }

            await axios
                .post(
                    "/api/todo/" + this.user.id,
                    {
                        description: this.description,
                    },
                    { headers: { Authorization: "Bearer " + token } }
                )
                .then(async (response) => {
                    await this.reloadData();
                    this.snackbarText = "Item created successfully";
                    this.snackbarColor = "success";
                    this.snackbar = true;
                    this.dialog = false;
                })
                .catch((error) => console.log(error));
        },

        async submit() {
            await axios
                .post("/api/register", {
                    username: this.username,
                    password: this.password,
                    email: this.email,
                    firstname: this.firstname,
                    usertype: this.roletype,
                    lastname: this.lastname,
                })
                .then(async (response) => {
                    console.log(response);
                    if (response.data.message == "success") {
                        await this.reloadData();

                        this.snackbarText = "User created successfully";
                        this.snackbarColor = "success";
                        this.snackbar = true;
                        this.dialog_user = false;
                    }
                })
                .catch((error) => console.log(error));
        },
    },
};
</script>
<style lang=""></style>
