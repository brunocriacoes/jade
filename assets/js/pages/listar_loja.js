import { blade, debounce, searchDataTable } from "../helper/helper.js";
import { dataTable } from "../utils/dataTable.js";

class userList extends dataTable {
  constructor(formElementId, searchElementId) {
    super(formElementId, searchElementId);
  }

  data() {
    const data = [
      {
        id: 1,
        status: true,
        name: "John Doe",
      },
      {
        id: 2,
        status: true,
        name: "Victor",
      },
      {
        id: 3,
        status: true,
        name: "Jane Doe2",
      },
      {
        id: 4,
        status: false,
        name: "Jane Doe3",
      },
      {
        id: 5,
        status: false,
        name: "Jane Doe3",
      },
      {
        id: 6,
        status: true,
        name: "Jane Doe3",
      },
    ];
    this.injectDataDom(
      data.map((item) => ({ ...item, status: item.status ? "checked" : "" }))
    );
  }

  injectDataDom(data) {
    const containerElement = this.table.querySelector("tbody");
    const templateElement = document.getElementById("row-template");
    blade(
      searchDataTable(data, this.searchElement.value),
      templateElement,
      containerElement
    );
  }

  addEventListeners() {
    this.searchElement.addEventListener("input", () => {
      debounce(() => {
        this.data();
        this.paginate();
        this.tableCount();
      }, 1000);
    });
  }
}

export function render() {
  new userList("table-loja", "search");
}
