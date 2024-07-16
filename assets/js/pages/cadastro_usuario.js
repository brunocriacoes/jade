import { form } from "../utils/form.js";
import { feedback, loadBtn, to } from "../helper/helper.js";

class userCreate extends form {
  constructor(formElementId) {
    super(formElementId);
  }

  async onSubmit(event) {
    event.preventDefault();
    const formData = new FormData(this.form);
    const data = Object.fromEntries(formData.entries());
    if (!this.validate(data)) return;
    const loadButton = loadBtn(this.form.querySelector(".submit-btn"));
    setInterval(() => {
      loadButton();
    }, 1000);
    setInterval(() => {
      to("listar_usuario");
    }, 3000);
    feedback(this.form, "Usuário criado com sucesso");
  }

  addEventListeners() {
    this.form.addEventListener("submit", this.onSubmit.bind(this));
  }

  validate(data) {
    for (const key in data) {
      if (data[key].length === 0) {
        feedback(this.form, "Preencha todos os campos", false);
        return false;
      }
    }
    if (data.password !== data.confirm_password) {
      feedback(this.form, "As senhas não são iguais", false);
      return false;
    }
    if (data.password.length < 6) {
      feedback(this.form, "A senha deve ter no mínimo 6 caracteres", false);
      return false;
    }
    return true;
  }
}

export function render() {
  new userCreate("create-user-form");
}
