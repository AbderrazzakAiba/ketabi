<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تفاصيل الكتاب | منصة كتابي</title>
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
    }

    /* شريط التنقل */
    nav {
      background-color: white;
      display: flex;
      justify-content: center;
      gap: 15px;
      padding: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    nav a {
      color: var(--text-color);
      text-decoration: none;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 25px;
      transition: all 0.3s;
    }

    nav a:hover {
      background-color: var(--secondary-color);
      color: white;
    }

    /* محتوى الصفحة */
    .container {
      max-width: 1000px;
      margin: 30px auto;
      padding: 0 20px;
    }

    .book-detail-container {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      background-color: white;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }

    .book-cover-container {
      flex: 1;
      min-width: 300px;
      text-align: center;
    }

    .book-cover {
      max-width: 100%;
      height: 400px;
      object-fit: contain;
      border-radius: 5px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    .book-info {
      flex: 2;
      min-width: 300px;
    }

    .book-title {
      color: var(--primary-color);
      font-size: 28px;
      margin-top: 0;
      margin-bottom: 10px;
    }

    .book-author {
      font-size: 20px;
      color: #666;
      margin-bottom: 20px;
    }

    .book-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 25px;
    }

    .meta-item {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .meta-icon {
      color: var(--primary-color);
    }

    .book-status {
      display: inline-block;
      padding: 5px 15px;
      border-radius: 20px;
      font-weight: bold;
    }

    .available {
      background-color: #e6f7ee;
      color: #28a745;
    }

    .unavailable {
      background-color: #f8d7da;
      color: #dc3545;
    }

    .book-description {
      margin-bottom: 30px;
      line-height: 1.8;
    }

    .action-buttons {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .action-btn {
      padding: 12px 25px;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .borrow-btn {
      background-color: var(--primary-color);
      color: white;
      border: none;
    }

    .back-btn {
      background-color: white;
      color: var(--primary-color);
      border: 2px solid var(--primary-color);
    }

    .action-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    /* قسم التفاصيل الإضافية */
    .details-section {
      margin-top: 40px;
      background-color: white;
      border-radius: 8px;
      padding: 25px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .section-title {
      color: var(--primary-color);
      font-size: 22px;
      margin-top: 0;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }

    .details-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
    }

    .detail-item {
      margin-bottom: 15px;
    }

    .detail-label {
      font-weight: bold;
      color: #666;
      margin-bottom: 5px;
    }

    /* الفوتر */
    footer {
      text-align: center;
      padding: 20px;
      background-color: var(--primary-color);
      color: white;
      margin-top: 50px;
    }
  </style>
</head>
<body>
  <nav>
    <a href="index.html"><i class="fas fa-home"></i> الرئيسية</a>
    <a href="books.html"><i class="fas fa-book"></i> قائمة الكتب</a>
    <a href="dashboard.html"><i class="fas fa-cog"></i> لوحة التحكم</a>
  </nav>

  <div class="container">
    <div class="book-detail-container">
      <div class="book-cover-container">
        <img id="bookCover" src="https://via.placeholder.com/300x400?text=صورة+الغلاف" alt="غلاف الكتاب" class="book-cover">
      </div>

      <div class="book-info">
        <h1 id="bookTitle" class="book-title">عنوان الكتاب</h1>
        <p id="bookAuthor" class="book-author">اسم المؤلف</p>

        <div class="book-meta">
          <div class="meta-item">
            <i class="fas fa-tag meta-icon"></i>
            <span id="bookCategory">التصنيف</span>
          </div>
          <div class="meta-item">
            <i class="fas fa-calendar-alt meta-icon"></i>
            <span id="bookYear">سنة النشر</span>
          </div>
          <div class="meta-item">
            <i class="fas fa-file-alt meta-icon"></i>
            <span id="bookPages">عدد الصفحات</span>
          </div>
          <div class="meta-item">
            <span id="bookStatus" class="book-status available">متوفر</span>
          </div>
        </div>

        <div class="book-description">
          <h3>نبذة عن الكتاب</h3>
          <p id="bookDescription">وصف الكتاب سيظهر هنا. هذا النص هو مثال يمكن استبداله بنص حقيقي يحتوي على وصف مفصل للكتاب ومحتواه.</p>
        </div>

        <div class="action-buttons">
          <a href="#" class="action-btn borrow-btn" id="borrowBtn" onclick="window.location.href='Etudiants/borrows.html'">
            <i class="fas fa-bookmark"></i> استعارة الكتاب
          </a>
          <a href="books.html" class="action-btn back-btn" onclick="window.history.back()">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
          </a>
        </div>
      </div>
    </div>

    <div class="details-section">
      <h3 class="section-title">تفاصيل إضافية</h3>
      <div class="details-grid">
        <div class="detail-item">
          <div class="detail-label">اللغة</div>
          <div id="bookLanguage">العربية</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">الناشر</div>
          <div id="bookPublisher">دار النشر</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">الرقم الدولي</div>
          <div id="bookISBN">978-3-16-148410-0</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">تاريخ الإضافة</div>
          <div id="bookAddedDate">01/01/2023</div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    © 2025 منصة كتابي - جميع الحقوق محفوظة
  </footer>

  <script>
    // دالة لجلب معرّف الكتاب من URL
    function getBookIdFromUrl() {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get('id');
    }

    // دالة لجلب تفاصيل الكتاب من localStorage
    function fetchBookDetails(bookId) {
      const books = JSON.parse(localStorage.getItem('books')) || [];
      return books[bookId];
    }

    // دالة لعرض تفاصيل الكتاب
    function displayBookDetails() {
      const bookId = getBookIdFromUrl();
      if (bookId === null) {
        alert('لم يتم العثور على الكتاب المطلوب');
        window.location.href = 'books.html';
        return;
      }

      const book = fetchBookDetails(bookId);
      if (!book) {
        alert('الكتاب غير موجود');
        window.location.href = 'books.html';
        return;
      }

      // تعبئة البيانات في الصفحة
      document.getElementById('bookTitle').textContent = book.title || 'بدون عنوان';
      document.getElementById('bookAuthor').textContent = book.author || 'مؤلف غير معروف';
      document.getElementById('bookCategory').textContent = book.category || 'غير مصنف';
      document.getElementById('bookYear').textContent = book.year || 'غير معروف';
      document.getElementById('bookPages').textContent = book.pages ? `${book.pages} صفحة` : 'غير معروف';
      document.getElementById('bookDescription').textContent = book.description || 'لا يوجد وصف متاح لهذا الكتاب';
      document.getElementById('bookLanguage').textContent = book.language || 'العربية';
      document.getElementById('bookPublisher').textContent = book.publisher || 'غير معروف';
      document.getElementById('bookISBN').textContent = book.isbn || 'غير متاح';
      document.getElementById('bookAddedDate').textContent = book.addedDate || 'غير معروف';

      // حالة الكتاب
      const statusElement = document.getElementById('bookStatus');
      statusElement.textContent = book.status || 'غير معروف';
      statusElement.className = book.status === 'متوفر' ? 'book-status available' : 'book-status unavailable';

      // صورة الكتاب
      if (book.image) {
        document.getElementById('bookCover').src = book.image;
      }

      // زر الاستعارة
      const borrowBtn = document.getElementById('borrowBtn');
      if (book.status !== 'متوفر') {
        borrowBtn.style.backgroundColor = '#ccc';
        borrowBtn.style.cursor = 'not-allowed';
        borrowBtn.onclick = (e) => e.preventDefault();
        borrowBtn.innerHTML = '<i class="fas fa-times"></i> غير متاح للاستعارة';
      }
    }

    // تحميل البيانات عند فتح الصفحة
    window.onload = function() {
      displayBookDetails();
    };
  </script>
</body>
</html>
