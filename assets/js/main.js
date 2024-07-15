import { App } from "./App.js";
import { render as render_webhook } from "./pages/listar-webhook.js";
import { render as render_login } from "./pages/login.js";
import { render as render_cadastro_usuario } from "./pages/cadastro_usuario.js";

window.onload = (_) => {
  let app = new App();
  app.add("login", render_login);
  app.add("listar_webhook", render_webhook);
  app.add("cadastro_usuario", render_cadastro_usuario);
};
