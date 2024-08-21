import { blade } from "../helper/helper.js";
import { dataTable } from "../utils/dataTable.js";
import { requestHttp } from "../utils/request.js";

class webhookList extends dataTable {
  constructor(formElementId, searchElementId) {
    super(formElementId, searchElementId);
  }

  instanceRequest() {
    return new requestHttp();
  }

  async data() {
    const request = await this.getWebhooks();
    const dataFormatedValues = request.payload.map((store) => {
      const dateFormated = new Date(store.date).toLocaleString("pt-br");
      return {
        ...store,
        date: dateFormated.replace(",", "").replace(" ", " - "),
        value: store.value ? store.value : "-",
        origin: store.origin ? store.origin : "-",
        paymentKey: store.paymentKey ? store.paymentKey : "-",
        status: store.status ? "Ativo" : "Inativo",
        payload: btoa(store.payload),
      };
    });
    this.injectDataDom(dataFormatedValues);
  }

  injectDataDom(data) {
    const containerElement = this.table.querySelector("tbody");
    const templateElement = document.getElementById("row-template");
    blade(data, templateElement, containerElement);
  }

  addEventListeners() {}

  async getWebhooks() {
    const request = this.instanceRequest();
    const reponse = await request.get({
      name: "webhookList",
    });
    return reponse;
  }

  async deleteWebhook(id) {
    const request = this.instanceRequest();
    const reponse = await request.post({
      name: "webhookDelete",
      data: {
        publicId: id,
      },
    });
    return reponse;
  }
}

export function render() {
  new webhookList("table-webhook", "search");
}
