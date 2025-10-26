
function flipForm() {
    const formContainer = document.getElementById('formContainer');
    formContainer.classList.toggle('flipped');
}

function togglePassword(icon) {
    const input = icon.previousElementSibling;
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = '🙈';
    } else {
        input.type = 'password';
        icon.textContent = '👁️';
    }
}

// Handle form submissions
document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const btn = document.getElementById('loginBtn');
    btn.classList.add('loading');

    // Simulate API call C:\xampp\htdocs\splitfloor\loginSignup.php
    setTimeout(() => {
        btn.classList.remove('loading');
        showSuccessMessage('Login successful! Welcome back!');
    }, 2000);
});

document.getElementById("signupForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const btn = document.getElementById("signupBtn");
    btn.classList.add("loading");

    fetch("loginSignup.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            btn.classList.remove("loading");
            if (data.status === "success") {

                alert(data.message)
                // showSuccessMessage();
                this.reset();
            } else {
                alert(data.message);
            }
        })
        .catch(() => {
            btn.classList.remove("loading");
            alert("Something went wrong!");
        });
});


function showSuccessMessage(message) {
    const activeForm = document.querySelector('.form-side:not([style*="transform"])') ||
        document.querySelector('.login-form');
    const existingMessage = activeForm.querySelector('.success-message');

    if (existingMessage) {
        existingMessage.remove();
    }

    const successDiv = document.createElement('div');
    successDiv.className = 'success-message';
    successDiv.textContent = message;

    const form = activeForm.querySelector('form');
    activeForm.insertBefore(successDiv, form);

    setTimeout(() => {
        successDiv.remove();
    }, 3000);
}

// Add input focus animations
document.querySelectorAll('.form-input').forEach(input => {
    input.addEventListener('focus', function () {
        this.parentElement.style.transform = 'translateY(-2px)';
    });

    input.addEventListener('blur', function () {
        this.parentElement.style.transform = 'translateY(0)';
    });
});

// Add floating animation to shapes on scroll/interaction
document.addEventListener('mousemove', function (e) {
    const shapes = document.querySelectorAll('.shape');
    shapes.forEach((shape, index) => {
        const speed = (index + 1) * 0.01;
        const x = e.clientX * speed;
        const y = e.clientY * speed;
        shape.style.transform = `translate(${x}px, ${y}px)`;
    });
});

// Keyboard navigation
document.addEventListener('keydown', function (e) {
    if (e.key === 'Tab') {
        const focusedElement = document.activeElement;
        if (focusedElement.classList.contains('form-input')) {
            focusedElement.style.borderColor = '#667eea';
        }
    }
});
/////////////////////////////////////

function parseJwt(token) {
    let base64Url = token.split('.')[1];
    let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    let jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
}

function handleGoogleResponse(response) {
    // Decode Google JWT
    const data = parseJwt(response.credential);

    // Send to backend
    fetch("loginSignup.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: "google_signup",
            full_name: data.name,
            email: data.email,
            provider_id: data.sub
        })
    })
    .then(res => res.json())
    .then(result => {
        if (result.status === "success") {
            alert("Welcome " + result.full_name);
            window.location.href = "dashboard.php";
        } else {
            alert(result.message);
        }
    })
    .catch(() => {
        alert("Google signup failed");
    });
}