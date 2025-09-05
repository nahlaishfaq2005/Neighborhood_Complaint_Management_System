// Form submission validation
document.getElementById("signupForm").onsubmit = function(e) {
    let valid = true;

    // Clear all previous error messages
    document.querySelectorAll("span.error").forEach(el => el.innerText = "");

    // Get form values
    const fullname = document.getElementById("fullname").value.trim();
    const address = document.getElementById("address").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const email = document.getElementById("email").value.trim();
    const dob = document.getElementById("dob").value;
    const password = document.getElementById("password").value;
    const confirm = document.getElementById("confirm").value;

    // Full name and address validation
    if (fullname.length === 0) {
        document.getElementById("fullname").nextElementSibling.innerText = "Full name is required!";
        valid = false;
    }

    if (address.length === 0) {
        document.getElementById("address").nextElementSibling.innerText = "Address is required!";
        valid = false;
    }

    // Phone validation
    const phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone)) {
        document.getElementById("phone").nextElementSibling.innerText = "Enter a valid 10-digit phone number!";
        valid = false;
    }

    // Email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        document.getElementById("email").nextElementSibling.innerText = "Please enter a valid email!";
        valid = false;
    }

    // DOB / Age validation
    if (dob) {
        const birthDate = new Date(dob);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        if (age < 18) {
            document.getElementById("dob").nextElementSibling.innerText = "You must be at least 18 years old!";
            valid = false;
        }
        if (age > 120) {
            document.getElementById("dob").nextElementSibling.innerText = "Please enter a realistic birthday!";
            valid = false;
        }
    } else {
        document.getElementById("dob").nextElementSibling.innerText = "Please enter your date of birth!";
        valid = false;
    }

    // Password validation
    if (password.length < 3) {
        document.getElementById("password").nextElementSibling.innerText = "Password must be at least 3 characters!";
        valid = false;
    }

    if (password !== confirm) {
        document.getElementById("confirm").nextElementSibling.innerText = "Passwords do not match!";
        valid = false;
    }

    if (!valid) e.preventDefault(); // Stop form submission if validation fails
};
