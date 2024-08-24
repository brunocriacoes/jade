export class form {
  constructor(formElement) {
    this.form = document.getElementById(formElement);
    this.addEventListeners();
  }

  async onSubmit(event) {}

  addEventListeners() {}

  validate(data) {}
}
