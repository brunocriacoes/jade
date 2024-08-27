import { getParam } from "../helper/helper.js";
import { requestHttp } from "../service/request.js";

export async function render() {
  let externalId = getParam("externalId");
  let code = getParam("code");
  let request = new requestHttp();

  const response = await request.post({
    name: "generateToken",
    data: {
      externalId,
      code,
    },
  });
}
