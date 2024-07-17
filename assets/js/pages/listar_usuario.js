import { blade } from "../helper/helper.js";
import { dataTable } from "../utils/dataTable.js";

class userList extends dataTable {
  constructor(formElementId, searchElementId) {
    super(formElementId, searchElementId);
  }

  data() {
    const data = [
      {
        image: "https://www.gravatar.com/avatar/1",
        name: "John Doe",
        email: "johndoe@example.com",
        phone: "(123) 456-7890",
        status: "Active",
        role: "User",
      },
      {
        image: "https://www.gravatar.com/avatar/2",
        name: "Victor",
        email: "janedoe@example.com",
        phone: "(123) 456-7890",
        status: "Active",
        role: "User",
      },
    ];
    this.injectDataDom(data);
  }

  injectDataDom(data) {
    const templateElement = document.getElementById("row-template");
    const containerElement = this.table.querySelector("tbody");
    blade(data, templateElement, containerElement);
  }

  search(event) {
    const input = event.searchElement;
    const filter = input.value.trim().toUpperCase();
    const rows = event.table.querySelectorAll("tbody tr");
    rows.forEach((row) => {
      const cells = row.querySelectorAll("td");
      const match = Array.from(cells).some((cell) =>
        cell.textContent.trim().toUpperCase().includes(filter)
      );
      row.style.display = match ? "" : "none";
    });
  }

  addEventListenersSearch() {
    this.searchElement.addEventListener("keyup", (_) => this.search(this));
  }
}

export function render() {
  new userList("table-user", "search");
}
