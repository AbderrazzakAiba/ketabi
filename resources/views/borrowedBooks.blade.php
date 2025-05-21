<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>إضافة استعارة</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
      color: #2848b0;
      margin-bottom: 30px;
      font-family: Georgia, 'Times New Roman', Times, serif;
    }

    form h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .row {
      display: flex;
      gap: 30px;
      margin-bottom: 15px;
    }

    .row > div {
      flex: 1;
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
      background-color: #f6f7f9;
      font-size: 14px;
    }

    input[readonly] {
      background-color: #e5e7eb;
      cursor: not-allowed;
    }

    button {
      width: 100%;
      background-color: #4F46E5;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-top: 25px;
    }

    button:hover {
      background-color: #3c3bce;
    }

    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      margin-bottom: -90px;
    }

    .alert {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 15px;
      border-radius: 5px;
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
      z-index: 1000;
      animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<div class="auth-container">
  <div class="header-text">
    <div class="logo-container">
      <img src="../image/20250429_000806(2).png" alt="لوجو " style="width: 300px;height:auto;">
    </div>
    <h3 style="color: black;">إضافة عملية استعارة جديدة</h3>
    <p style="color: black;">قم بتسجيل معلومات الاستعارة بدقة</p>
  </div>

  <div class="form-container">
    <form id="borrowForm">
      <h2>استعارة كتاب</h2>
      <div class="row">
        <div>
          <label for="date_emprunt">تاريخ الاستعارة</label>
          <input type="date" id="date_emprunt" required>
        </div> 
        <div>
          <label for="date_retour">تاريخ الإرجاع</label>
          <input type="date" id="date_retour" readonly required>
        </div>
      </div>

      <div class="row">
        <div>
          <label for="type_empr">نوع الاستعارة</label>
          <select id="type_empr" required>
            <option value="">اختر النوع</option>
            <option value="داخلية">داخلية</option>
            <option value="خارجية">خارجية</option>
            <option value="عبر الانترنت">عبر الانترنت</option>
          </select>
        </div>
      </div>

      <button type="submit" onclick="window.location.href='../kotbi.html'" >تأكيد الاستعارة</button>
      <button type="button" onclick="window.history.back();">الغاء</button>
    </form>
  </div>
</div>

<script>
  // تهيئة التواريخ
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('date_emprunt').value = today;
  
  // حساب تاريخ الإرجاع (3 أيام من تاريخ الاستعارة)
  const startInput = document.getElementById('date_emprunt');
  const endInput = document.getElementById('date_retour');
  
  function calculateReturnDate() {
    const startDate = new Date(startInput.value);
    if (isNaN(startDate)) return;

    const endDate = new Date(startDate);
    endDate.setDate(endDate.getDate() + 15);
    endInput.value = endDate.toISOString().split('T')[0];
  }
  
  startInput.addEventListener('change', calculateReturnDate);
  calculateReturnDate(); // حساب التاريخ الأولي

  // ملء قائمة الكتب المتاحة
  function populateAvailableBooks() {
    const bookSelect = document.getElementById('book_id');
    bookSelect.innerHTML = '<option value="">اختر كتاب</option>';
    
    try {
      const books = JSON.parse(localStorage.getItem('books')) || [];
      const borrowedBooks = JSON.parse(localStorage.getItem('borrowedBooks')) || [];
      
      // الحصول على عناوين الكتب المستعارة
      const borrowedBookIds = borrowedBooks.map(book => book.id);
      
      // تصفية الكتب المتاحة فقط (غير مستعارة)
      const availableBooks = books.filter(book => 
        !borrowedBookIds.includes(book.id) && book.status === 'متوفر'
      );
      
      if (availableBooks.length === 0) {
        bookSelect.innerHTML = '<option value="">لا توجد كتب متاحة للاستعارة</option>';
        return;
      }
      
      availableBooks.forEach(book => {
        const option = document.createElement('option');
        option.value = book.id;
        option.textContent = `${book.title} - ${book.author}`;
        bookSelect.appendChild(option);
      });
    } catch (error) {
      console.error('حدث خطأ أثناء تحميل الكتب:', error);
    }
  }

  // معالجة إرسال النموذج
  document.getElementById('borrowForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const bookId = document.getElementById('book_id').value;
    const studentId = document.getElementById('student_id').value;
    const borrowDate = document.getElementById('date_emprunt').value;
    const returnDate = document.getElementById('date_retour').value;
    const borrowType = document.getElementById('type_empr').value;
    
    if (!bookId || !studentId || !borrowDate || !returnDate || !borrowType) {
      showAlert('يرجى ملء جميع الحقول المطلوبة', 'error');
      return;
    }
    
    try {
      // الحصول على معلومات الكتاب
      const books = JSON.parse(localStorage.getItem('books')) || [];
      const book = books.find(b => b.id === bookId);
      
      if (!book) {
        showAlert('الكتاب المحدد غير موجود', 'error');
        return;
      }
      
      // إنشاء سجل الاستعارة
      const newBorrow = {
        id: Date.now().toString(),
        bookId: book.id,
        title: book.title,
        author: book.author,
        image: book.image || 'https://via.placeholder.com/300x200?text=لا+يوجد+غلاف',
        studentId,
        borrowDate,
        returnDate,
        borrowType,
        status: 'مستعارة',
        canExtend: true
      };
      
      // حفظ الاستعارة
      const borrowedBooks = JSON.parse(localStorage.getItem('borrowedBooks')) || [];
      borrowedBooks.push(newBorrow);
      localStorage.setItem('borrowedBooks', JSON.stringify(borrowedBooks));
      
      // تحديث حالة الكتاب إلى "مستعارة"
      updateBookStatus(bookId, 'مستعارة');
      
      // عرض رسالة النجاح
      showAlert('تمت عملية الاستعارة بنجاح', 'success');
      
      // إعادة تعبئة قائمة الكتب المتاحة
      populateAvailableBooks();
      
      // إعادة تعيين النموذج
      document.getElementById('student_id').value = '';
      document.getElementById('type_empr').value = '';
      
    } catch (error) {
      console.error('حدث خطأ أثناء حفظ الاستعارة:', error);
      showAlert('حدث خطأ أثناء حفظ الاستعارة', 'error');
    }
  });

  // تحديث حالة الكتاب
  function updateBookStatus(bookId, newStatus) {
    try {
      const books = JSON.parse(localStorage.getItem('books')) || [];
      const updatedBooks = books.map(book => {
        if (book.id === bookId) {
          return { ...book, status: newStatus };
        }
        return book;
      });
      localStorage.setItem('books', JSON.stringify(updatedBooks));
    } catch (error) {
      console.error('حدث خطأ أثناء تحديث حالة الكتاب:', error);
    }
  }

  // عرض رسالة تنبيه
  function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert';
    alertDiv.style.backgroundColor = type === 'success' ? '#d4edda' : '#f8d7da';
    alertDiv.style.color = type === 'success' ? '#155724' : '#721c24';
    alertDiv.style.borderColor = type === 'success' ? '#c3e6cb' : '#f5c6cb';
    
    alertDiv.innerHTML = `
      <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
      ${message}
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
      alertDiv.style.animation = 'fadeOut 0.3s';
      setTimeout(() => alertDiv.remove(), 300);
    }, 3000);
  }

  // تحميل الصفحة
  window.addEventListener('DOMContentLoaded', () => {
    populateAvailableBooks();
  });

  // إضافة أنيميشن للرسائل
  const style = document.createElement('style');
  style.innerHTML = `
    @keyframes fadeOut {
      from { opacity: 1; transform: translateY(0); }
      to { opacity: 0; transform: translateY(-20px); }
    }
  `;
  document.head.appendChild(style);
</script>

</body>
</html>