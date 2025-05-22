<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>الصفحة الرئيسية | منصة إدارة المكتبة</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Tajawal', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #ffffff;
      color: #30382F;
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
    .search-bar {
      display: flex;
      justify-content: center;
      align-items: center;
      max-width: 700px;
      height: 50px;
      margin: 25px auto;
      background-color: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    .search-bar input {
      flex: 1;
      border: none;
      outline: none;
      padding: 10px 20px;
      font-size: 16px;
    }
    .search-bar button {
      background-color: #4F46E5;
      border: none;
      color: white;
      padding: 0 25px;
      cursor: pointer;
      height: 100%;
      transition: background-color 0.3s;
    }
    .search-bar button:hover {
      background-color: #423add;
    }
    nav {
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      gap: 15px;
      padding: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    nav a {
      color: #151514;
      text-decoration: none;
      font-weight: bold;
      padding: 10px 20px;
      background-color: #f8fbff;
      border-radius: 25px;
      transition: all 0.3s;
      border: none;
    }
    nav a:hover {
      background-color: #423add;
      color: white;
      transform: translateY(-2px);
    }
    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      position: relative;
      top: -50px;
    }
    main {
      padding: 40px 20px;
      max-width: 800px;
      margin: 0 auto;
      text-align: center;
      position: relative;
      top: -90px;
    }
    hr {
      border: none;
      height: 1px;
      background-color: #ddd;
      margin: 25px auto;
      width: 80%;
    }
    .welcome {
      font-size: 24px;
      font-weight: bold;
      color: #4F46E5;
      margin-bottom: 20px;
      position: relative;
      top: -80px;
    }
    .description {
      font-size: 18px;
      line-height: 1.6;
    }
    section {
      position: relative;
      top: -100px;
    }
  .books-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 25px;
      padding: 30px;
    }
    .book-card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: transform 0.3s;
      height: 400px;
    }
    .book-card:hover {
      transform: translateY(-5px);
    }
    .book-cover {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .book-details {
      padding: 15px;
    }
    .book-title {
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 5px;
      position: relative;
      top: -100;
    }
    .book-author {
      color: #666;
      margin-bottom: 10px;
    }
    .book-status {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 15px;
      font-size: 14px;
    }
    .available {
      background-color: #e6f7ee;
      color: #28a745;
    }
    .unavailable {
      background-color: #fee;
      color: #dc3545;
    }
    .book-actions {
      display: flex;
      gap: 10px;
      margin-top: 15px;
    }
    .book-btn {
      flex: 1;
      padding: 8px;
      border-radius: 5px;
      text-align: center;
      text-decoration: none;
      font-weight: bold;
      transition: all 0.3s;
    }
    .details-btn {
      background-color: #f0f0f0;
      color: #333;
    }
    .details-btn:hover {
      background-color: #ddd;
    }
    .borrow-btn {
      background-color: #423add;
      color: white;
    }
    .borrow-btn:hover {
      background-color: #4F46E5;
    }
    /* الزر الدائري في الزاوية اليسرى العلوية */
    .top-left-button {
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 200;
    }
    .top-left-button button {
      background-color: #4F46E5;
      border: none;
      color: white;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      font-size: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .top-left-button button:hover {
      background-color: #3e3abf;
    }
  footer {
      text-align: center;
      padding: 20px;
      background-color: #4F46E5;
      color: white;
      margin-top: 200px;
    }
    /* كرت معلومات المستخدم */
    .user-info-card {
      max-width: 300px;
      background-color: #f4f4f4;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
      position: fixed;
      top: 80px;
      left: 20px;
      display: none;
      z-index: 199;
      direction: rtl;
    }
    .user-details p {
      margin: 10px 0;
      font-size: 16px;
    }
    .logout-btn {
      background-color: #dc3545;
      color: white;
      padding: 10px 18px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-top: 10px;
    }
    .logout-btn:hover {
      background-color: #c82333;
    }

    @media (max-width: 768px) {
      nav {
        flex-wrap: wrap;
        gap: 10px;
      }
      nav a {
        padding: 8px 15px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

  <!-- زر المعلومات في الأعلى يسار -->
  <div class="top-left-button">
    <button onclick="toggleUserInfo()">
      <i class="fas fa-user"></i>
    </button>
  </div>

  <!-- واجهة معلومات المستخدم المنبثقة -->
  <div class="user-info-card" id="userCard">
    <div class="user-details">
      <p><strong>الصفة:</strong> <span id="userInfoUserType"></span></p>
      <p><strong>الاسم الأول:</strong> <span id="userInfoFirstName"></span></p>
      <p><strong>اسم العائلة:</strong> <span id="userInfoLastName"></span></p>
      <p><strong>العنوان:</strong> <span id="userInfoAddress"></span></p>
      <p><strong>المدينة:</strong> <span id="userInfoCity"></span></p>
      <p><strong>رقم الهاتف:</strong> <span id="userInfoPhone"></span></p>
      <p><strong>البريد الإلكتروني:</strong> <span id="userInfoEmail"></span></p>

      <!-- قسم الأستاذ -->
      <div id="userInfoProfessorSection" style="display: none;">
        <p><strong>الانتماء:</strong> <span id="userInfoAffiliation"></span></p>
      </div>

      <!-- قسم الطالب -->
      <div id="userInfoStudentSection" style="display: none;">
        <p><strong>رقم التسجيل:</strong> <span id="userInfoRegistrationNumber"></span></p>
        <p><strong>المستوى:</strong> <span id="userInfoLevel"></span></p>
        <p><strong>السنة الأكاديمية:</strong> <span id="userInfoAcademicYear"></span></p>
        <p><strong>التخصص:</strong> <span id="userInfoSpecialty"></span></p>
      </div>

      <!-- قسم العامل -->
      <div id="userInfoEmployerSection" style="display: none;">
        <p><strong>معرّف العامل:</strong> <span id="userInfoEmployerId"></span></p>
      </div>

      <button class="logout-btn">تسجيل الخروج</button>
    </div>
  </div>

  <header>
    <img src="/image/pexels-olga-volkovitskaia-131638009-17406787.jpg" class="header-image" alt="خلفية المكتبة">
    <div class="header-content">
      <h1>منصة إدارة المكتبة</h1>
      <p>مرحباً بك في النظام الإلكتروني للمكتبة</p>
      <div class="description" style="font-weight: bold;">إبحث عن كتاب، مؤلف، أو تصنيف...</div>
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="ابحث عن كتاب، مؤلف أو تصنيف...">
        <button onclick="searchBooks()"><i class="fas fa-search"></i></button>
      </div>
    </div>
  </header>

  <nav>
    <a href="{{ route('home') }}">الصفحة الرئيسية</a>
    <a href="{{ route('books.index') }}">قائمة الكتب</a>
    <a href="{{ route('about') }}">حول كتابي</a>
    <a href="{{ route('mybooks.index') }}" class="active">كتبي المستعارة</a>
    <a href="manage-accounts.html">لوحة التحكم</a>
  </nav>
  <div class="logo-container">
    <img src="../image/20250429_000806(2).png" alt="لوجو " style="width: 300px;height:auto;">
  </div>
  <main>
    <div class="welcome" style="color: #4928ce;">أهلاً بك في كتابي </div>
    <div class="description" style="color: #151514;">يمكنك من خلال هذه المنصة إدارة كافة عمليات استعارة وإضافة الكتب بكل سهولة واحترافية.</div>
    <hr>
  </main>
  <section class="books-section">
    <h2 class="section-title" style="color: #423add;text-align: center;">آخر الكتب المضافة</h2>
    <div id="booksContainer" class="books-container">
      <!-- الكتب ستظهر هنا تلقائياً -->
    </div>
  </section>

  <footer>
    © 2025 منصة إدارة المكتبة. جميع الحقوق محفوظة.
  </footer>

  <script>
    function toggleUserInfo() {
      const card = document.getElementById("userCard");
      if (card.style.display === "none" || card.style.display === "") {
        populateUserInfo();
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    }

    function populateUserInfo() {
      // Assuming user data is stored in localStorage under the key 'currentUser'
      const currentUser = JSON.parse(localStorage.getItem('currentUser'));

      if (currentUser) {
        document.getElementById('userInfoUserType').textContent = currentUser.userType || 'غير محدد';
        document.getElementById('userInfoFirstName').textContent = currentUser.firstName || 'غير محدد';
        document.getElementById('userInfoLastName').textContent = currentUser.lastName || 'غير محدد';
        document.getElementById('userInfoAddress').textContent = currentUser.address || 'غير محدد';
        document.getElementById('userInfoCity').textContent = currentUser.city || 'غير محدد';
        document.getElementById('userInfoPhone').textContent = currentUser.phone || 'غير محدد';
        document.getElementById('userInfoEmail').textContent = currentUser.email || 'غير محدد';

        // Hide all user type sections initially
        document.getElementById('userInfoProfessorSection').style.display = 'none';
        document.getElementById('userInfoStudentSection').style.display = 'none';
        document.getElementById('userInfoEmployerSection').style.display = 'none';

        // Display the relevant section based on user type
        if (currentUser.userType === 'professor') {
          document.getElementById('userInfoProfessorSection').style.display = 'block';
          document.getElementById('userInfoAffiliation').textContent = currentUser.affiliation || 'غير محدد';
        } else if (currentUser.userType === 'student') {
          document.getElementById('userInfoStudentSection').style.display = 'block';
          document.getElementById('userInfoRegistrationNumber').textContent = currentUser.registrationNumber || 'غير محدد';
          document.getElementById('userInfoLevel').textContent = currentUser.level || 'غير محدد';
          document.getElementById('userInfoAcademicYear').textContent = currentUser.academicYear || 'غير محدد';
          document.getElementById('userInfoSpecialty').textContent = currentUser.specialty || 'غير محدد';
        } else if (currentUser.userType === 'employer') {
          document.getElementById('userInfoEmployerSection').style.display = 'block';
          document.getElementById('userInfoEmployerId').textContent = currentUser.employerId || 'غير محدد';
        }
      } else {
        // Handle case where no user is logged in or data is missing
        document.getElementById('userInfoUserType').textContent = 'غير متوفر';
        document.getElementById('userInfoFirstName').textContent = 'غير متوفر';
        document.getElementById('userInfoLastName').textContent = 'غير متوفر';
        document.getElementById('userInfoAddress').textContent = 'غير متوفر';
        document.getElementById('userInfoCity').textContent = 'غير متوفر';
        document.getElementById('userInfoPhone').textContent = 'غير متوفر';
        document.getElementById('userInfoEmail').textContent = 'غير متوفر';
         // Hide all user type sections
        document.getElementById('userInfoProfessorSection').style.display = 'none';
        document.getElementById('userInfoStudentSection').style.display = 'none';
        document.getElementById('userInfoEmployerSection').style.display = 'none';
      }
    }

    function searchBooks() {
      const query = document.getElementById('searchInput').value;
      alert("تم البحث عن: " + query);
    }
  </script>

  <script>
    // دالة لتحميل الكتب من localStorage
    function loadBooks() {
      const books = JSON.parse(localStorage.getItem('books')) || [];
      return books;
    }

    // دالة لعرض الكتب
    function displayBooks(booksToShow = null) {
      const booksContainer = document.getElementById('booksContainer');
      let books = booksToShow || loadBooks();

      // ترتيب الكتب من الأحدث إلى الأقدم
      books = books.sort((a, b) => new Date(b.addedDate) - new Date(a.addedDate));

      // عرض فقط 6 كتب كحد أقصى في الصفحة الرئيسية
      const recentBooks = books.slice(0, 6);

      if (recentBooks.length === 0) {
        booksContainer.innerHTML = `
          <div class="no-books">
            <i class="fas fa-book-open" style="font-size: 50px; color: #ccc; margin-bottom: 15px;"></i>
            <p>لا توجد كتب متاحة حالياً</p>
          </div>
        `;
        return;
      }

      booksContainer.innerHTML = recentBooks.map((book, index) => `
        <div class="book-card">
          <img src="${book.image || 'https://via.placeholder.com/300x250?text=لا+يوجد+غلاف'}"
               alt="${book.title}"
               class="book-cover">
          <div class="book-details">
            <div class="book-title">${book.title}</div>
            <div class="book-author">${book.author}</div>
            <div class="book-status ${book.status === 'متوفر' ? 'available' : 'unavailable'}">
              ${book.status}
            </div>
            <div class="book-actions">
              <a href="book_detail.html?id=${index}" class="book-btn details-btn">التفاصيل</a>
              <a href="Etudiants/borrowedBooks.html" class="book-btn borrow-btn">استعارة</a>
            </div>
          </div>
        </div>
      `).join('');
    }

    // دالة البحث عن الكتب
    function searchBooks() {
      const searchTerm = document.getElementById('searchInput').value.trim().toLowerCase();
      const allBooks = loadBooks();

      if (!searchTerm) {
        displayBooks();
        return;
      }

      const filteredBooks = allBooks.filter(book => {
        const titleMatch = book.title.toLowerCase().includes(searchTerm);
        const authorMatch = book.author.toLowerCase().includes(searchTerm);
        const categoryMatch = book.category && book.category.toLowerCase().includes(searchTerm);
        return titleMatch || authorMatch || categoryMatch;
      });

      displayBooks(filteredBooks);
    }

    // البحث عند الضغط على Enter
    document.getElementById('searchInput').addEventListener('keyup', (e) => {
      if (e.key === 'Enter') searchBooks();
    });

    // تحميل الكتب عند فتح الصفحة
    window.addEventListener('DOMContentLoaded', () => {
      displayBooks();

      // تحديث تلقائي عند تغيير localStorage
      window.addEventListener('storage', () => {
        displayBooks();
      });
    });

  </script>
</body>
</html>
