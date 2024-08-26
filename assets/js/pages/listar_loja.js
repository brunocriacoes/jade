import { blade, isActiveStatus } from "../helper/helper.js";
import { dataTable } from "../utils/dataTable.js";
import { requestHttp } from "../service/request.js";

class LojaList extends dataTable {
  constructor(
    formElement,
    searchElement,
    editElement,
    deleteElement,
    editStatusElement
  ) {
    super(formElement, searchElement, editElement, deleteElement);
    this.editStatusElement = editStatusElement;
    this.apiRoutes = {
      list: "storeList",
      delete: "storeDelete",
      updateStatus: "storeStatus",
    };
  }

  instanceRequest() {
    return new requestHttp();
  }

  async fetchData() {
    const response = await this.getList();
    this.renderData(
      response.payload.map((item) => ({
        ...item,
        status: isActiveStatus(item.status) ? "checked" : "",
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
    this.handleUpdateStatusEvent();
    this.handleRedirectToUpdateEvent();
  }

  handleDeleteEvent() {
    this.addEventToElements(this.deleteElement, async (element) => {
      const id = element.getAttribute("data-id");
      const response = await this.deleteItem(id);
      if (response.next) this.fetchData();
    });
  }

  handleUpdateStatusEvent() {
    this.addEventToElements(
      this.editStatusElement,
      async (element) => {
        const id = element.getAttribute("data-id");
        const status = element.checked ? "ACTIVE" : "INACTIVE";
        const response = await this.updateStatus({ publicId: id, status });
        if (response.next) setTimeout(() => this.fetchData(), 1000);
      },
      "change"
    );
  }

  handleRedirectToUpdateEvent() {
    this.addEventToElements(this.editElement, (element) => {
      const id = element.getAttribute("data-id");
      window.location.href = `form_loja.html?id=${id}`;
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

  async getList() {
    const request = this.instanceRequest();
    return await request.get({ name: this.apiRoutes.list });
  }

  async deleteItem(id) {
    const request = this.instanceRequest();
    return await request.post({
      name: this.apiRoutes.delete,
      data: { publicId: id },
    });
  }

  async updateStatus(data) {
    const request = this.instanceRequest();
    return await request.post({
      name: this.apiRoutes.updateStatus,
      data: data,
    });
  }
}

export function render() {
  const lojaList = new LojaList(
    "table-loja",
    "search",
    ".edit-loja",
    ".delete-loja",
    ".status-loja"
  );
  lojaList.fetchData();
}
