export class form {
  constructor(formElement) {
    this.form = document.getElementById(formElement);
    this.addEventListeners();
    this.initializeForm();
  }

  initializeForm() {}

  async onSubmit(event) {}

  addEventListeners() {}

  validate(data) {}
}
