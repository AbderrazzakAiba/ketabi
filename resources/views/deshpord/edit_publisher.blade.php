<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>تعديل دار نشر</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Tajawal', sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 0;
    }
    .auth-container {
      background-image: url('https://readdy.ai/api/search-image?query=A%20modern%20digital%20library%20with%20a%20clean%2C%20minimalist%20design.&width=1200&height=800&orientation=landscape');
      background-size: cover;
      background-position: center;
      padding: 60px 20px;
    }
    .form-container {
      max-width: 700px;
      margin: auto;
      background-color: rgba(255, 255, 255, 0.85);
      padding: 30px;
      border-radius: 16px;
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      text-align: right;
    }
    .header-text {
      text-align: center;
      color: #1e40af;
      margin-bottom: 30px;
      font-size: 40px;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }
    input {
      width: 100%;
      height: 40px;
      border-radius: 8px;
      padding: 0 10px;
      border: none;
      margin-bottom: 15px;
      font-size: 14px;
      background-color: #f6f7f9;
    }
    .double-input {
      display: flex;
      gap: 30px;
    }
    .double-input > div {
      flex: 1;
    }
    button {
      width: 100%;
      height: 45px;
      background-color: #4F46E5;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
    }
    .alert {
      margin-bottom: 20px;
      padding: 10px;
      border-radius: 8px;
      font-size: 14px;
    }
    .alert-success {
      background-color: #d1e7dd;
      color: #0f5132;
    }
    .alert-error {
      background-color: #f8d7da;
      color: #842029;
    }
  </style>
</head>
<body>

<div class="auth-container">
  <div class="form-container">
    <h2 class="header-text">تعديل دار نشر</h2>
    <div id="alertMessage" class="alert" style="display:none;"></div>

    <form id="editForm">
      <div class="double-input">
        <div>
          <label for="name_ed">اسم دار النشر</label>
          <input type="text" id="name_ed" required>
        </div>
        <div>
          <label for="tel_ed">رقم الهاتف</label>
          <input type="tel" id="tel_ed" required>
        </div>
      </div>

      <div class="double-input">
        <div>
          <label for="address_ed">العنوان</label>
          <input type="text" id="address_ed" required>
        </div>
        <div>
          <label for="city_ed">المدينة</label>
          <input type="text" id="city_ed" required>
        </div>
      </div>

      <div>
        <label for="email_ed">البريد الإلكتروني</label>
        <input type="email" id="email_ed" required>
      </div>

      <button type="submit">حفظ التعديلات</button>
    </form>
  </div>
</div>

<script>
  const params = new URLSearchParams(window.location.search);
  const id = Number(params.get("id"));
  let publishers = JSON.parse(localStorage.getItem('publishers')) || [];
  const publisher = publishers.find(p => p.id === id);

  if (!publisher) {
    alert("دار النشر غير موجودة!");
    window.location.href = "DAR-AINasher.html";
  } else {
    document.getElementById("name_ed").value = publisher.name_ed;
    document.getElementById("tel_ed").value = publisher.tel_ed;
    document.getElementById("address_ed").value = publisher.address_ed;
    document.getElementById("city_ed").value = publisher.city_ed;
    document.getElementById("email_ed").value = publisher.email_ed;
  }

  document.getElementById("editForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const name_ed = document.getElementById("name_ed").value.trim();
    const tel_ed = document.getElementById("tel_ed").value.trim();
    const address_ed = document.getElementById("address_ed").value.trim();
    const city_ed = document.getElementById("city_ed").value.trim();
    const email_ed = document.getElementById("email_ed").value.trim();

    if (!name_ed || !tel_ed || !address_ed || !city_ed || !email_ed) {
      showAlert("يرجى ملء جميع الحقول", "error");
      return;
    }

    if (!validateEmail(email_ed)) {
      showAlert("البريد الإلكتروني غير صالح", "error");
      return;
    }

    const isDuplicate = publishers.some(p =>
      (p.name_ed.toLowerCase() === name_ed.toLowerCase() || p.email_ed.toLowerCase() === email_ed.toLowerCase())
      && p.id !== id
    );
    if (isDuplicate) {
      showAlert("يوجد دار نشر بنفس الاسم أو البريد الإلكتروني", "error");
      return;
    }

    publisher.name_ed = name_ed;
    publisher.tel_ed = tel_ed;
    publisher.address_ed = address_ed;
    publisher.city_ed = city_ed;
    publisher.email_ed = email_ed;
    publisher.updated_at = new Date().toISOString();

    localStorage.setItem("publishers", JSON.stringify(publishers));
    showAlert("تم حفظ التعديلات بنجاح", "success");

    setTimeout(() => {
      window.location.href = "DAR-AINasher.html";
    }, 2000);
  });

  function showAlert(message, type) {
    const alertBox = document.getElementById("alertMessage");
    alertBox.textContent = message;
    alertBox.className = `alert alert-${type}`;
    alertBox.style.display = "block";
    setTimeout(() => {
      alertBox.style.display = "none";
    }, 5000);
  }

  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }
</script>

</body>
</html>
