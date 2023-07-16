<template>
    <div>
        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
            <li class="nav-item" role="presentation">
                <a
                    class="nav-link active"
                    id="tab-login"
                    data-mdb-toggle="pill"
                    href="#pills-login"
                    role="tab"
                    aria-controls="pills-login"
                    aria-selected="true"
                    >Login</a
                >
            </li>
            <li class="nav-item" role="presentation">
                <a
                    class="nav-link"
                    id="tab-register"
                    data-mdb-toggle="pill"
                    href="#pills-register"
                    role="tab"
                    aria-controls="pills-register"
                    aria-selected="false"
                    >Register</a
                >
            </li>
        </ul>

        <div class="tab-content">
            <div
                class="tab-pane fade show active"
                id="pills-login"
                role="tabpanel"
                aria-labelledby="tab-login"
            >
                <!-- Login form code -->
                <form>
                    <!-- ... -->
                </form>
            </div>
            <div
                class="tab-pane fade"
                id="pills-register"
                role="tabpanel"
                aria-labelledby="tab-register"
            >
                <!-- Registration form code -->
                <form @submit.prevent="registerUser">
                    <!-- ... -->
                    <button
                        type="submit"
                        class="btn btn-primary btn-block mb-3"
                    >
                        Register
                    </button>
                </form>
                <div
                    v-if="registrationStatus === 'success'"
                    class="alert alert-success"
                >
                    Registration successful!
                </div>
                <div
                    v-if="registrationStatus === 'error'"
                    class="alert alert-danger"
                >
                    <ul>
                        <li v-for="error in errors" :key="error">
                            {{ error }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {
                user_name: "",
                email: "",
                password: "",
            },
            validationErrors: {},
            registrationStatus: null,
            errors: [],
        };
    },
    methods: {
        registerUser() {
            this.validationErrors = {};
            this.errors = [];
            this.registrationStatus = null;

            // Perform client-side validation
            if (!this.user.user_name) {
                this.validationErrors.user_name = [
                    "The user name field is required.",
                ];
            }
            if (!this.user.email) {
                this.validationErrors.email = ["The email field is required."];
            }
            if (!this.user.password) {
                this.validationErrors.password = [
                    "The password field is required.",
                ];
            }

            if (Object.keys(this.validationErrors).length > 0) {
                return;
            }

            // Send the registration request to the server
            $.ajax({
                url: "/register",
                method: "POST",
                data: this.user,
                success: (response) => {
                    const { status, data } = response;
                    if (status === "success") {
                        // Registration successful
                        this.registrationStatus = "success";
                    } else {
                        // Registration failed
                        this.registrationStatus = "error";
                        this.errors.push(data);
                    }
                },
                error: (error) => {
                    if (
                        error.responseJSON &&
                        error.responseJSON.status === 422
                    ) {
                        // Validation error from the server
                        this.validationErrors = error.responseJSON.data;
                    } else {
                        // Other server errors
                        this.registrationStatus = "error";
                        this.errors.push(
                            "Registration failed. Please try again later."
                        );
                    }
                },
            });
        },
    },
};
</script>
