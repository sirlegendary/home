<template>
    <v-card class="secondary elevation-0">
        <v-card-text>
            <v-container fluid>
                <v-layout row>
                    <v-flex xs12>
                        <v-text-field
                                name="email"
                                label="Email"
                                v-model="credentials.email"
                                :disabled="input_disabled"
                                autofocus
                                required
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs12>
                        <v-text-field
                                name="password"
                                label="Password"
                                hint="Plz no Hack"
                                v-model="credentials.password"
                                :append-icon="show_pw ? 'visibility_off' : 'visibility'"
                                :append-icon-cb="() => (show_pw = !show_pw)"
                                :type="show_pw ? 'text' : 'password'"
                                :disabled="input_disabled"
                                required
                                @keyup.enter="login()"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs12>
                        <div>
                            <v-btn
                                    dark
                                    default
                                    @click.native="login()"
                                    :disabled="input_disabled"
                            >Login</v-btn>
                        </div>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card-text>
        <v-progress-linear
                :active="progress.active"
                :success="progress.success"
                :error="progress.error"
                :indeterminate="progress.indeterminate"
                v-model="progress.value"
        ></v-progress-linear>
    </v-card>
</template>

<style>
    .progress-linear {
        margin: 0;
        margin-top: -7px;
    }
</style>

<script>
    export default {
        data () {
            return {
                redirect: null,
                input_disabled: false,
                credentials: {
                    email: '',
                    password: ''
                },
                show_pw: false,
                progress: {
                    active: false,
                    indeterminate: true,
                    value: 0,
                    success: false,
                    error: false,
                }
            }
        },
        mounted: function() {
            this.redirectFromHash();
        },
        methods: {
            redirectFromHash () {
                this.redirect = window.location.hash.substr(1);
                if (this.redirect) {
                    document.getElementById('login-redirect').value = this.redirect;
                    window.history.pushState("", document.title, window.location.pathname);
                }
            },
            login() {
                // Disable input and enable the progress bar
                this.input_disabled = true;
                this.progress.active = true;
                this.progress.indeterminate = true;
                this.progress.error = false;
                this.progress.value = 0;
                this.$http.post('api/users/signin', this.credentials).then(response => {
                    // Set the progress bar to successful
                    this.progress.success = true;
                    this.progress.indeterminate = false;
                    this.progress.value = 100;
                    // Set the api token to localstorage and submit the login form to create a session
                    localStorage.setItem('api_token', response.body.token);
                    document.getElementById('login-email').value = this.credentials.email;
                    document.getElementById('login-password').value = this.credentials.password;
                    document.getElementById('login-form').submit();
                }, err => {
                    // Enable input and set progress bar to failed
                    this.input_disabled = false;
                    this.progress.error = true;
                    this.progress.indeterminate = false;
                    this.progress.value = 100;
                });
            },
        }
    }
</script>