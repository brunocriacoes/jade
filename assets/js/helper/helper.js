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
  var template = templateElement.innerHTML || "";
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

export function validateEmail(email) {
  var re = /\S+@\S+\.\S+/;
  return re.test(email);
}

export function getFormData(form) {
  const formData = new FormData(form);
  return Object.fromEntries(formData.entries());
}

export function getFormErrors(form, rules) {
  const data = getFormData(form);
  return validate(data, rules);
}

export function setFormErrors(form, errors) {
  for (var key in errors) {
    var $input = form.querySelector(`[name=${key}]`);
    var $error = form.querySelector(`[data-error-for=${key}]`);
    $input.classList.add("error");
    $error.textContent = errors[key];
  }
}

export function clearFormErrors(form) {
  var $inputs = form.querySelectorAll("input");
  $inputs.forEach(($input) => {
    $input.classList.remove("error");
  });
  var $errors = form.querySelectorAll("[data-error-for]");
  $errors.forEach(($error) => {
    $error.textContent = "";
  });
}

export function clearForm(form) {
  var $inputs = form.querySelectorAll("input");
  $inputs.forEach(($input) => {
    $input.value = "";
  });
}

export function setFormData(form, data) {
  for (var key in data) {
    var $input = form.querySelector(`[name=${key}]`);
    $input.value = data[key];
  }
}

export function searchDataTable(data, searchValue) {
  return (
    data?.filter((item) => {
      if (!searchValue) return true;
      return Object.values(item).some((value) => {
        return value
          .toString()
          .toLowerCase()
          .includes(searchValue.toLowerCase());
      });
    }) || []
  );
}
