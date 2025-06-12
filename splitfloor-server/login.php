<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login / Registration</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
   body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #6a11cb, #2575fc);
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.form-wrapper {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.2);
  padding: 30px 20px;
  width: 100%;
  max-width: 400px;
  animation: slideUp 0.6s ease-in-out;
}

@keyframes slideUp {
  0% { transform: translateY(20px); opacity: 0; }
  100% { transform: translateY(0); opacity: 1; }
}

.form-toggle {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.form-toggle button {
  flex: 1;
  padding: 10px;
  font-weight: bold;
  border: none;
  cursor: pointer;
  background-color: #f0f0f0;
  transition: background 0.3s;
}

.form-toggle .active {
  background-color: #2575fc;
  color: white;
}

.form {
  display: flex;
  flex-direction: column;
}

.input-group {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
  border-bottom: 1px solid #ccc;
  padding: 8px 0;
}

.input-group i {
  margin-right: 10px;
  color: #666;
}

.input-group input {
  border: none;
  outline: none;
  flex: 1;
  font-size: 16px;
}

.submit-btn {
  margin-top: 15px;
  background-color: #2575fc;
  color: white;
  padding: 12px;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  transition: background 0.3s;
}

.submit-btn:hover {
  background-color: #1d5ed2;
}

.hidden {
  display: none;
}

@media (max-width: 480px) {
  .form-wrapper {
    margin: 20px;
    padding: 20px 15px;
  }

  .input-group input {
    font-size: 14px;
  }

  .submit-btn {
    font-size: 15px;
  }
}

  </style>
</head>
<body>

<div class="form-wrapper">
  <div class="form-container">
    <div class="form-toggle">
      <button id="loginToggle" class="active">Login</button>
      <button id="registerToggle">Register</button>
    </div>

    <!-- Login Form -->
    <form id="loginForm" class="form animated-form">
      <h2>Welcome Back</h2>
      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" placeholder="Email" required />
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" placeholder="Password" required />
      </div>
      <button type="submit" class="submit-btn">Login</button>
    </form>

    <!-- Register Form -->
    <form id="registerForm" class="form animated-form hidden">
      <h2>Create Account</h2>
      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" placeholder="Full Name" required />
      </div>
      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" placeholder="Email" required />
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" placeholder="Password" required />
      </div>
      <button type="submit" class="submit-btn">Register</button>
    </form>
  </div>
</div>

<script>
  const loginBtn = document.getElementById('loginToggle');
  const registerBtn = document.getElementById('registerToggle');
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');

  loginBtn.onclick = () => {
    loginForm.classList.remove('hidden');
    registerForm.classList.add('hidden');
    loginBtn.classList.add('active');
    registerBtn.classList.remove('active');
  };

  registerBtn.onclick = () => {
    registerForm.classList.remove('hidden');
    loginForm.classList.add('hidden');
    registerBtn.classList.add('active');
    loginBtn.classList.remove('active');
  };
</script>
</body>
</html>
