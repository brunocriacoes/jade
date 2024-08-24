import { form } from "../utils/form.js";
import {
  debounce,
  feedback,
  getFormData,
  loadBtn,
  setFormData,
  to,
  validateFieldsEmpty,
  verifyTypeFormPage,
} from "../helper/helper.js";
import { requestHttp } from "../service/request.js";

class storeCreate extends form {
  constructor(formElement) {
    super(formElement);
    this.init();
  }

  instanceRequest() {
    return new requestHttp();
  }

  addEventListeners() {
    this.form.addEventListener("submit", this.onSubmit.bind(this));
  }

  async init() {
    const typeForm = verifyTypeFormPage();
    const button = this.form.querySelector(".submit-btn span");
    const title = document.querySelector(".title-form-page");
    if (typeForm.type === "edit") {
      title.textContent = "Editar loja";
      button.textContent = "Atualizar";
      this.form.insertAdjacentHTML(
        "beforeend",
        `<input type="hidden" name="publicId" value="${typeForm.id}">`
      );
      const response = await this.get(typeForm.id);
      setFormData(this.form, response.payload);
    } else {
      title.textContent = "Cadastrar loja";
      button.textContent = "Cadastrar";
    }
  }

  validate(data) {
    return validateFieldsEmpty(data, this.form);
  }

  async get(id) {
    const request = this.instanceRequest();
    const typeRoute = "storeInfo";
    const response = await request.get({
      name: typeRoute,
      params: id,
    });
    return response;
  }

  async create(data) {
    const request = this.instanceRequest();
    const response = await request.post({
      name: "storeRegister",
      data: data,
    });
    return response;
  }

  async update(data) {
    const request = this.instanceRequest();
    const response = await request.post({
      name: "storeUpdate",
      data: data,
    });
    return response;
  }

  async onSubmit(event) {
    event.preventDefault();
    const loadButton = loadBtn(this.form.querySelector(".submit-btn"));
    const typeForm = verifyTypeFormPage();
    const dataFields = getFormData(this.form);
    if (!this.validate(dataFields)) {
      loadButton();
      return;
    }
    let request;
    if (typeForm.type === "edit") {
      request = await this.update(dataFields);
    }
    if (typeForm.type === "create") {
      request = await this.create(dataFields);
    }

    if (!request.next) {
      feedback(this.form, request.message, false);
      loadButton();
      return;
    }
    feedback(this.form, request.message);
    debounce(() => {
      loadButton();
      to("listar_loja");
    }, 2000);
  }
}

export function render() {
  new storeCreate("create-store-form");
}
