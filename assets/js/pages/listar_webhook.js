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
        data: "2021-06-01",
        status: "PENDING",
        origem: "ASAAS",
        valor: "R$ 100,00",
        key: "00000000100000100010010",
      },
      {
        id: 2,
        data: "2021-06-01",
        status: "PENDING",
        origem: "ASAAS",
        valor: "R$ 100,00",
        key: "00000000100000100010010",
      },
      {
        id: 3,
        data: "2021-06-01",
        status: "PENDING",
        origem: "ASAAS",
        valor: "R$ 100,00",
        key: "00000000100000100010010",
      },
      {
        id: 4,
        data: "2021-06-01",
        status: "PENDING",
        origem: "ASAAS",
        valor: "R$ 100,00",
        key: "00000000100000100010010",
      },
      {
        id: 5,
        data: "2021-06-01",
        status: "PENDING",
        origem: "ASAAS",
        valor: "R$ 100,00",
        key: "00000000100000100010010",
      },
      {
        id: 6,
        data: "2021-06-01",
        status: "PENDING",
        origem: "ASAAS",
        valor: "R$ 140,00",
        key: "00000000100000100010010",
      },
    ];
    this.injectDataDom(data);
  }

  injectDataDom(data) {
    const containerElement = this.table.querySelector("tbody");
    const templateElement = document.getElementById("row-template");
    blade(data, templateElement, containerElement);
  }

  addEventListeners() {}
}

export function render() {
  new userList("table-webhook", "search");
}
