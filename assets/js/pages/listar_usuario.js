import { blade, isActiveStatus } from "../helper/helper.js";
import { dataTable } from "../utils/dataTable.js";
import { requestHttp } from "../service/request.js";

class userList extends dataTable {
  constructor(formElement, searchElement, editElement, deleteElement) {
    super(formElement, searchElement, editElement, deleteElement);
  }

  instanceRequest() {
    return new requestHttp();
  }

  async data() {
    const request = await this.getUsers();
    this.injectDataDom(
      request.payload.map((item) => {
        return {
          ...item,
          status: isActiveStatus(item.status) ? "Ativo" : "Inativo",
        };
      })
    );
    this.addEventListeners();
  }

  injectDataDom(data) {
    const containerElement = this.table.querySelector("tbody");
    const templateElement = document.getElementById("row-template");
    blade(data, templateElement, containerElement);
  }

  addEventListeners() {
    const elements = document.querySelectorAll(this.deleteElement);
    const deleteUs = this.deleteUser.bind(this);
    const data = this.data.bind(this);
    elements.forEach((element) => {
      element.addEventListener("click", async function (event) {
        event.preventDefault();
        const id = this.getAttribute("data-id");
        const response = await deleteUs(id);
        if (response.next) {
          data();
        }
      });
    });
  }
  async getUsers() {
    const request = this.instanceRequest();
    const reponse = await request.get({
      name: "userList",
    });
    return reponse;
  }

  async deleteUser(id) {
    const request = this.instanceRequest();
    const reponse = await request.post({
      name: "userDelete",
      data: {
        publicId: id,
      },
    });
    return reponse;
  }
}

export function render() {
  new userList("table-user", "search", "edit-user", ".delete-user");
}
