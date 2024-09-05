import { form } from "../utils/form.js";
import {
    debounce,
    feedback,
    loadBtn,
    to,
    getParam,
    validateFieldsEmpty,
} from "../helper/helper.js";
import { requestHttp } from "../service/request.js";

class AlterPass extends form {
    constructor(formElement) {
        document.querySelector(`[name="email"]`).value = getParam('email')
        document.querySelector(`[name="code"]`).value = getParam('codigo')
        super(formElement);
    }

    instanceRequest() {
        return new requestHttp();
    }

    async onSubmit(event) {
        event.preventDefault();
        const formData = new FormData(this.form);
        const loadButton = loadBtn(this.form.querySelector(".submit-btn"));
        const dataFields = Object.fromEntries(formData.entries());
        console.log(dataFields)
        if (!this.validate(dataFields)) {
            loadButton();
            return;
        }
        const request = await this.send(dataFields);
        if (!request.next) {
            feedback(this.form, request.message, false);
            loadButton();
            return;
        }
        feedback(this.form, request.message);
        debounce(() => {
            loadButton();
            to("login");
        }, 2000);
    }

    addEventListeners() {
        this.form.addEventListener("submit", this.onSubmit.bind(this));
    }

    validate(data) {
        if (!validateFieldsEmpty(data, this.form)) return false;
        return true;
    }

    async send(data) {
        const request = this.instanceRequest();
        const reponse = await request.post({
            name: "alterPass",
            data: data,
        });
        return reponse;
    }
}

export function render() {
    new AlterPass("recuperar-senha-form");
}
