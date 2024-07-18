import { form } from "../utils/form.js";
import {
  feedback,
  loadBtn,
  to,
  validateFieldsEmpty,
} from "../helper/helper.js";

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
      to("listar_loja");
    }, 3000);
    feedback(this.form, "Loja criada com sucesso");
  }

  addEventListeners() {
    this.form.addEventListener("submit", this.onSubmit.bind(this));
  }

  validate(data) {
    return validateFieldsEmpty(data, this.form);
  }
}

export function render() {
  new userCreate("create-store-form");
}
