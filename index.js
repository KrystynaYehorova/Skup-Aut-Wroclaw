function validateForm() {
  const form = document.getElementById("skupAutForm");
  const requiredFields = form.querySelectorAll("[required]");

  for (let field of requiredFields) {
    if (!field.value) {
      alert("Wypełnij wszystkie wymagane pola!");
      return false;
    }
  }

  return true;
}
function submitForm(event) {
  event.preventDefault(); // Zapobiega domyślnej akcji wysyłania formularza

  if (validateForm()) {
    // Wyślij formularz tylko jeśli walidacja zakończyła się powodzeniem
    const form = document.getElementById("skupAutForm");
    form.submit();
  }
}

function validateForm() {
  const form = document.getElementById("zlomAut");
  const requiredFields = form.querySelectorAll("[required]");

  for (let field of requiredFields) {
    if (!field.value) {
      alert("Wypełnij wszystkie wymagane pola!");
      return false;
    }
  }

  return true;
}
function submitForm(event) {
  event.preventDefault(); // Zapobiega domyślnej akcji wysyłania formularza

  if (validateForm()) {
    // Wyślij formularz tylko jeśli walidacja zakończyła się powodzeniem
    const form = document.getElementById("zlomAut");
    form.submit();
  }
}
