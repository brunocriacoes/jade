import { url_base_api } from "../helper/helper.js";

export class requestHttp {
  constructor() {
    this.routes = [
      {
        name: "login",
        method: "POST",
        url: "/login",
      },
      {
        name: "storeList",
        method: "GET",
        url: "/store/list?page=1&itemsPerPage=100",
      },
      {
        name: "storeRegister",
        method: "POST",
        url: "/store/register",
      },
      {
        name: "storeUpdate",
        method: "POST",
        url: "/store/update",
      },
      {
        name: "storeStatus",
        method: "POST",
        url: "/store/status",
      },
      {
        name: "storeDelete",
        method: "POST",
        url: "/store/delete",
      },
      {
        name: "storeInfo",
        method: "GET",
        url: "/store/info?publicId=",
      },
      {
        name: "userCreate",
        method: "POST",
        url: "/user/create",
      },
      {
        name: "userList",
        method: "GET",
        url: "/user/list?page=1&itemsPerPage=100",
      },
      {
        name: "userUpdate",
        method: "POST",
        url: "/user/update",
      },
      {
        name: "userUpdatePass",
        method: "POST",
        url: "/user/update/pass",
      },
      {
        name: "userDelete",
        method: "POST",
        url: "/user/delete",
      },
      {
        name: "webhookCreate",
        method: "POST",
        url: "/webhook/create/",
      },
      {
        name: "webhookList",
        method: "GET",
        url: "/webhook/list?page=1&itemsPerPage=100",
      },
      {
        name: "recoverPass",
        method: "POST",
        url: "/recover/pass",
      },
      {
        name: "alterPass",
        method: "POST",
        url: "/alter/pass",
      },
    ];
  }

  getRoute(name) {
    return this.routes.find((route) => route.name === name);
  }

  async get({ name, params }) {
    const route = this.getRoute(name);
    const param = params ? params : "";
    try {
      const request = await fetch(url_base_api() + route.url + param, {
        method: route.method,
        headers: {
          "Content-Type": "application/json",
        },
      });
      const response = await request.json();
      return response;
    } catch (error) {
      return {
        next: false,
        message: "Erro ao processar a requisição",
        payload: [],
      };
    }
  }

  async post({ name, data }) {
    const route = this.getRoute(name);
    try {
      const request = await fetch(url_base_api() + route.url, {
        method: route.method,
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      });
      const response = await request.json();
      return response;
    } catch (error) {
      return {
        next: false,
        message: "Erro ao processar a requisição",
        payload: [],
      };
    }
  }
}
