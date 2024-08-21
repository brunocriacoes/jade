export class dataTable {
  constructor(tableElementId, searchElementId, editElementId, deleteElementId) {
    this.table = document.getElementById(tableElementId);
    this.searchElement = document.getElementById(searchElementId);
    this.editElement = document.getElementById(editElementId);
    this.deleteElement = document.getElementById(deleteElementId);

    this.data();
    this.addEventListeners();
  }

  data() {}

  addEventListeners() {}

  injectDataDom(data) {}
}
