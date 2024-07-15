var timerId;

export function debounce(func, delay = 3000) {
  clearTimeout(timerId);
  timerId = setTimeout(() => {
    func();
  }, delay);
}

export function loadBtn($btn) {
  var icoOld = $btn.querySelector("i").getAttribute("class");
  var ico = "fa-solid fa-spinner spliner";
  var textOld = "";
  var text = "Aguarde...";
  var span = $btn.querySelector("span");
  var strong = $btn.querySelector("strong");
  if (span) {
    textOld = span.innerHTML;
    span.innerHTML = text;
  }
  if (strong) {
    textOld = strong.innerHTML;
    strong.innerHTML = text;
  }
  $btn.querySelector("i").setAttribute("class", ico);
  return function old() {
    if (span) {
      span.innerHTML = textOld;
    }
    if (strong) {
      strong.innerHTML = textOld;
    }
    $btn.querySelector("i").setAttribute("class", icoOld);
  };
}

export function feedback($elemento, mensagem, status = true) {
  var $alerta = document.createElement("span");
  $alerta.textContent = mensagem;
  $alerta.classList.add("alert");
  if (status) {
    $alerta.classList.add("alert__sucesso");
  } else {
    $alerta.classList.add("alert__error");
  }
  $alerta.onclick = function () {
    this.parentNode.removeChild(this);
  };
  $elemento.appendChild($alerta);
  setTimeout(function () {
    $alerta.parentNode.removeChild($alerta);
  }, 3000);
}

export function to(path) {
  window.location.href = `/${path}.html`;
}

export function blade(data, templateElement, containerElement) {
  var template = templateElement.innerHTML;
  containerElement.innerHTML = "";
  data.forEach((item) => {
    var itemHtml = template;
    for (var key in item) {
      itemHtml = itemHtml.replace(
        new RegExp(`\\$\\{${key}\\}`, "g"),
        item[key]
      );
    }
    containerElement.innerHTML += itemHtml;
  });
}

export function getParam(name) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(name);
}
