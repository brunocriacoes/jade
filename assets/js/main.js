import { App } from "./App.js";
import {render as render_webhook} from "./pages/listar-webhook.js"

window.onload = _ => { 
	let app = new App();
	app.add("listar_webhook", render_webhook)
}
