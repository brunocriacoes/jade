export class dataTable {
  constructor(tableElementId, searchElementId) {
    this.table = document.getElementById(tableElementId);
    this.searchElement = document.getElementById(searchElementId);
    this.data();
    this.addEventListenersSearch();
  }
  data() {}

  addEventListenersSearch() {}

  injectDataDom(data) {}

  search() {}
}
