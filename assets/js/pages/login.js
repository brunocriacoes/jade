import { alertCuston } from "./alert.js";
import { load } from "./load.js";

class login {
  constructor(formElementId) {
    this.loginForm = document.getElementById(formElementId);
    this.addEventListeners();
  }

  async onSubmit(event) {
    event.preventDefault();
    const alert = new alertCuston("box-alert");
    const loadCuston = new load("load");
    const formData = new FormData(this.loginForm);
    const data = Object.fromEntries(formData.entries());
    if (!this.validate(data)) {
      alert.danger("Preencha todos os campos");
      return;
    }
    console.log(data);
    loadCuston.init();

    setInterval(() => {
      alert.success("Login efetuado com sucesso");
    }, 1000);

    setInterval(() => {
      window.location.href = "/home.html";
    }, 3000);
  }

  addEventListeners() {
    this.loginForm.addEventListener("submit", this.onSubmit.bind(this));
  }

  validate(data) {
    if (!data.email || !data.password) {
      return false;
    }
    return true;
  }
}

export function render() {
  new login("login-form");
}
