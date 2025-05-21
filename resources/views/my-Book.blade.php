<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>كتبي المستعارة | منصة إدارة المكتبة</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #4F46E5;
      --secondary-color: #423add;
      --text-color: #30382F;
      --light-bg: #f5f7fa;
    }
    
    body {
      font-family: 'Tajawal', sans-serif;
      margin: 0;
      padding: 0;
      background-color: var(--light-bg);
      color: var(--text-color);
      line-height: 1.6;
      scroll-behavior: smooth;
    }
    
    header {
      color: white;
      text-align: center;
      position: relative;
      height: 350px;
      overflow: hidden;
    }
    .header-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 1;
    }
    .header-content {
      position: relative;
      z-index: 2;
      padding-top: 80px;
    }
    header h1 {
      margin: 0;
      font-size: 45px;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }
    header h1 {
      margin: 0;
      font-size: 45px;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }
    
    header p {
      margin: 15px 0;
      font-size: 20px;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
    
    /* شريط التنقل المعدل */
    nav {
      background-color: white;
      display: flex;
      justify-content: center;
      gap: 10px;
      padding: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    
    nav a {
      color: var(--text-color);
      text-decoration: none;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 25px;
      transition: all 0.3s;
    }
    
    nav a:hover, nav a.active {
      background-color: var(--secondary-color);
      color: white;
      transform: translateY(-2px);
    }
    
    
    .books-section {
      padding: 20px;
      background-color: #f8f9fa;
    }
    
    .section-title {
      text-align: center;
      font-size: 28px;
      color: var(--primary-color);
      margin-bottom: 30px;
      position: relative;
      top: -150px;
      color: #5831d5;
    }
    
    .books-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 25px;
    }
    
    .book-card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: all 0.3s ease;
      height: 420px; /* زيادة الارتفاع لاستيعاب الأزرار الجديدة */
    }
    
    .book-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    
    .book-cover {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s;
    }
    
    .book-card:hover .book-cover {
      transform: scale(1.03);
    }
    
    .book-details {
      padding: 15px;
    }
    
    .book-title {
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 5px;
    }
    
    .book-author {
      color: #666;
      margin-bottom: 10px;
    }
    
    .borrow-info {
      margin-top: 15px;
      padding: 10px;
      background-color: #f0f7ff;
      border-radius: 5px;
      font-size: 14px;
    }
    
    .borrow-date, .return-date {
      display: flex;
      justify-content: space-between;
      margin-bottom: 5px;
    }
    
    .book-actions {
      display: flex;
      gap: 10px;
      margin-top: 15px;
      flex-wrap: wrap;
    }
    
    .book-btn {
      flex: 1;
      min-width: 80px;
      padding: 8px;
      border-radius: 5px;
      text-align: center;
      text-decoration: none;
      font-weight: bold;
      transition: all 0.3s;
      cursor: pointer;
      border: none;
      font-family: 'Tajawal', sans-serif;
    }
    
    .details-btn {
      background-color: #f0f0f0;
      color: #333;
    }
    
    .details-btn:hover {
      background-color: #ddd;
      transform: translateY(-2px);
    }
    
    .return-btn {
      background-color: #dc3545;
      color: white;
    }
    
    .return-btn:hover {
      background-color: #c82333;
      transform: translateY(-2px);
    }
    
    .extend-btn {
      background-color: #28a745;
      color: white;
    }
    
    .extend-btn:hover {
      background-color: #218838;
      transform: translateY(-2px);
    }
    
    footer {
      text-align: center;
      padding: 30px;
      background-color: var(--primary-color);
      color: white;
      margin-top: 50px;
    }
    
    .no-books {
      grid-column: 1 / -1;
      text-align: center;
      padding: 30px;
      font-size: 18px;
      color: #666;
    }
    
    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      margin: -50px auto 30px auto;
    }
    
    /* تحسينات للهواتف */
    @media (max-width: 768px) {
      header {
        height: 350px;
      }
      
      header h1 {
        font-size: 32px;
      }
      
      nav {
        flex-wrap: wrap;
        gap: 10px;
      }
      
      nav a {
        padding: 8px 15px;
        font-size: 14px;
      }
      
      .books-container {
        grid-template-columns: 1fr;
      }
      
      .book-actions {
        flex-direction: column;
      }
      
      .book-btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <header>
    <img src="image/pexels-olga-volkovitskaia-131638009-17406787.jpg" class="header-image" alt="خلفية المكتبة">
    <div class="header-content">
      <h1>كتبي المستعارة</h1>
      <p>عرض جميع الكتب التي قمت باستعارتها</p>
    </div>
  </header>

  <!-- شريط التنقل المعدل -->
  <nav>
    <a href="home.html">الصفحة الرئيسية</a>
    <a href="books.html">قائمة الكتب</a>
    <a href="about.html">حول كتابي</a>
    <a href="kotbi.html" class="active">كتبي المستعارة</a>
    <a href="manage-accounts.html">لوحة التحكم</a>
  </nav>

  <div class="logo-container">
    <img src="../image/20250429_000806(2).png" alt="لوجو " style="width: 300px;height:auto;">
  </div>

  <section class="books-section">
    <h2 class="section-title">الكتب التي قمت باستعارتها</h2>
    <div id="borrowedBooksContainer" class="books-container">
      <!-- الكتب المستعارة ستظهر هنا تلقائياً -->
    </div>
  </section>

  <footer>
    <div class="social-links">
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
    <p>© 2025 منصة إدارة المكتبة. جميع الحقوق محفوظة.</p>
  </footer>

  <script>
    // بيانات أولية للكتب المستعارة
    const initialBorrowedBooks = [
      {
        id: "1",
        title: "فن اللامبالاة",
        author: "مارك مانسون",
        image: "https://via.placeholder.com/300x200?text=فن+اللامبالاة",
        borrowDate: "2023-05-15",
        returnDate: "2023-06-15",
        status: "مستعارة",
        canExtend: true
      },
      {
        id: "2",
        title: "العادات الذرية",
        author: "جيمس كلير",
        image: "https://via.placeholder.com/300x200?text=العادات+الذرية",
        borrowDate: "2023-06-01",
        returnDate: "2023-07-01",
        status: "مستعارة",
        canExtend: false
      }
    ];

    // تهيئة البيانات
    function initializeBorrowedBooks() {
      if (!localStorage.getItem('borrowedBooks') || JSON.parse(localStorage.getItem('borrowedBooks')).length === 0) {
        localStorage.setItem('borrowedBooks', JSON.stringify(initialBorrowedBooks));
      }
    }

    // عرض الكتب المستعارة
    function displayBorrowedBooks() {
      const container = document.getElementById('borrowedBooksContainer');
      const borrowedBooks = JSON.parse(localStorage.getItem('borrowedBooks')) || [];
      
      if (borrowedBooks.length === 0) {
        container.innerHTML = `
          <div class="no-books">
            <i class="fas fa-book-open" style="font-size: 50px; color: #ccc; margin-bottom: 15px;"></i>
            <p>لا توجد كتب مستعارة حالياً</p>
          </div>
        `;
        return;
      }

      container.innerHTML = borrowedBooks.map(book => `
        <div class="book-card" data-id="${book.id}">
          <img src="${book.image || 'https://via.placeholder.com/300x250?text=لا+يوجد+غلاف'}" 
               alt="${book.title}" 
               class="book-cover">
          <div class="book-details">
            <div class="book-title">${book.title}</div>
            <div class="book-author">${book.author}</div>
            
            <div class="borrow-info">
              <div class="borrow-date">
                <span>تاريخ الاستعارة:</span>
                <span>${book.borrowDate}</span>
              </div>
              <div class="return-date">
                <span>موعد الإرجاع:</span>
                <span>${book.returnDate}</span>
              </div>
              <div class="status">
                <span>الحالة:</span>
                <span>${book.status}</span>
              </div>
            </div>
            
            <div class="book-actions">
              <a href="book_detail.html?id=${book.id}" class="book-btn details-btn">
                <i class="fas fa-info-circle"></i> التفاصيل
              </a>
              <button class="book-btn extend-btn" onclick="extendBorrowPeriod('${book.id}')" ${book.canExtend ? '' : 'disabled style="opacity:0.6; cursor:not-allowed;"'}>
                <i class="fas fa-calendar-plus"></i> تمديد
              </button>
            </div>
          </div>
        </div>
      `).join('');
    }

    // إرجاع الكتاب
    function returnBook(bookId) {
      if (confirm('هل أنت متأكد من رغبتك في إرجاع هذا الكتاب؟')) {
        try {
          let borrowedBooks = JSON.parse(localStorage.getItem('borrowedBooks')) || [];
          borrowedBooks = borrowedBooks.filter(book => book.id !== bookId);
          localStorage.setItem('borrowedBooks', JSON.stringify(borrowedBooks));
          
          updateMainBookStatus(bookId, 'متوفر');
          displayBorrowedBooks();
          
          showAlert('تم إرجاع الكتاب بنجاح', 'success');
        } catch (error) {
          console.error('حدث خطأ أثناء إرجاع الكتاب:', error);
          showAlert('حدث خطأ أثناء إرجاع الكتاب', 'error');
        }
      }
    }

    // تمديد مدة الاستعارة
    function extendBorrowPeriod(bookId) {
      const borrowedBooks = JSON.parse(localStorage.getItem('borrowedBooks')) || [];
      const bookIndex = borrowedBooks.findIndex(book => book.id === bookId);
      
      if (bookIndex === -1) {
        showAlert('لم يتم العثور على الكتاب', 'error');
        return;
      }
      
      const book = borrowedBooks[bookIndex];
      
      if (!book.canExtend) {
        showAlert('لا يمكن تمديد مدة استعارة هذا الكتاب', 'error');
        return;
      }
      
      // حساب التاريخ الجديد (إضافة 14 يومًا)
      const currentReturnDate = new Date(book.returnDate);
      currentReturnDate.setDate(currentReturnDate.getDate() + 14);
      
      const newReturnDate = currentReturnDate.toISOString().split('T')[0];
      
      // تحديث بيانات الكتاب
      borrowedBooks[bookIndex] = {
        ...book,
        returnDate: newReturnDate,
        canExtend: false // منع التمديد مرة أخرى
      };
      
      localStorage.setItem('borrowedBooks', JSON.stringify(borrowedBooks));
      displayBorrowedBooks();
      showAlert('تم تمديد مدة الاستعارة بنجاح حتى ' + newReturnDate, 'success');
    }

    // تحديث حالة الكتاب في القائمة الرئيسية
    function updateMainBookStatus(bookId, newStatus) {
      try {
        const allBooks = JSON.parse(localStorage.getItem('books')) || [];
        const updatedBooks = allBooks.map(book => {
          if (book.id === bookId) {
            return {...book, status: newStatus};
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
      alertDiv.className = `alert alert-${type}`;
      alertDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px;
        border-radius: 5px;
        background-color: ${type === 'success' ? '#d4edda' : '#f8d7da'};
        color: ${type === 'success' ? '#155724' : '#721c24'};
        border: 1px solid ${type === 'success' ? '#c3e6cb' : '#f5c6cb'};
        z-index: 1000;
        animation: fadeIn 0.3s;
      `;
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
      initializeBorrowedBooks();
      displayBorrowedBooks();
    });

    // إضافة أنيميشن للرسائل
    const style = document.createElement('style');
    style.innerHTML = `
      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
      }
      @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
      }
    `;
    document.head.appendChild(style);
  </script>
</body>
</html>