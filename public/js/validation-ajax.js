document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form[x-data]");
  if (!form) return;

  function showGlobalError(msg) {
    let alert = document.querySelector(".login-global-error");
    if (!alert) {
      alert = document.createElement("div");
      alert.className = "alert alert-danger login-global-error";
      form.parentNode.insertBefore(alert, form);
    }
    alert.textContent = msg;
    alert.style.display = msg ? "block" : "none";
  }

  function clearGlobalError() {
    let alert = document.querySelector(".login-global-error");
    if (alert) alert.style.display = "none";
  }

  function showFieldError(field, msg) {
    if (!field) return;
    field.classList.toggle('is-invalid', !!msg);
    let feedback = field.parentNode.parentNode.querySelector('.invalid-feedback');
    if (feedback) {
      feedback.textContent = msg || '';
      feedback.style.display = msg ? "block" : "none";
    }
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    clearGlobalError();
    // Récupère les champs par leur attribut name ou x-model
    let username = form.querySelector('[x-model="form.username"]') || form.querySelector('[name="nom"]');
    let email = form.querySelector('[x-model="form.email"]') || form.querySelector('[name="email"]');
    let valid = true;
    showFieldError(username, '');
    showFieldError(email, '');
    if (!username || !username.value.trim()) {
      showFieldError(username, 'Nom d\'utilisateur requis');
      valid = false;
    }
    if (!email || !email.value.trim()) {
      showFieldError(email, 'Email requis');
      valid = false;
    }
    if (!valid) {
      showGlobalError("Veuillez remplir tous les champs !");
      return;
    }
    
    // Si validation réussie, soumission normale du formulaire
    form.submit();
  });
});
