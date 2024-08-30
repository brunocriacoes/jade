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

class StoreForm extends form {
  constructor(formElement) {
    super(formElement);
    this.typeForm = verifyTypeFormPage();
    this.buttonText = this.typeForm.type === "edit" ? "Atualizar" : "Cadastrar";
    this.titleText =
      this.typeForm.type === "edit" ? "Editar loja" : "Cadastrar loja";
    this.apiRoutes = {
      edit: "storeUpdate",
      create: "storeRegister",
      getInfo: "storeInfo",
    };
  }

  instanceRequest() {
    return new requestHttp();
  }

  addEventListeners() {
    this.form.addEventListener("submit", this.onSubmit.bind(this));
  }

  async initializeForm() {
    this.setTitleAndButtonText();
    if (this.typeForm?.type && this.typeForm.type === "edit") {
      this.addHiddenInput("publicId", this.typeForm.id);
      const response = await this.getFormData(this.typeForm.id);
      response.payload.linkRedirect = "https://api.paramour.com.br/obrigado.html?externalId=bling-"+response.payload.externalId;
      setFormData(this.form, response.payload);
    }
  }

  setTitleAndButtonText() {
    const button = this.form.querySelector(".submit-btn span");
    const title = document.querySelector(".title-form-page");
    title.textContent = this.titleText;
    button.textContent = this.buttonText;
  }

  addHiddenInput(name, value) {
    this.form.insertAdjacentHTML(
      "beforeend",
      `<input type="hidden" name="${name}" value="${value}">`
    );
  }

  validate(data) {
    return validateFieldsEmpty(data, this.form);
  }

  async getFormData(id) {
    const request = this.instanceRequest();
    return await request.get({
      name: this.apiRoutes.getInfo,
      params: id,
    });
  }

  async submitFormData(data) {
    const request = this.instanceRequest();
    const routeName =
      this.typeForm.type === "edit"
        ? this.apiRoutes.edit
        : this.apiRoutes.create;
    return await request.post({
      name: routeName,
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

    const request = await this.submitFormData(dataFields);

    if (!request.next) {
      feedback(this.form, request.message, false);
    } else {
      feedback(this.form, request.message);
      debounce(() => {
        to("listar_loja");
      }, 2000);
    }

    loadButton();
  }
}

export function render() {
  new StoreForm("form-store-form").initializeForm();
}
