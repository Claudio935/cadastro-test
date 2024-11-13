function submitFormCadastro() {
    const formData = new FormData(document.getElementById("loginForm"));
    fetch("http://localhost/cadastro.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const messageDiv = document.getElementById("responseMessage");
        if (data.status === "success") {
            messageDiv.style.color = "green";
            messageDiv.textContent = data.message;
            document.cookie = `token=${data.token}; path=/;`;
        } else {
            messageDiv.style.color = "red";
            messageDiv.textContent = data.message;
        }
    })
    .catch(error => console.error("Erro:", error));
}

function submitFormLogin() {
    const formData = new FormData(document.getElementById("loginForm"));
    fetch("http://localhost/login.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const messageDiv = document.getElementById("responseMessage");
        if (data.status === "success") {
            messageDiv.style.color = "green";
            messageDiv.textContent = data.message;
            document.cookie = `token=${data.token}; path=/;`;
        } else {
            messageDiv.style.color = "red";
            messageDiv.textContent = data.message;
        }
    })
    .catch(error => console.error("Erro:", error));
}