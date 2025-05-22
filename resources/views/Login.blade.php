<!-- filepath: d:\ketabi\resources\views\Login.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>تسجيل الدخول</title>
  <meta thhp-equiv="X-UA-Compatible" content="IE-chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Tajawal', sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 0;
    }

    .auth-container {
      background-image: url('https://readdy.ai/api/search-image?query=modern%20digital%20library&width=1200&height=800&orientation=landscape');
      background-size: cover;
      background-position: center;
      padding: 60px 20px;
      margin-top: 70px;
    }

    .form-container {
      max-width: 500px;
      height: 500px;;
      margin: auto;
      background-color: rgba(255, 255, 255, 0.85);
      padding: 30px;
      border-radius: 16px;
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      text-align: right;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }

    input, select {
      width: 100%;
      height: 50px;
      border-radius: 8px;
      padding: 0 10px;
      border: 1px solid #ccc;
      margin-bottom: 15px;
      font-size: 14px;
      background-color: #f4f4f4;
      margin-top: 10px;
    }

    button {
      width: 100%;
      height: 50px;
      background-color: #30382F;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-top: 40px;
    }

    button:hover {
      background-color: #2a3129;
    }

    .header-text {
      text-align: center;
      color: #1e40af;
      margin-bottom: 10px;
      font-family: Georgia, 'Times New Roman', Times, serif;

    }


    .auth-container{
      position: relative;
      top: -60px;
    }
    .text-fon{
      text-align: center;
    }
    input{
      border: 0px;
    }
    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      margin-bottom: -90px;

    }

    .login-message {
      text-align: center;
      margin: 10px 0;
      font-size: 16px;
    }
  </style>

</head>
<body>

         <div class="logo-container">
          <img src="../image/20250429_000806(2).png" alt="لوجو " style="width: 300px;height:auto;">
          </div>
         <div class="header-text">

          <h2 style="color: #30382F;">مرحباً بك في كتابي</h2>
          <p style="color: #2a3129;">اكتشف عالماً من المعرفة بين يديك</p>

        </div>
  <div class="auth-container">
    <div class="form-container">
      <div class="text-fon">
        <h1>تسجيل الدخول</h1>

      </div>

      <form id="loginForm">
        <p style="color: #2a3129; text-align: center;">مرحباً بك مجدداً </p><br>
        <label for="email">البريد الإلكتروني</label>
        <input type="email" id="email" placeholder="أدخل بريدك الإلكتروني" required>

        <label for="password">كلمة المرور</label>
        <input type="password" id="password" placeholder="أدخل كلمة المرور" required>

        <div id="loginMessage" class="login-message"></div>

        <button type="submit" style="background-color: #4F46E5;">تسجيل الدخول</button>

        <div class="note" style="margin-top: 30px; text-align: center;">
          ليس لديك حساب؟ <a href="{{ route('register.form') }}">إنشاء حساب جديد</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
      event.preventDefault();

      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const messageDiv = document.getElementById('loginMessage');
      messageDiv.textContent = '';
      messageDiv.style.color = '';

      fetch('/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email: email, password: password })
      })
      .then(async response => {
        let data;
        try {
          data = await response.json();
        } catch {
          data = {};
        }
        if (data.token) {
          messageDiv.textContent = "تم تسجيل الدخول بنجاح!";
          messageDiv.style.color = "green";
          localStorage.setItem('authToken', data.token);
          setTimeout(() => {
            window.location.href = '{{ route('home') }}';
          }, 1200);
        } else if (response.status === 403) {
          messageDiv.textContent = data.message || "حسابك غير مفعل أو قيد المراجعة.";
          messageDiv.style.color = "red";
        } else if (response.status === 401) {
          messageDiv.textContent = data.message || "بيانات الدخول غير صحيحة.";
          messageDiv.style.color = "red";
        } else {
          messageDiv.textContent = "حدث خطأ أثناء تسجيل الدخول.";
          messageDiv.style.color = "red";
        }
      })
      .catch(error => {
        messageDiv.textContent = "حدث خطأ أثناء تسجيل الدخول.";
        messageDiv.style.color = "red";
      });
    });
  </script>

</body>
</html>
