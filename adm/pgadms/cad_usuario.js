function abrirFormulario() {
    document.getElementById("formularioCadastro").style.display = "block";
}

function fecharFormulario() {
    document.getElementById("formularioCadastro").style.display = "none";
    document.getElementById("formCadastro").reset();
}

function validarFormulario() {
    const senha = document.getElementById("senha").value;
    const confirmarSenha = document.getElementById("confirmarSenha").value;

    if (senha !== confirmarSenha) {
        alert("As senhas não coincidem.");
        return false;
    }

    alert("Usuário cadastrado com sucesso!");
    fecharFormulario();
    return false; // evita envio real do formulário
}
