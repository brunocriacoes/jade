import { form } from "../utils/form.js";
import {
  debounce,
  feedback,
  loadBtn,
  to,
  validateFieldsEmpty,
} from "../helper/helper.js";
import { requestHttp } from "../utils/request.js";

class storeCreate extends form {
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

    const request = await this.createStore(dataFields);
    if (!request.next) {
      feedback(this.form, request.message, false);
      loadButton();
      return;
    }
    debounce(() => {
      loadButton();
      to("listar_loja");
    }, 2000);
  }

  addEventListeners() {
    this.form.addEventListener("submit", this.onSubmit.bind(this));
  }

  validate(data) {
    return validateFieldsEmpty(data, this.form);
  }

  async createStore(data) {
    const request = this.instanceRequest();
    const reponse = await request.post({
      name: "storeRegister",
      data: data,
    });
    return reponse;
  }
}

export function render() {
  new storeCreate("create-store-form");
}
