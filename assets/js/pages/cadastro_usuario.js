import { form } from "../utils/form.js";

class userCreate extends form {
  constructor(formElementId) {
    super(formElementId);
  }

  async onSubmit(event) {
    event.preventDefault();
  }

  addEventListeners() {
    this.form.addEventListener("submit", this.onSubmit.bind(this));
  }

  validate(data) {
    for (const key in data) {
      if (data[key].length === 0) return false;
    }

    return true;
  }
}

export function render() {
  new userCreate("create-user-form");
}
