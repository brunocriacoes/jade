import { blade, isActiveStatus } from "../helper/helper.js";
import { dataTable } from "../utils/dataTable.js";
import { requestHttp } from "../service/request.js";
class lojaList extends dataTable {
  constructor(
    formElement,
    searchElement,
    editElement,
    deleteElement,
    editStatusElement
  ) {
    super(formElement, searchElement, editElement, deleteElement);
    this.editStatusElement = editStatusElement;
  }

  instanceRequest() {
    return new requestHttp();
  }

  async data() {
    const request = await this.get();
    this.injectDataDom(
      request.payload.map((item) => {
        return {
          ...item,
          status: isActiveStatus(item.status) ? "checked" : "",
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
    this.eventDelete();
    this.eventUpdateStatus();
    this.eventRedirectToUpdate();
  }

  eventDelete() {
    const elements = document.querySelectorAll(this.deleteElement);
    const deleteUs = this.delete.bind(this);
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

  eventUpdateStatus() {
    const elements = document.querySelectorAll(this.editStatusElement);
    const updateStatus = this.updateStatus.bind(this);
    const data = this.data.bind(this);
    elements.forEach((element) => {
      element.addEventListener("change", async function (event) {
        event.preventDefault();
        const id = this.getAttribute("data-id");
        const status = this.checked;
        const response = await updateStatus({
          publicId: id,
          status: status ? "ACTIVE" : "INACTIVE",
        });
        if (response.next) {
          setTimeout(() => {
            data();
          }, 1000);
        }
      });
    });
  }

  eventRedirectToUpdate() {
    const elements = document.querySelectorAll(this.editElement);
    const updateStatus = this.updateStatus.bind(this);
    const data = this.data.bind(this);
    elements.forEach((element) => {
      element.addEventListener("click", async function (event) {
        event.preventDefault();
        const id = this.getAttribute("data-id");
        window.location.href = `cadastro_loja.html?id=${id}`;
      });
    });
  }

  async get() {
    const request = this.instanceRequest();
    const typeRoute = "storeList";
    const reponse = await request.get({
      name: typeRoute,
    });
    return reponse;
  }

  async delete(id) {
    const request = this.instanceRequest();
    const reponse = await request.post({
      name: "storeDelete",
      data: {
        publicId: id,
      },
    });
    return reponse;
  }

  async updateStatus(data) {
    const request = this.instanceRequest();
    const reponse = await request.post({
      name: "storeStatus",
      data: data,
    });
    return reponse;
  }
}

export function render() {
  new lojaList(
    "table-loja",
    "search",
    ".edit-loja",
    ".delete-loja",
    ".status-loja"
  );
}
