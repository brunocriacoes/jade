import { blade, searchDataTable } from "../helper/helper.js";
import { dataTable } from "../utils/dataTable.js";

class userList extends dataTable {
  constructor(formElementId, searchElementId) {
    super(formElementId, searchElementId);
  }

  data() {
    const data = [
      {
        id: 1,
        image: "https://www.gravatar.com/avatar/1",
        name: "John Doe",
        email: "johndoe@example.com",
        phone: "(123) 456-7890",
        status: "Active",
        role: "User",
      },
      {
        id: 2,
        image: "https://www.gravatar.com/avatar/2",
        name: "Victor",
        email: "janedoe@example.com",
        phone: "(123) 456-7890",
        status: "Active",
        role: "User",
      },
      {
        id: 3,
        image: "https://www.gravatar.com/avatar/3",
        name: "Jane Doe2",
        email: "janedoe@example.com",
        phone: "(123) 456-7890",
        status: "Active",
        role: "User",
      },
      {
        id: 4,
        image: "https://www.gravatar.com/avatar/4",
        name: "Jane Doe3",
        email: "janedoe@example.com",
        phone: "(123) 456-7890",
        status: "Active",
        role: "User",
      },
    ];
    this.injectDataDom(data);
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
      setTimeout(() => {
        this.data();
        this.paginate();
        this.tableCount();
      }, 1000);
    });
  }
}

export function render() {
  new userList("table-user", "search");
}
