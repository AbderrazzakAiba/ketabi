<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>إضافة كتاب</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
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
      background-color: #e8e7e7;
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
      <img src="../image/20250429_000806(2).png" alt="لوجو " style="width: 300px;height:auto;">
    </div>
    <h3 style="color: black; font-size: 18px;">إضافة الكتب الجديدة إلى المكتبة</h3>
    <p style="color: black; font-size: 14px;">شارك المعرفة مع القراء</p>
  </div>

  <div class="form-container">
    <form id="bookForm">
      <h1 style="text-align: center;font-family: 'Tajawal', sans-serif;font-size: 30px;">إضافة كتاب جديد</h1><br>

      <div class="double-input">
        <div>
          <label for="title">عنوان الكتاب</label>
          <input type="text" id="title" placeholder="أدخل عنوان الكتاب" required>
        </div>
        <div>
          <label for="author">اسم المؤلف</label>
          <input type="text" id="author" placeholder="أدخل اسم المؤلف" required>
        </div>
      </div>

      <div class="double-input">
        <div>
          <label for="pages">عدد الصفحات</label>
          <input type="number" id="pages" min="1" step="1" placeholder="أدخل عدد الصفحات" required>
        </div>
        <div>
          <label for="classNo">رقم التصنيف</label>
          <input type="number" id="classNo" min="1" step="1" placeholder="أدخل رقم التصنيف" required>
        </div>
      </div>

      <div class="double-input">
        <div>
          <label for="copies">الكمية</label>
          <input type="number" id="copies" min="1" step="1" placeholder="أدخل عدد الكتب" required>
        </div>
        <div>
          <label for="classification">الفئة</label>
          <select id="classification" required>
            <option value="">اختر التصنيف</option>
            <option value="روايات">روايات</option>
            <option value="علوم">علوم</option>
            <option value="أعمال">أعمال</option>
            <option value="تاريخ">تاريخ</option>
            <option value="تكنولوجيا">تكنولوجيا</option>
            <option value="تطوير ذاتي">تطوير ذاتي</option>
          </select>
        </div>
      </div>
      
      <div class="double-input">
        <div>
          <label for="status">حالة النسخة</label>
          <select id="status" required>
            <option value="">حالة النسخة</option>
            <option value="متوفر">متوفرة</option>
            <option value="غير متوفر">غير متوفرة</option>
          </select>
        </div>
        <div>     
          <label for="publisher">دار النشر</label>
          <input type="text" id="publisher" placeholder="أدخل دار النشر" required>
        </div>
      </div>

      <div class="file-upload-container">
        <div class="upload-box">
          <label for="image">غلاف الكتاب</label>
          <button type="button" onclick="document.getElementById('image').click()">
            <i class="fas fa-image" style="font-size: 50px;color: #f6f7f9; color: white;"></i><br>
          </button>
          <input type="file" id="image" accept="image/*" style="display: none;">
        </div>

        <div class="upload-box">
          <label for="file">ملف الكتاب (PDF)</label>
          <button type="button" onclick="document.getElementById('file').click()">
            <i class="fas fa-file-pdf" style="font-size: 50px; color: #f6f7f9; color: white;"></i><br>
          </button>
          <input type="file" id="file" accept="application/pdf" style="display: none;">
        </div>
      </div>

      <button type="submit" style="background-color: #2e30cc;color: rgb(255, 255, 255);">إضافة الكتاب</button>
    </form>
  </div>
</div>

<script>
document.getElementById('bookForm').addEventListener('submit', function(e) {
  e.preventDefault();

  // جمع بيانات النموذج
  const title = document.getElementById('title').value.trim();
  const author = document.getElementById('author').value.trim();
  const pages = document.getElementById('pages').value;
  const classNo = document.getElementById('classNo').value;
  const copies = document.getElementById('copies').value;
  const classification = document.getElementById('classification').value;
  const status = document.getElementById('status').value;
  const publisher = document.getElementById('publisher').value.trim();
  const imageInput = document.getElementById('image');
  
  // صورة افتراضية إذا لم يتم تحميل صورة
  let imageUrl = 'https://via.placeholder.com/300x250?text=لا+يوجد+غلاف';
  
  // إذا تم تحميل صورة، قراءتها وتحويلها لـ base64
  if (imageInput.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      imageUrl = e.target.result;
      saveBookToLocalStorage(imageUrl);
    };
    reader.readAsDataURL(imageInput.files[0]);
  } else {
    saveBookToLocalStorage(imageUrl);
  }

  function saveBookToLocalStorage(image) {
    const newBook = {
      title,
      author,
      pages,
      classNo,
      copies,
      category: classification,
      status,
      publisher,
      image,
      addedDate: new Date().toLocaleDateString('ar-EG')
    };

    try {
      // جلب الكتب الحالية من localStorage أو إنشاء مصفوفة جديدة إذا لم توجد
      const books = JSON.parse(localStorage.getItem('books')) || [];
      
      // إضافة الكتاب الجديد في بداية المصفوفة
      books.unshift(newBook);
      
      // حفظ الكتب في localStorage
      localStorage.setItem('books', JSON.stringify(books));
      
      // عرض رسالة نجاح
      alert('تمت إضافة الكتاب بنجاح!');
      
      // التوجيه إلى الصفحة الرئيسية بعد الإضافة
      window.location.href = 'home.html';
    } catch (e) {
      alert('حدث خطأ أثناء حفظ الكتاب: ' + e.message);
      console.error(e);
    }
  }
});
</script>

</body>
</html>