import { form } from "../utils/form.js";
import {
  debounce,
  feedback,
  loadBtn,
  getFormData,
  to,
  validateFieldsEmpty,
} from "../helper/helper.js";
import { requestHttp } from "../service/request.js";

class LoginForm extends form {
  constructor(formElement) {
    super(formElement);
    this.apiRoutes = {
      login: "login",
    };
  }

  instanceRequest() {
    return new requestHttp();
  }

  addEventListeners() {
    this.form.addEventListener("submit", this.onSubmit.bind(this));
  }

  validate(data) {
    return validateFieldsEmpty(data, this.form);
  }

  async submitFormData(data) {
    const request = this.instanceRequest();
    return await request.post({
      name: this.apiRoutes.login,
      data: data,
    });
  }

  async onSubmit(event) {
    event.preventDefault();
    const loadButton = loadBtn(this.form.querySelector(".submit-btn"));
    const dataFields = getFormData(this.form);

    if (!this.validate(dataFields)) {
      loadButton();
      return;
    }

    const request = await this.submitFormData({
      ...dataFields,
      pass: dataFields.password,
    });

    if (!request.next) {
      feedback(this.form, request.message, false);
    } else {
      feedback(this.form, request.message);
      debounce(() => {
        to("home");
      }, 2000);
    }

    loadButton();
  }
}

export function render() {
  new LoginForm("login-form");
}
