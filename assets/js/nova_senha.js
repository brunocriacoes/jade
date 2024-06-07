document.addEventListener("DOMContentLoaded", function () {
  var senha = document.getElementById("senha");
  var confirmarSenha = document.getElementById("confirmarSenha");
  var form = document.getElementById("novaSenhaForm");

  senha.addEventListener("input", validarSenha);
  confirmarSenha.addEventListener("input", validarSenha);
  form.addEventListener("submit", function (event) {
    if (!validarFormulario()) {
      event.preventDefault();
    }
  });
});

function validarSenha() {
  var senha = document.getElementById("senha").value;
  var confirmarSenha = document.getElementById("confirmarSenha").value;
  if (senha !== confirmarSenha) {
    document.querySelector(".alert-error").innerText =
      "As senhas não coincidem.";
    document.querySelector(".alert-error").style.display = "block";
    return false;
  }
  if (senha.length < 8) {
    document.querySelector(".alert-error").innerText =
      "A senha deve ter no mínimo 8 caracteres.";
    document.querySelector(".alert-error").style.display = "block";
    return false;
  }
  document.querySelector(".alert-error").style.display = "none";
}

function validarFormulario() {
  if (!validarSenha()) {
    return false;
  }
  document.querySelector(".alert-success").style.display = "block";
  return true;
}
