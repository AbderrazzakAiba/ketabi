@extends('layouts.app')
@section('content')
<!DOCTYPE html>
< lang="ar" dir="rtl">
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
    }
    header {
      color: white;
      text-align: center;
      position: relative;
      height: 400px;
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
      position: relative;
      top: -70px;

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
    }
    nav a {
      color: #151514;
      text-decoration: none;
      font-weight: bold;
      padding: 10px 20px;
      background-color: #f8fbff;
      border-radius: 25px;
      border: 1px solid #ddd;
      transition: all 0.3s;
    }
    nav a:hover {
      background-color: #423add;
      color: white;
    }
    .auth-buttons {
      position: absolute;
      top: 20px;
      left: 20px;
      display: flex;
      gap: 10px;
      z-index: 3;
    }
    .auth-button {
      width: 120px;
      height: 40px;
      font-size: 14px;
      color: white;
      background-color: #423add;
      border-radius: 25px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
      text-decoration: none;
      transition: all 0.3s;
    }
    main {
      padding: 40px 20px;
      max-width: 800px;
      margin: 0 auto;
      text-align: center;
    }
    .welcome {
      font-size: 24px;
      font-weight: bold;
      color: #4F46E5;
      margin-bottom: 20px;
    }
    .description {
      font-size: 18px;
      line-height: 1.6;
      color: #333;
    }
    hr {
      border: none;
      height: 1px;
      background-color: #ddd;
      margin: 25px auto;
      width: 80%;
    }
    .books-section {
      padding: 20px;
      background-color: #f8f9fa;
    }
    .section-title {
      text-align: center;
      font-size: 28px;
      color: #423add;
      margin-bottom: 30px;
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
    footer {
      text-align: center;
      padding: 20px;
      background-color: #4F46E5;
      color: white;
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
      margin-bottom: -90px;

    }
  </style>
</head>
<bo>
  <div class="auth-buttons">
    <a href="Genaralhome/Login.html" class="auth-button">
      <i class="fas fa-sign-in-alt"></i> دخول
    </a>
    <a href="verive.html" class="auth-button">
      <i class="fas fa-user-plus"></i> تسجيل
    </a>
  </div>

  <header>
    <img src="image/pexels-olga-volkovitskaia-131638009-17406787.jpg" class="header-image" alt="خلفية المكتبة">
    <div class="header-content">
      <div class="logo-container">
        <img src="../image/20250429_000806(2).png" alt="لوجو " style="width: 300px;height:auto;">
        </div>
      <h1>منصة إدارة المكتبة</h1>
      <p>مرحباً بك في النظام الإلكتروني للمكتبة</p>
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="ابحث عن كتاب، مؤلف أو تصنيف...">
        <button onclick="searchBooks()"><i class="fas fa-search"></i></button>
      </div>
    </div>
  </header>

  <nav>
    <a href="index.html" style="background-color: #423add; color: white;">الصفحة الرئيسية</a>
    <a href="booklist.html">قائمة الكتب</a>
    <a href="about.html">حول كتابي</a>

    <a href="telme.html" class="active">اتصل بنا</a>
    <a href="manage-accounts.html">لوحة التحكم</a>
  </nav>

  <main>
    <div class="welcome">أهلاً بك في مكتبة المعرفة</div>
    <div class="description">يمكنك من خلال هذه المنصة إدارة كافة عمليات استعارة وإضافة الكتب بكل سهولة واحترافية.</div>
    <hr>
    <div class="description" style="font-weight: bold;">إبحث عن كتاب، مؤلف، أو تصنيف...</div>
  </main>

  <section class="books-section">
    <h2 class="section-title">آخر الكتب المضافة</h2>
    <div id="booksContainer" class="books-container">
        @foreach ($books as $book)

        <div class="book-card">
            <img src="${book.image || 'https://via.placeholder.com/300x250?text=لا+يوجد+غلاف'}"
            alt="{{ $book->title}}"
            class="book-cover">
            <div class="book-details">
                <div class="book-title">{{ $book->title}}</div>
                <div class="book-author">{{ $book->author}}</div>
                <div class="book-status ${book.status === 'متوفر' ? 'available' : 'unavailable'}">
                    {{ $book->status}}
                </div>
                <div class="book-actions">
                    <a href="book_detail.html?id={{ $book->index}}" class="book-btn details-btn">التفاصيل</a>
                    <a href="Etudiants/borrows.html" class="book-btn borrow-btn">استعارة</a>
                </div>
            </div>
        </div>
        @endforeach
        <!-- الكتب ستظهر هنا تلقائياً -->
    </div>
  </section>

  <footer>
    © 2025 منصة إدارة المكتبة. جميع الحقوق محفوظة.
  </footer>

  <script>
    // عرض الكتب مع إمكانية البحث
    function displayBooks(booksToShow = null) {
      const booksContainer = document.getElementById('booksContainer');
      const books = booksToShow || JSON.parse(localStorage.getItem('books')) || [];

      if (books.length === 0) {
        booksContainer.innerHTML = `
          <div class="no-books">
            <i class="fas fa-book-open" style="font-size: 50px; color: #ccc; margin-bottom: 15px;"></i>
            <p>لا توجد كتب متاحة حالياً</p>
          </div>
        `;
        return;
      }

      booksContainer.innerHTML = books.map((book, index) => `

      `).join('');
    }

    // وظيفة البحث المتقدمة
    function searchBooks() {
      const searchTerm = document.getElementById('searchInput').value.trim().toLowerCase();
      const allBooks = JSON.parse(localStorage.getItem('books')) || [];

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

@endsection

