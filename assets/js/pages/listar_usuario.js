import { blade, formatPhone, isActiveStatus } from "../helper/helper.js";
import { dataTable } from "../utils/dataTable.js";
import { requestHttp } from "../service/request.js";

class UserList extends dataTable {
  constructor(formElement, searchElement, editElement, deleteElement) {
    super(formElement, searchElement, editElement, deleteElement);
    this.apiRoutes = {
      list: "userList",
      delete: "userDelete",
    };
  }

  instanceRequest() {
    return new requestHttp();
  }

  async fetchData() {
    const response = await this.getUsers();
    this.renderData(
      response.payload.map((item) => ({
        ...item,
        status: isActiveStatus(item.status) ? "Ativo" : "Inativo",
        phone: formatPhone(item.phone),
      }))
    );
    this.addEventListeners();
  }

  renderData(data) {
    const containerElement = this.table.querySelector("tbody");
    const templateElement = document.getElementById("row-template");
    blade(data, templateElement, containerElement);
  }

  addEventListeners() {
    this.handleDeleteEvent();
    this.handleRedirectToUpdateEvent();
  }

  handleDeleteEvent() {
    this.addEventToElements(this.deleteElement, async (element) => {
      const id = element.getAttribute("data-id");
      const confirmDeletion = window.confirm("Tem certeza que deseja deletar este item?");
      if(!confirmDeletion){
        return null;
      }
      const response = await this.deleteUser(id);
      if (response.next) this.fetchData();
    });
  }

  handleRedirectToUpdateEvent() {
    this.addEventToElements(this.editElement, (element) => {
      const id = element.getAttribute("data-id");
      window.location.href = `form_usuario.html?id=${id}`;
    });
  }

  addEventToElements(selector, callback, eventType = "click") {
    const elements = document.querySelectorAll(selector);
    elements.forEach((element) => {
      element.addEventListener(eventType, async (event) => {
        event.preventDefault();
        await callback(element);
      });
    });
  }

  async getUsers() {
    const request = this.instanceRequest();
    return await request.get({ name: this.apiRoutes.list });
  }

  async deleteUser(id) {
    const request = this.instanceRequest();
    return await request.post({
      name: this.apiRoutes.delete,
      data: { publicId: id },
    });
  }
}

export function render() {
  const userList = new UserList(
    "table-user",
    "search",
    ".edit-user",
    ".delete-user"
  );
  userList.fetchData();
}
