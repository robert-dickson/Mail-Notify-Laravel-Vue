// import { createApp } from "vue";
// import App from "./App.vue";
// import router from "./router/router.js";

// createApp(App).use(router).mount("#app");
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router.js";

import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

const vuetify = createVuetify({
  components,
  directives,
});

createApp(App).use(router).use(vuetify).mount("#app");
