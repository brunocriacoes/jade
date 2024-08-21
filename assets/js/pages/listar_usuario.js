import { blade } from "../helper/helper.js";
import { dataTable } from "../utils/dataTable.js";
import { requestHttp } from "../utils/request.js";

class userList extends dataTable {
  constructor(formElementId, searchElementId, editElementId, deleteElementId) {
    super(formElementId, searchElementId, editElementId, deleteElementId);
  }

  instanceRequest() {
    return new requestHttp();
  }

  async data() {
    const request = await this.getUsers();
    this.injectDataDom(request.payload);
  }

  injectDataDom(data) {
    const containerElement = this.table.querySelector("tbody");
    const templateElement = document.getElementById("row-template");
    blade(data, templateElement, containerElement);
  }

  addEventListeners() {}

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
  new userList("table-user", "search", "edit-user", "delete-user");
}
