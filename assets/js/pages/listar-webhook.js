
export function render() {
    const closeDialogBtn = document.getElementById("close-dialog-btn");
    const webhookTableBody = document.querySelector(".webhook-table-body");
    const webhookDialog = document.getElementById("webhook-dialog");
    const webhookDetails = document.getElementById("webhook-details");
    webhookTableBody.addEventListener("click", (event) => {
        if (event.target.classList.contains("visualizar-btn")) {
            const webhookData = JSON.parse(event.target.getAttribute("data-webhook"));
            webhookDetails.textContent = JSON.stringify(webhookData, null, 2);
            webhookDialog.showModal();
        }
    });
    closeDialogBtn.addEventListener("click", () => {
        webhookDialog.setAttribute("closing", "");
        webhookDialog.addEventListener(
            "animationend",
            () => {
                webhookDialog.removeAttribute("closing");
                webhookDialog.close();
            },
            { once: true }
        );
    });
}