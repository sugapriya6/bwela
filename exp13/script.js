function validateForm(event) {
  event.preventDefault();

  const name = document.getElementById("na").value;
  const rollNo = document.getElementById("nu").value;
  const course = document.getElementById("co").value;
  const age = parseInt(document.getElementById("ag").value);
  const dob = document.getElementById("dob").value;
  const email = document.getElementById("em").value;
  const password = document.getElementById("ps").value;
  const phoneNumber = document.getElementById("num").value;
  const gender = document.getElementById("gen").value;
  const place = document.getElementById("pl").value;
  const terms = document.getElementById("cb").checked;

  if (name === "") {
    alert("Name is required.");
    return false;
  }
  if (rollNo === "") {
    alert("Roll number is required.");
    return false;
  }
  if (course === "") {
    alert("Please select a course.");
    return false;
  }

  if (isNaN(age) || age < 18 || age > 45) {
    alert("Age must be between 18 and 45.");
    return false;
  }

  if (dob === "") {
    alert("Date of Birth is required.");
    return false;
  }

  if (email === "" || !email.includes("@")) {
    alert("Please enter a valid email address.");
    return false;
  }

  if (password === "") {
    alert("Password is required.");
    return false;
  }

  if (phoneNumber === "") {
    alert("Phone number is required.");
    return false;
  }
  if (isNaN(phoneNumber)) {
    alert("Phone number must be numeric.");
    return false;
  }
  if (phoneNumber.length !== 10) {
    alert("Phone number must be exactly 10 digits.");
    return false;
  }

  if (gender === "") {
    alert("Gender is required.");
    return false;
  }

  if (place === "") {
    alert("Place is required.");
    return false;
  }

  if (!terms) {
    alert("You must agree to the terms and conditions.");
    return false;
  }

  alert("Form submitted successfully!");
  return true;
}
document
  .getElementById("registrationForm")
  .addEventListener("submit", validateForm);
