import { form } from "../utils/form.js";
import { feedback, loadBtn, to } from "../helper/helper.js";

class login extends form {
  constructor(formElementId) {
    super(formElementId);
  }

  async onSubmit(event) {
    event.preventDefault();
    const formData = new FormData(this.form);
    const data = Object.fromEntries(formData.entries());
    if (!this.validate(data)) {
      feedback(this.form, "Preencha todos os campos", false);
      return;
    }
    const loadButton = loadBtn(this.form.querySelector(".submit-btn"));

    setInterval(() => {
      loadButton();
    }, 1000);

    console.log(data);
    setInterval(() => {
      to("home");
    }, 3000);
    feedback(this.form, "Usuário logado com sucesso");
  }

  addEventListeners() {
    this.form.addEventListener("submit", this.onSubmit.bind(this));
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
