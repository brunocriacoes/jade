import { App } from "./App.js";
import { render as render_webhook } from "./pages/listar-webhook.js";
import { render as render_login } from "./pages/login.js";
import { render as render_form_usuario } from "./pages/form_usuario.js";
import { render as render_listar_usuario } from "./pages/listar_usuario.js";
import { render as render_form_loja } from "./pages/form_loja.js";
import { render as render_listar_loja } from "./pages/listar_loja.js";
import { render as render_listar_webhook } from "./pages/listar_webhook.js";
import { render as render_recuperar_senha } from "./pages/recuperar_senha.js";

window.onload = (_) => {
  let app = new App();
  app.add("login", render_login);
  app.add("listar_webhook", render_webhook);
  app.add("form_usuario", render_form_usuario);
  app.add("listar_usuario", render_listar_usuario);
  app.add("form_loja", render_form_loja);
  app.add("listar_loja", render_listar_loja);
  app.add("listar_webhook", render_listar_webhook);
  app.add("home", render_listar_loja);
  app.add("recuperar_senha", render_recuperar_senha);
};
