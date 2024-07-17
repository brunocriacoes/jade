export class dataTable {
  constructor(tableElementId, searchElementId) {
    this.table = document.getElementById(tableElementId);
    this.searchElement = document.getElementById(searchElementId);
    this.data();
    this.addEventListenersSearch();
    this.tableCount();
  }
  data() {}

  addEventListenersSearch() {}

  injectDataDom(data) {}

  search() {}

  tableCount() {
    const countHtml = document.getElementById("tab-count");
    const count = this.table.rows.length - 1;
    countHtml.textContent = count;
  }
}
