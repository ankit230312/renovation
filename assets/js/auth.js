
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

// ==================== MANUAL LOGIN HANDLER ====================
function handleManualLogin(e) {
    e.preventDefault();
    
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    const btn = document.getElementById('loginBtn');
    
    btn.classList.add('loading');
    
    fetch('loginSignup.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'manual_login',
            email: email,
            password: password
        })
    })
        .then(res => res.json())
        .then(result => {
            btn.classList.remove('loading');
            if (result.status === 'success') {
                localStorage.setItem('user_name', result.full_name);
                localStorage.setItem('user_email', email);
                updateAccountDisplay(result.full_name);
                alert('Welcome ' + result.full_name);
                window.location.href = 'index.php';
            } else {
                alert(result.message);
            }
        })
        .catch(err => {
            btn.classList.remove('loading');
            alert('Login failed: ' + err);
        });
}

// ==================== MANUAL SIGNUP HANDLER ====================
function handleManualSignup(e) {
    e.preventDefault();
    
    const full_name = document.getElementById('signupFullName').value;
    const email = document.getElementById('signupEmail').value;
    const password = document.getElementById('signupPassword').value;
    const confirm_password = document.getElementById('confirmPassword').value;
    const btn = document.getElementById('signupBtn');
    
    btn.classList.add('loading');
    
    fetch('loginSignup.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'manual_signup',
            full_name: full_name,
            email: email,
            password: password,
            confirm_password: confirm_password
        })
    })
        .then(res => res.json())
        .then(result => {
            btn.classList.remove('loading');
            if (result.status === 'success') {
                localStorage.setItem('user_name', result.full_name);
                localStorage.setItem('user_email', email);
                updateAccountDisplay(result.full_name);
                alert('Account created successfully! Welcome ' + result.full_name);
                document.getElementById('signupForm').reset();
                // Redirect after 1 second
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 1000);
            } else {
                alert(result.message);
            }
        })
        .catch(err => {
            btn.classList.remove('loading');
            alert('Signup failed: ' + err);
        });
}


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
    let jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
}

// function handleGoogleResponse(response) {
//     // Decode Google JWT
//     const data = parseJwt(response.credential);

//     // Send to backend
//     fetch("loginSignup.php", {
//         method: "POST",
//         headers: { "Content-Type": "application/json" },
//         body: JSON.stringify({
//             action: "google_signup",
//             full_name: data.name,
//             email: data.email,
//             provider_id: data.sub
//         })
//     })
//     .then(res => res.json())
//     .then(result => {
//         if (result.status === "success") {
//             alert("Welcome " + result.full_name);
//             window.location.href = "index.php";
//         } else {
//             alert(result.message);
//         }
//     })
//     .catch(() => {
//         alert("Google signup failed");
//     });
// }

function handleGoogleResponse(response) {
    const data = parseJwt(response.credential);

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
                // Save user to session storage
               localStorage.setItem("user_name", result.full_name);
            localStorage.setItem("user_email", data.email);

                // Update account display
                updateAccountDisplay(result.full_name);

                alert("Welcome " + result.full_name);
                window.location.href = "index.php";
            } else {
                alert(result.message);
            }
        })
        .catch(() => {
            alert("Google signup failed");
        });
}



function updateAccountDisplay(name) {
    const greeting = document.getElementById("account-greeting");
    const link = document.getElementById("account-link");

    if (greeting && link) {
        greeting.textContent = "Hello, " + name.split(" ")[0]; // show first name only
        link.textContent = "Your Profile";
        link.href = "profile.php";
    }
}
