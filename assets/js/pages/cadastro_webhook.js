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
    if (!validateFieldsEmpty(data, this.form)) return false;
    return true;
  }
}

export function render() {
  new userCreate("create-webhook-form");
}
