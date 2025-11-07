import App from "./App.svelte";
// 👈 expose-le globalement
import "./app.css";
import { mount } from "svelte";
import "bootstrap/dist/css/bootstrap.min.css";
import * as bootstrap from "bootstrap"; // 👈 importe tout le JS
window.bootstrap = bootstrap;

import "bootstrap/dist/js/bootstrap.bundle.min.js";

const app = mount(App, {
  target: document.getElementById("app"),
});

export default app;
