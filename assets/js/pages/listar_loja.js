import { blade, isActiveStatus } from "../helper/helper.js";
import { dataTable } from "../utils/dataTable.js";
import { requestHttp } from "../utils/request.js";
class lojaList extends dataTable {
  constructor(
    formElementId,
    searchElementId,
    editElementId,
    deleteElementId,
    editStatusElement
  ) {
    super(formElementId, searchElementId, editElementId, deleteElementId);
    this.editStatusElement = editStatusElement;
  }

  instanceRequest() {
    return new requestHttp();
  }

  async data() {
    const request = await this.getStores();
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
    this.eventUpdate();
  }

  eventDelete() {
    const elements = document.querySelectorAll(this.deleteElement);
    const deleteUs = this.deleteStore.bind(this);
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

  eventUpdate() {
    const elements = document.querySelectorAll(this.editStatusElement);
    const updateStatus = this.updateStatusStore.bind(this);
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

  async getStores() {
    const request = this.instanceRequest();
    const reponse = await request.get({
      name: "storeList",
    });
    return reponse;
  }

  async deleteStore(id) {
    const request = this.instanceRequest();
    const reponse = await request.post({
      name: "storeDelete",
      data: {
        publicId: id,
      },
    });
    return reponse;
  }

  async updateStatusStore(data) {
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
