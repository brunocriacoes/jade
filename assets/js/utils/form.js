export class form {
  constructor(formElementId) {
    this.form = document.getElementById(formElementId);
    this.addEventListeners();
  }

  async onSubmit(event) {}

  addEventListeners() {}

  validate(data) {}
}
