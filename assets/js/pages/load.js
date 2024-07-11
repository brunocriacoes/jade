export class load {
  constructor(classLoad) {
    this.classElement = document.getElementById(classLoad);
  }

  init() {
    this.classElement.style.display = "block";
  }

  close() {
    this.classElement.style.display = "none";
  }
}
