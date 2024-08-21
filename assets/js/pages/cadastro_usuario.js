import { form } from "../utils/form.js";
import {
  debounce,
  feedback,
  loadBtn,
  to,
  validateFieldsEmpty,
} from "../helper/helper.js";
import { requestHttp } from "../utils/request.js";

class userCreate extends form {
  constructor(formElementId) {
    super(formElementId);
  }

  instanceRequest() {
    return new requestHttp();
  }

  async onSubmit(event) {
    event.preventDefault();
    const formData = new FormData(this.form);
    const loadButton = loadBtn(this.form.querySelector(".submit-btn"));
    const dataFields = Object.fromEntries(formData.entries());
    if (!this.validate(dataFields)) {
      loadButton();
      return;
    }
    const request = await this.createUser(dataFields);
    if (!request.next) {
      feedback(this.form, request.message, false);
      loadButton();
      return;
    }
    feedback(this.form, request.message);
    debounce(() => {
      loadButton();
      to("listar_usuario");
    }, 2000);
  }

  addEventListeners() {
    this.form.addEventListener("submit", this.onSubmit.bind(this));
  }

  validate(data) {
    if (!validateFieldsEmpty(data, this.form)) return false;

    if (data.pass !== data.confirm_pass) {
      feedback(this.form, "As senhas não são iguais", false);
      return false;
    }
    if (data.pass.length < 8) {
      feedback(this.form, "A senha deve ter no mínimo 8 caracteres", false);
      return false;
    }
    return true;
  }

  async createUser(data) {
    const request = this.instanceRequest();
    const reponse = await request.post({
      name: "userCreate",
      data: data,
    });
    return reponse;
  }
}

export function render() {
  new userCreate("create-user-form");
}
