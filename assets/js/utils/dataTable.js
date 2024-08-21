export class dataTable {
  constructor(tableElementId, searchElementId, editElement, deleteElement) {
    this.table = document.getElementById(tableElementId);
    this.searchElement = document.getElementById(searchElementId);
    this.editElement = editElement;
    this.deleteElement = deleteElement;
    this.data();
    this.addEventListeners();
  }

  data() {}

  addEventListeners() {}

  injectDataDom(data) {}
}
