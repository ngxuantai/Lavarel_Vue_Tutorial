import { createApp } from "vue";
import App from "./views/App.vue";
import router from "./routes";
import Antd from "ant-design-vue";
import "ant-design-vue/dist/antd.css";
import "./bootstrap";
import store from "./store";
moment.locale("ja");
const app = createApp(App).use(router).use(store).use(Antd);

app.mount("#app");
