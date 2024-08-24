import { form } from "../utils/form.js";
import { feedback, loadBtn, to } from "../helper/helper.js";
import { requestHttp } from "../service/request.js";

class login extends form {
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
      feedback(this.form, "Preencha todos os campos", false);
      return;
    }
    const request = await this.login(dataFields);
    if (!request.next) {
      feedback(this.form, request.message, false);
      loadButton();
      return;
    }

    feedback(this.form, request.message);

    debounce(() => {
      loadButton();
      to("home");
    }, 2000);
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
  async login({ email, password }) {
    const request = this.instanceRequest();
    const reponse = await request.post({
      name: "login",
      data: { email, pass: password },
    });
    return reponse;
  }
}

export function render() {
  new login("login-form");
}
