export class dataTable {
  constructor(tableElementId, searchElementId, editElementId, deleteElementId) {
    this.table = document.getElementById(tableElementId);
    this.searchElement = document.getElementById(searchElementId);
    this.editElement = document.getElementById(editElementId);
    this.deleteElement = document.getElementById(deleteElementId);
    this.data();
    this.addEventListeners();
    this.tableCount();
    this.paginate();
  }

  data() {}

  addEventListeners() {}

  injectDataDom(data) {}

  tableCount() {
    const countHtml = document.getElementById("tab-count");
    const count = this.table.rows.length - 1;
    countHtml.textContent = count;
  }

  showPage(rows, rowsPerPage, page) {
    const pageInfo = document.getElementById("page-info");
    let start = (page - 1) * rowsPerPage;
    let end = start + rowsPerPage;
    rows.forEach((row, index) => {
      row.style.display = index >= start && index < end ? "" : "none";
    });
    pageInfo.textContent = `Página ${page} de ${Math.ceil(
      rows.length / rowsPerPage
    )}`;
  }

  paginate() {
    const rows = this.table.querySelectorAll("tbody tr");
    const rowsPerPage = 2;
    const pages = Math.ceil(rows.length / rowsPerPage);
    let currentPage = 1;
    const prev = document.getElementById("prev-section-table");
    const next = document.getElementById("next-section-table");

    prev.addEventListener("click", () => {
      currentPage = currentPage > 1 ? currentPage - 1 : 1;
      this.showPage(rows, rowsPerPage, currentPage);
    });
    next.addEventListener("click", () => {
      currentPage = currentPage < pages ? currentPage + 1 : pages;
      this.showPage(rows, rowsPerPage, currentPage);
    });
    this.showPage(rows, rowsPerPage, currentPage);
  }
}
