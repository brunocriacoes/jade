export class load {
  constructor(classLoad) {
    this.classElement = document.getElementById(classLoad);
  }

  init() {
    setTimeout(() => {
      this.classElement.style.display = "block";
    }, 1000);
  }

  close() {
    setTimeout(() => {
      this.classElement.style.display = "none";
    }, 1000);
  }
}
