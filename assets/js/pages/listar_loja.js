import { blade, isActiveStatus } from "../helper/helper.js";
import { dataTable } from "../utils/dataTable.js";
import { requestHttp } from "../utils/request.js";
class lojaList extends dataTable {
  constructor(formElementId, searchElementId) {
    super(formElementId, searchElementId);
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
  }

  injectDataDom(data) {
    const containerElement = this.table.querySelector("tbody");
    const templateElement = document.getElementById("row-template");
    blade(data, templateElement, containerElement);
  }

  addEventListeners() {}

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
}

export function render() {
  new lojaList("table-loja", "search");
}
