export class alertCuston {
  constructor(classElementAlert) {
    this.classElement = document.getElementById(classElementAlert);
  }

  success(message) {
    this.classElement.innerHTML = `<div class="alert alert-success" role="alert">${message}</div>`;
  }

  danger(message) {
    this.classElement.innerHTML = `<div class="alert alert-danger" role="alert">${message}</div>`;
  }
}
