import { form } from "../utils/form.js";
import {
  debounce,
  feedback,
  loadBtn,
  to,
  validateFieldsEmpty,
} from "../helper/helper.js";
import { requestHttp } from "../service/request.js";

class recoverPass extends form {
  constructor(formElement) {
    super(formElement);
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
      to("login");
    }, 2000);
  }

  addEventListeners() {
    this.form.addEventListener("submit", this.onSubmit.bind(this));
  }

  validate(data) {
    if (!validateFieldsEmpty(data, this.form)) return false;
    return true;
  }

  async createUser(data) {
    const request = this.instanceRequest();
    const reponse = await request.post({
      name: "recoverPass",
      data: data,
    });
    return reponse;
  }
}

export function render() {
  new recoverPass("recuperar-senha-form");
}
