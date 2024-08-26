import {getParam} from "../helper/helper.js";
import { requestHttp } from "../utils/request.js";

export async function render(){
    let externalId = getParam('externalId')
    let code = getParam('code')
    console.log(externalId);
    console.log(code);

    let request = new requestHttp();

    const response = await request.post({
        name: "generateToken",
        data: {
            externalId,
            code
        }
      });
    console.log(response);
}