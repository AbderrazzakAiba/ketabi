<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>إضافة دار نشر</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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
      font-family:Georgia, 'Times New Roman', Times, serif;
      font-size: 40px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }
    input, select {
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
    textarea {
      width: 100%;
      height: 120px;
      border-radius: 8px;
      background-color: #f6f7f9;
      border: none;
      padding: 10px;
      font-size: 14px;
      margin-bottom: 15px;
    }
    button {
      width: 100%;
      height: 45px;
      background-color: #3232d7;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .file-upload-container {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 30px;
    }
    .upload-box {
      flex: 1;
      min-width: 200px;
      text-align: center;
    }
    .upload-box button {
      background-color: #2e30cc;
      height: 100px;
      width: 100%;
    }
    .upload-box img {
      height: 50px;
      margin-bottom: 5px;
    }
    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      margin-bottom: -80px;
    }
  </style>
</head>
<body>

<div class="auth-container">
  <div class="header-text">
    <div class="logo-container">
      <img src="../image/20250429_000806(2).png" alt="لوجو" style="width: 300px;height:auto;">
    </div>
    <h3 style="color: black; font-size: 18px;">إضافة دار نشر جديدة إلى النظام</h3>
    <p style="color: black; font-size: 14px;">إدارة دور النشر المتعاونة مع المكتبة</p>
  </div>

  <div class="form-container">
    <form id="publisherForm">
      <h1 style="text-align: center;font-family: 'Tajawal', sans-serif;font-size: 30px;color: #4F46E5;">إضافة دار نشر جديدة</h1>
      <div id="alertMessage" class="alert" style="display: none;"></div>

      <div class="double-input">
        <div>
          <label for="name_ed">اسم دار النشر</label>
          <input type="text" id="name_ed" placeholder="أدخل اسم دار النشر" required>
        </div>
        <div>
          <label for="tel_ed">رقم الهاتف</label>
          <input type="tel" id="tel_ed" placeholder="أدخل رقم الهاتف" required style="text-align: right;">
        </div>
      </div>

      <div class="double-input">
        <div>
          <label for="address_ed">العنوان</label>
          <input type="text" id="address_ed" placeholder="أدخل عنوان دار النشر" required>
        </div>
        <div>
          <label for="city_ed">المدينة</label>
          <input type="text" id="city_ed" placeholder="أدخل المدينة" required>
        </div>
      </div>

      <div>
        <label for="email_ed">البريد الإلكتروني</label>
        <input type="email" id="email_ed" placeholder="أدخل البريد الإلكتروني" required>
      </div>

      <button type="submit">حفظ دار النشر</button>
    </form>
  </div>
</div>

<script>
// إدارة النموذج
document.getElementById('publisherForm').addEventListener('submit', function(e) {
  e.preventDefault();

  // جمع البيانات من النموذج
  const name_ed = document.getElementById('name_ed').value.trim();
  const address_ed = document.getElementById('address_ed').value.trim();
  const city_ed = document.getElementById('city_ed').value.trim();
  const email_ed = document.getElementById('email_ed').value.trim();
  const tel_ed = document.getElementById('tel_ed').value.trim();

  // التحقق من الحقول المطلوبة
  if (!name_ed || !address_ed || !city_ed || !email_ed || !tel_ed) {
    showAlert('يرجى ملء جميع الحقول المطلوبة', 'error');
    return;
  }

  // التحقق من صحة البريد الإلكتروني
  if (!validateEmail(email_ed)) {
    showAlert('البريد الإلكتروني غير صالح', 'error');
    return;
  }

  savePublisher(name_ed, address_ed, city_ed, email_ed, tel_ed);
});

function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

function showAlert(message, type) {
  const alertDiv = document.getElementById('alertMessage');
  alertDiv.textContent = message;
  alertDiv.className = `alert alert-${type}`;
  alertDiv.style.display = 'block';

  setTimeout(() => {
    alertDiv.style.display = 'none';
  }, 5000);
}

function savePublisher(name_ed, address_ed, city_ed, email_ed, tel_ed) {
  const newPublisher = {
    id: Date.now(),
    name_ed,
    address_ed,
    city_ed,
    email_ed,
    tel_ed,
    created_at: new Date().toISOString()
  };

  try {
    let publishers = JSON.parse(localStorage.getItem('publishers')) || [];

    // التحقق من عدم تكرار دار النشر
    const isDuplicate = publishers.some(publisher =>
      publisher.name_ed.toLowerCase() === name_ed.toLowerCase() ||
      publisher.email_ed.toLowerCase() === email_ed.toLowerCase()
    );

    if (isDuplicate) {
      showAlert('دار النشر مسجلة مسبقاً!', 'error');
      return;
    }

    publishers.push(newPublisher);
    localStorage.setItem('publishers', JSON.stringify(publishers));

    showAlert('تمت إضافة دار النشر بنجاح!', 'success');

    // إعادة تعيين النموذج بعد الحفظ
    document.getElementById('publisherForm').reset();

    // الانتقال إلى صفحة العرض بعد 2 ثانية
    setTimeout(() => {
      window.location.href = 'DAR-AINasher.html';
    }, 2000);
  } catch (e) {
    showAlert('حدث خطأ أثناء حفظ دار النشر: ' + e.message, 'error');
    console.error(e);
  }
}
</script>
</body>
</html>
