
export function isPage(page) {
	var path = window.location.pathname;
	if (path === "/" || page === "index") return true;
	return path.endsWith(`${page}.html`);
}

export class App {
    add(page, fn) {
        if (isPage(page)) {
            fn();
        }
    }
}