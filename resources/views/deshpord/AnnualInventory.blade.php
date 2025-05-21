<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>جرد الكتب | منصة كتابي</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #4F46E5;
      --secondary-color: #423add;
      --text-color: #333;
      --light-bg: #f5f7fa;
    }
    body {
      font-family: 'Tajawal', sans-serif;
      margin: 0;
      padding: 0;
      background-color: var(--light-bg);
      color: var(--text-color);
      height: 100%;
    }
    .sidebar {
      width: 250px;
      background-color: white;
      position: fixed;
      top: 0;
      right: 0;
      height: 100vh;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      padding: 20px 0;
    }
    .sidebar-header {
      text-align: center;
      padding: 20px;
      border-bottom: 1px solid #eee;
      margin-bottom: 20px;
    }
    .sidebar-title {
      color: var(--primary-color);
      margin: 10px 0 0;
    }
    .nav-links {
      list-style: none;
      padding: 0;
    }
    .nav-links li a {
      display: block;
      padding: 12px 25px;
      color: var(--text-color);
      text-decoration: none;
      transition: all 0.3s;
      font-weight: bold;
    }
    .nav-links li a:hover,
    .nav-links li a.active {
      background-color: var(--light-bg);
      color: var(--primary-color);
      border-right: 4px solid var(--primary-color);
    }
    .nav-links li a i {
      margin-left: 10px;
      width: 20px;
      text-align: center;
    }
    .main-content {
      margin-right: 250px;
      padding: 30px;
    }
    h1 {
      color: var(--primary-color);
      text-align: center;
      margin-bottom: 30px;
    }
    .inventory-table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }
    .inventory-table th, .inventory-table td {
      padding: 12px 15px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }
    .inventory-table th {
      background-color: var(--primary-color);
      color: white;
    }
    .action-btn {
      padding: 6px 12px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
      font-family: 'Tajawal';
      margin: 0 3px;
    }
    .status-btn {
      padding: 6px 12px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-family: 'Tajawal';
    }
    .good-condition {
      background-color: #28a745;
      color: white;
    }
    .damaged {
      background-color: #dc3545;
      color: white;
    }
    .search-box {
      margin-bottom: 20px;
      display: flex;
      gap: 10px;
    }
    .search-box input {
      flex: 1;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-family: 'Tajawal';
    }
    .search-box button {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 0 20px;
      border-radius: 4px;
      cursor: pointer;
    }
    footer {
      text-align: center;
      padding: 20px;
      background-color: var(--primary-color);
      color: white;
      margin-right: 250px;
      margin-top: 100%;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="sidebar-header">
      <i class="fas fa-book" style="font-size: 30px; color: var(--primary-color);"></i>
      <h3 class="sidebar-title">لوحة الموظف</h3>
    </div>
    <ul class="nav-links">
      <li><a href="gerelbbok.html"><i class="fas fa-book"></i> إدارة الكتب</a></li>
      <li><a href="manage-accounts.html"><i class="fas fa-users"></i> إدارة الحسابات</a></li>
      <li><a href="messag.html"><i class="fas fa-bell"></i> الإشعارات</a></li>
      <li><a href="registerloan.html"><i class="fas fa-history"></i> سجل الإعارة</a></li>
      <li><a href="registerloan.html"><i class="fas fa-calendar-plus"></i> طلبات التمديد</a></li>
      <li><a href="barren.html" class="active"><i class="fas fa-clipboard-check"></i> جرد </a></li>
      <li><a href="DAR-AINasher.html"><i class="fas fa-building"></i> دور النشر</a></li>
      <li><a href="book-requests.html"><i class="fas fa-clipboard-list"></i> طلبات توفير الكتب</a></li>
      <li><a href="approved-books.html" ><i class="fas fa-check-circle"></i> الموافقة على الكتب</a></li>
    </ul>
  </div>

  <div class="main-content">
    <h1><i class="fas fa-clipboard-check"></i> جرد الكتب</h1>
    <div class="search-box">
      <input type="text" id="searchInput" placeholder="ابحث برقم RGE أو اسم الكتاب">
      <button onclick="searchBooks()"><i class="fas fa-search"></i></button>
    </div>
    <table class="inventory-table">
      <thead>
        <tr>
          <th>#</th>
          <th>رقم RGE</th>
          <th>عنوان الكتاب</th>
          <th>المؤلف</th>
          <th>حالة الكتاب</th>
          <th>تغيير الحالة</th>
        </tr>
      </thead>
      <tbody id="inventoryTableBody">
        <!-- البيانات تُملأ تلقائيًا -->
      </tbody>
    </table>

    <div id="statsContainer" style="margin-top: 30px; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
      <!-- Statistics will be loaded here -->
    </div>
  </div>

  <footer>
    © 2025 منصة كتابي - جميع الحقوق محفوظة
  </footer>

  <script>
    let booksInventory = [];

    // تحديث الإحصائيات
    function updateStatistics() {
      const statsContainer = document.getElementById('statsContainer');

      // حساب الإحصائيات
      const totalBooks = booksInventory.length;
      const goodBooks = booksInventory.filter(book => !book.isDamaged).length;
      const damagedBooks = booksInventory.filter(book => book.isDamaged).length;

      statsContainer.innerHTML = `
        <div class="stat-card" style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; min-width: 150px;">
          <div class="stat-icon" style="font-size: 30px; color: var(--primary-color);"><i class="fas fa-book"></i></div>
          <div class="stat-value" style="font-size: 24px; font-weight: bold; margin-top: 5px;">${totalBooks}</div>
          <div class="stat-label" style="font-size: 14px; color: #555;">إجمالي الكتب</div>
        </div>

        <div class="stat-card" style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; min-width: 150px;">
          <div class="stat-icon" style="font-size: 30px; color: #28a745;"><i class="fas fa-check-circle"></i></div>
          <div class="stat-value" style="font-size: 24px; font-weight: bold; margin-top: 5px;">${goodBooks}</div>
          <div class="stat-label" style="font-size: 14px; color: #555;">كتب جيدة</div>
        </div>

        <div class="stat-card" style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; min-width: 150px;">
          <div class="stat-icon" style="font-size: 30px; color: #dc3545;"><i class="fas fa-times-circle"></i></div>
          <div class="stat-value" style="font-size: 24px; font-weight: bold; margin-top: 5px;">${damagedBooks}</div>
          <div class="stat-label" style="font-size: 14px; color: #555;">كتب تالفة</div>
        </div>
      `;
    }

    // تحميل الكتب من التخزين المحلي
    function loadBooksFromStorage() {
      const storedBooks = localStorage.getItem("books");
      if (storedBooks) {
        const parsedBooks = JSON.parse(storedBooks);
        booksInventory = parsedBooks.map((book, index) => ({
          id: index + 1,
          rgeNumber: book.classification || "RGE-XXXX",
          title: book.title || "بدون عنوان",
          author: book.author || "مجهول",
          isDamaged: false // افتراضيًا جيد
        }));
      }
    }

    function renderInventory(filteredList = null) {
      const list = filteredList || booksInventory;
      const tbody = document.getElementById("inventoryTableBody");
      tbody.innerHTML = "";

      if (list.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="6" style="text-align: center; padding: 30px;">
              <i class="fas fa-box-open" style="font-size: 50px; color: #ccc;"></i>
              <p>لا توجد كتب في الجرد</p>
            </td>
          </tr>`;
        updateStatistics(); // Update statistics even if no books
        return;
      }

      list.forEach((book, index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${index + 1}</td>
          <td>${book.rgeNumber}</td>
          <td>${book.title}</td>
          <td>${book.author}</td>
          <td>
            <span class="status-btn ${book.isDamaged ? 'damaged' : 'good-condition'}">
              ${book.isDamaged ? 'تالف' : 'جيد'}
            </span>
          </td>
          <td>
            <button class="action-btn" onclick="toggleBookStatus(${book.id})">
              <i class="fas fa-sync-alt"></i> تغيير
            </button>
          </td>`;
        tbody.appendChild(row);
      });
    }

    function toggleBookStatus(bookId) {
      const book = booksInventory.find(b => b.id === bookId);
      if (book) {
        book.isDamaged = !book.isDamaged;
        renderInventory();
        updateStatistics(); // Update statistics after toggling status
        alert(`تم تغيير حالة الكتاب إلى ${book.isDamaged ? 'تالف' : 'جيد'}`);
      }
    }

    function searchBooks() {
      const term = document.getElementById("searchInput").value.toLowerCase();
      if (!term) {
        renderInventory();
        return;
      }
      const filtered = booksInventory.filter(book =>
        book.rgeNumber.toLowerCase().includes(term) ||
        book.title.toLowerCase().includes(term)
      );
      renderInventory(filtered);
    }

    window.onload = () => {
      loadBooksFromStorage();
      renderInventory();
      updateStatistics(); // Initial statistics load
    };
  </script>
</body>
</html>
