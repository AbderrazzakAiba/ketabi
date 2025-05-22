<!-- filepath: d:\ketabi\resources\views\my-Book.blade.php -->
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
    header p {
      margin: 15px 0;
      font-size: 20px;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
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
      height: 560px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .book-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .book-cover {
      width: 100%;
      height: 260px;
      object-fit: cover;
      transition: transform 0.3s;
      display: block;
    }
    .book-card:hover .book-cover {
      transform: scale(1.03);
    }
    .book-details {
      padding: 15px;
      flex: 1 1 auto;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
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
    .status {
      margin-top: 8px;
      margin-bottom: 0;
    }
    .status-row {
      margin-bottom: 3px;
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
      .book-card {
        height: 620px;
      }
      .book-cover {
        height: 200px;
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

  <nav>
    <a href="{{ route('home') }}">الصفحة الرئيسية</a>
    <a href="{{ route('books.index') }}">قائمة الكتب</a>
    <a href="{{ route('about') }}">حول كتابي</a>
    <a href="{{ route('mybooks.index') }}" class="active">كتبي المستعارة</a>
    <a href="dashboard.html">لوحة التحكم</a>
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
    async function fetchBookById(id_book) {
      try {
        const res = await fetch(`/api/books/${id_book}`);
        if (res.ok) {
          return await res.json();
        }
      } catch (e) {}
      return null;
    }

    async function fetchBorrowedBooks() {
      const token = localStorage.getItem('authToken');
      const container = document.getElementById('borrowedBooksContainer');
      container.innerHTML = "جاري التحميل ...";

      const response = await fetch('/api/my-borrows', {
        headers: {
          'Authorization': 'Bearer ' + token
        }
      });
      if (!response.ok) {
        container.innerHTML = "<div class='no-books'>حدث خطأ أثناء جلب البيانات</div>";
        return;
      }
      const data = await response.json();
      if (!data.data || data.data.length === 0) {
        container.innerHTML = `
          <div class="no-books">
            <i class="fas fa-book-open" style="font-size: 50px; color: #ccc; margin-bottom: 15px;"></i>
            <p>لا توجد كتب مستعارة حالياً</p>
          </div>
        `;
        return;
      }

      // استخدم Promise.all لجلب بيانات الكتب الناقصة
      const cards = await Promise.all(data.data.map(async borrow => {
        let book = null;
        if (borrow.copy && borrow.copy.book) {
          book = borrow.copy.book;
        } else if (borrow.book) {
          book = borrow.book;
        } else if (borrow.id_book) {
          book = await fetchBookById(borrow.id_book);
        }
        if (!book) {
          return `
            <div class="book-card">
              <div class="book-details">
                <div class="book-title">بيانات الكتاب غير متوفرة</div>
              </div>
            </div>
          `;
        }
        // شرط زر التمديد
        const duration = Number(borrow.duration);
        const showExtendBtn =
          (borrow.type === 'external' || borrow.type === 'online_return')
          && !isNaN(duration)
          && duration < 15;
        return `
          <div class="book-card">
            <img src="${book.image_path || 'https://via.placeholder.com/300x250?text=لا+يوجد+غلاف'}"
                 alt="${book.title}"
                 class="book-cover">
            <div class="book-details">
              <div class="book-title">${book.title}</div>
              <div class="book-author">${book.author || ''}</div>
              <div class="borrow-info">
                <div class="borrow-date">
                  <span>تاريخ الاستعارة:</span>
                  <span>${borrow.borrow_date || borrow.borrowed_at || ''}</span>
                </div>
                <div class="return-date">
                  <span>موعد الإرجاع:</span>
                  <span>${borrow.due_date || ''}</span>
                </div>
                <div class="status">
                  <div class="status-row">
                    <span>نوع الاستعارة:</span>
                    <span>${borrow.type || ''}</span>
                  </div>
                  <div class="status-row">
                    <span>الحالة:</span>
                    <span>${borrow.status || ''}</span>
                  </div>
                </div>
              </div>
              <div class="book-actions">
                <a href="/books/${book.id || ''}" class="book-btn details-btn">
                  <i class="fas fa-info-circle"></i> التفاصيل
                </a>
                ${showExtendBtn ? `
                <button class="book-btn extend-btn"
  onclick="extendBorrowPeriod('${borrow.id_pret}')">
  <i class="fas fa-calendar-plus"></i> تمديد
</button>
                ` : ''}
              </div>
            </div>
          </div>
        `;
      }));

      container.innerHTML = cards.join('');
    }

    // دالة التمديد: ترسل طلب تمديد فعلي للـ API
    function extendBorrowPeriod(borrowId) {
      if (!confirm('هل أنت متأكد أنك تريد طلب تمديد هذه الإعارة؟')) return;
      const token = localStorage.getItem('authToken');
      fetch(`/api/borrows/${borrowId}/extend`, {
        method: 'POST',
        headers: {
          'Authorization': 'Bearer ' + token,
          'Accept': 'application/json'
        }
      })
      .then(async res => {
        if (res.ok) {
          alert('تم إرسال طلب التمديد بنجاح. في انتظار الموافقة.');
          fetchBorrowedBooks();
        } else {
          const data = await res.json();
          alert(data.message || 'حدث خطأ أثناء إرسال طلب التمديد');
        }
      })
      .catch(() => {
        alert('حدث خطأ في الاتصال بالخادم');
      });
    }

    window.addEventListener('DOMContentLoaded', fetchBorrowedBooks);

    // إضافة أنيميشن للرسائل (اختياري)
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
