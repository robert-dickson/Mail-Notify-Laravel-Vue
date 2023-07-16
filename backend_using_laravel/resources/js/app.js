import "./bootstrap";
import Vue from "vue";
import registration_form from "./components/registration_form.vue";

new Vue({
    el: "#app",
    components: {
        registration_form,
    },
});
