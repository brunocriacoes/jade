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

class UserForm extends form {
  constructor(formElement) {
    super(formElement);
    this.typeForm = verifyTypeFormPage();
    this.buttonText = this.typeForm.type === "edit" ? "Atualizar" : "Cadastrar";
    this.titleText =
      this.typeForm.type === "edit" ? "Editar usuário" : "Cadastrar usuário";
    this.apiRoutes = {
      edit: "userUpdate",
      create: "userCreate",
      getInfo: "userInfo",
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
      this.hidePasswordFields();
      const response = await this.getFormData(this.typeForm.id);
      this.addHiddenInput("status", response.payload);
      setFormData(this.form, response.payload);
    }
  }

  hidePasswordFields() {
    const formPassword = this.form.querySelector(".form-password");
    const formConfirmPassword = this.form.querySelector(
      ".form-confirm_password"
    );
    const password = this.form.querySelector(".password");
    const confirmPassword = this.form.querySelector(".confirm_password");
    formPassword.style.display = "none";
    formConfirmPassword.style.display = "none";
    password.removeAttribute("required");
    confirmPassword.removeAttribute("required");
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
    if (!validateFieldsEmpty(data, this.form)) {
      return false;
    }
    if (this.typeForm.type === "create") {
      if (data.pass !== data.confirm_pass) {
        feedback(this.form, "As senhas não conferem", false);
        return false;
      }
    }
    return true;
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
    if (this.typeForm.type === "edit") {
      delete dataFields.pass;
      delete dataFields.confirm_pass;
    }
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
        to("listar_usuario");
      }, 2000);
    }

    loadButton();
  }
}

export function render() {
  new UserForm("form-user-form").initializeForm();
}
