export class dataTable {
  constructor(tableElement, searchElement, editElement, deleteElement) {
    this.table = document.getElementById(tableElement);
    this.searchElement = document.getElementById(searchElement);
    this.editElement = editElement;
    this.deleteElement = deleteElement;
    this.data();
    this.addEventListeners();
  }

  data() {}

  addEventListeners() {}

  injectDataDom(data) {}
}
