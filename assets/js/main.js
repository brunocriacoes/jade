import { App } from "./App.js";
import { render as render_webhook } from "./pages/listar-webhook.js";
import { render as render_login } from "./pages/login.js";
import { render as render_cadastro_usuario } from "./pages/cadastro_usuario.js";
import { render as render_listar_usuario } from "./pages/listar_usuario.js";
import { render as render_cadastro_loja } from "./pages/cadastro_loja.js";
import { render as render_listar_loja } from "./pages/listar_loja.js";
import { render as render_cadastro_webhook } from "./pages/cadastro_webhook.js";
import { render as render_listar_webhook } from "./pages/listar_webhook.js";

window.onload = (_) => {
  let app = new App();
  app.add("login", render_login);
  app.add("listar_webhook", render_webhook);
  app.add("cadastro_usuario", render_cadastro_usuario);
  app.add("listar_usuario", render_listar_usuario);
  app.add("cadastro_loja", render_cadastro_loja);
  app.add("listar_loja", render_listar_loja);
  app.add("cadastro_webhook", render_cadastro_webhook);
  app.add("listar_webhook", render_listar_webhook);
  app.add("home", render_listar_loja);
};
