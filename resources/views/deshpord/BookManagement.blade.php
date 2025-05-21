<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إدارة الكتب | منصة إدارة المكتبة</title>
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
    }
    
    /* الشريط الجانبي - نفس تنسيق لوحة التحكم */
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
    
    /* المحتوى الرئيسي */
    .main-content {
      margin-right: 250px;
      padding: 30px;
      padding-bottom: 150px; /* مساحة للإحصائيات في الأسفل */
    }
    
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    
    .page-title {
      color: var(--primary-color);
      margin: 0;
    }
    
    /* جدول الكتب */
    .books-table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
      margin-bottom: 30px;
    }
    
    .books-table th, .books-table td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }
    
    .books-table th {
      background-color: var(--primary-color);
      color: white;
      font-weight: bold;
    }
    
    .books-table tr:hover {
      background-color: #f9f9f9;
    }
    
    /* أزرار الإجراءات */
    .action-btn {
      padding: 6px 12px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
      font-family: 'Tajawal';
      margin: 0 3px;
    }
    
    .edit-btn {
      background-color: #ffc107;
      color: #212529;
    }
    
    .delete-btn {
      background-color: #dc3545;
      color: white;
    }
    
    .details-btn {
      background-color: #17a2b8;
      color: white;
    }
    
    .add-btn {
      background-color: var(--primary-color);
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    
    .action-btn:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }
    
    /* نموذج التعديل */
    .modal {
      display: none;
      position: fixed;
      z-index: 100;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
    }
    
    .modal-content {
      background-color: white;
      margin: 5% auto;
      padding: 25px;
      border-radius: 8px;
      width: 80%;
      max-width: 600px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .close-btn {
      float: left;
      font-size: 24px;
      cursor: pointer;
      color: #aaa;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    
    .form-group input, 
    .form-group select, 
    .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-family: 'Tajawal';
    }
    
    .form-actions {
      text-align: center;
      margin-top: 20px;
    }
    
    .save-btn {
      background-color: var(--primary-color);
      color: white;
      padding: 10px 25px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-family: 'Tajawal';
      font-weight: bold;
    }
    
    /* رسائل التنبيه */
    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 4px;
      text-align: center;
    }
    
    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }
    
    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
    }
    
    /* الفوتر */
    footer {
      text-align: center;
      padding: 20px;
      background-color: var(--primary-color);
      color: white;
      margin-right: 250px;
    }
    
    /* حالة الكتاب */
    .status-badge {
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 14px;
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
    
    /* قسم الإحصائيات الجديد */
    .stats-section {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 20px;
      margin-top: 30px;
    }
    
    .stats-title {
      color: var(--primary-color);
      margin-top: 0;
      margin-bottom: 20px;
      text-align: center;
    }
    
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }
    
    .stat-card {
      background-color: var(--light-bg);
      border-radius: 8px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .stat-value {
      font-size: 28px;
      font-weight: bold;
      color: var(--primary-color);
      margin: 10px 0;
    }
    
    .stat-label {
      color: var(--text-color);
      font-size: 14px;
    }
    
    .stat-icon {
      font-size: 24px;
      color: var(--primary-color);
    }
  </style>
</head>
<body>
  <!-- الشريط الجانبي -->
  <div class="sidebar">
    <div class="sidebar-header">
      <i class="fas fa-book" style="font-size: 30px; color: var(--primary-color);"></i>
      <h3 class="sidebar-title">لوحة التحكم</h3>
    </div>
    <ul class="nav-links">
      <li><a href="gerelbbok.html"class="active"><i class="fas fa-book"></i> إدارة الكتب</a></li>
      <li><a href="manage-accounts.html"><i class="fas fa-users"></i> إدارة الحسابات</a></li>
      <li><a href="messag.html"><i class="fas fa-bell"></i> الإشعارات</a></li>
      <li><a href="registerloan.html"><i class="fas fa-history"></i> سجل الإعارة</a></li>
      <li><a href="ordermang.html"><i class="fas fa-calendar-plus"></i> طلبات التمديد</a></li>
     <li><a href="barren.html" ><i class="fas fa-clipboard-check"></i> جرد </a></li>
      <li><a href="DAR-AINasher.html"><i class="fas fa-building"></i> دور النشر</a></li>
      <li><a href="book-requests.html"><i class="fas fa-clipboard-list"></i> طلبات توفير الكتب</a></li>
      <li><a href="approved-books.html" ><i class="fas fa-check-circle"></i> الموافقة على الكتب</a></li>
    </ul>
  </div>
  <!-- المحتوى الرئيسي -->
  <div class="main-content">
    <div class="page-header">
      <h1 class="page-title">إدارة الكتب</h1>
      <a href="add-book.html" class="add-btn">
        <i class="fas fa-plus"></i> إضافة كتاب جديد
      </a>
    </div>
    
    <div id="alertMessage" style="display: none;"></div>
    
    <table class="books-table">
      <thead>
        <tr>
          <th>#</th>
          <th>صورة الكتاب</th>
          <th>عنوان الكتاب</th>
          <th>المؤلف</th>
          <th>التصنيف</th>
          <th>الحالة</th>
          <th>الإجراءات</th>
        </tr>
      </thead>
      <tbody id="booksTableBody">
        <!-- سيتم ملء الجدول من خلال JavaScript -->
      </tbody>
    </table>
    
    <!-- قسم الإحصائيات الجديد -->
    <div class="stats-section">
      <h2 class="stats-title">إحصائيات المكتبة</h2>
      <div class="stats-grid" id="statsContainer">
        <!-- سيتم ملؤها من خلال JavaScript -->
      </div>
    </div>
  </div>

  <!-- نموذج تعديل الكتاب -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h2 style="text-align: center; color: var(--primary-color);">تعديل بيانات الكتاب</h2>
      
      <form id="editBookForm">
        <input type="hidden" id="editBookId">
        
        <div class="form-group">
          <label for="editTitle">عنوان الكتاب</label>
          <input type="text" id="editTitle" required>
        </div>
        
        <div class="form-group">
          <label for="editAuthor">المؤلف</label>
          <input type="text" id="editAuthor" required>
        </div>
        
        <div class="form-group">
          <label for="editCategory">التصنيف</label>
          <input type="text" id="editCategory" required>
        </div>
        
        <div class="form-group">
          <label for="editStatus">حالة الكتاب</label>
          <select id="editStatus" required>
            <option value="متوفر">متوفر</option>
            <option value="مستعار">مستعار</option>
            <option value="تحت الصيانة">تحت الصيانة</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="editDescription">وصف الكتاب</label>
          <textarea id="editDescription" rows="4"></textarea>
        </div>
        
        <div class="form-group">
          <label for="editImage">رابط صورة الكتاب</label>
          <input type="text" id="editImage" placeholder="https://example.com/book.jpg">
        </div>
        
        <div class="form-actions">
          <button type="submit" class="save-btn">حفظ التعديلات</button>
        </div>
      </form>
    </div>
  </div>

  <footer>
    © 2025 منصة إدارة المكتبة. جميع الحقوق محفوظة.
  </footer>

  <script>
    // متغيرات عامة
    let books = JSON.parse(localStorage.getItem('books')) || [];
    let currentEditId = null;

    // عرض الكتب في الجدول
    function renderBooksTable() {
      const tbody = document.getElementById('booksTableBody');
      tbody.innerHTML = '';
      
      if (books.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="7" style="text-align: center; padding: 30px;">
              <i class="fas fa-book-open" style="font-size: 50px; color: #ccc;"></i>
              <p>لا توجد كتب متاحة حالياً</p>
            </td>
          </tr>
        `;
        return;
      }
      
      books.forEach((book, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${index + 1}</td>
          <td><img src="${book.image || 'https://via.placeholder.com/60x80?text=لا+يوجد+صورة'}" 
                   alt="${book.title}" 
                   style="width: 60px; height: 80px; object-fit: cover;"></td>
          <td>${book.title}</td>
          <td>${book.author}</td>
          <td>${book.category || 'غير مصنف'}</td>
          <td><span class="status-badge ${book.status === 'متوفر' ? 'available' : 'unavailable'}">
              ${book.status}
            </span>
          </td>
          <td>
            <button class="action-btn details-btn" onclick="viewBookDetails(${index})">
              <i class="fas fa-eye"></i> تفاصيل
            </button>
            <button class="action-btn edit-btn" onclick="openEditModal(${index})">
              <i class="fas fa-edit"></i> تعديل
            </button>
            <button class="action-btn delete-btn" onclick="confirmDelete(${index})">
              <i class="fas fa-trash"></i> حذف
            </button>
          </td>
        `;
        tbody.appendChild(row);
      });
      
      // تحديث الإحصائيات بعد عرض الكتب
      updateStatistics();
    }

    // تحديث الإحصائيات
    function updateStatistics() {
      const statsContainer = document.getElementById('statsContainer');
      
      // حساب الإحصائيات
      const totalBooks = books.length;
      const availableBooks = books.filter(book => book.status === 'متوفر').length;
      const borrowedBooks = books.filter(book => book.status === 'مستعار').length;
      const categories = [...new Set(books.map(book => book.category || 'غير مصنف'))].length;
      
      statsContainer.innerHTML = `
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-book"></i></div>
          <div class="stat-value">${totalBooks}</div>
          <div class="stat-label">إجمالي الكتب</div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
          <div class="stat-value">${availableBooks}</div>
          <div class="stat-label">كتب متاحة</div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-exchange-alt"></i></div>
          <div class="stat-value">${borrowedBooks}</div>
          <div class="stat-label">كتب مستعارة</div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-tags"></i></div>
          <div class="stat-value">${categories}</div>
          <div class="stat-label">تصنيفات مختلفة</div>
        </div>
      `;
    }

    // عرض تفاصيل الكتاب
    function viewBookDetails(bookId) {
      const book = books[bookId];
      alert(`
        عنوان الكتاب: ${book.title || 'بدون عنوان'}
        المؤلف: ${book.author || 'مؤلف غير معروف'}
        عدد الصفحات: ${book.pages || 'غير معروف'}
        رقم التصنيف: ${book.classNo || 'غير معروف'}
        الكمية: ${book.copies || 'غير معروف'}
        الفئة: ${book.classification || 'غير مصنف'}
        حالة النسخة: ${book.status || 'غير معروف'}
        دار النشر: ${book.publisher || 'غير معروف'}
      `);
    }

    // فتح نموذج التعديل
    function openEditModal(bookId) {
      const book = books[bookId];
      currentEditId = bookId;
      
      document.getElementById('editBookId').value = bookId;
      document.getElementById('editTitle').value = book.title;
      document.getElementById('editAuthor').value = book.author;
      document.getElementById('editCategory').value = book.category || '';
      document.getElementById('editStatus').value = book.status;
      document.getElementById('editDescription').value = book.description || '';
      document.getElementById('editImage').value = book.image || '';
      
      document.getElementById('editModal').style.display = 'block';
    }

    // حفظ التعديلات
    document.getElementById('editBookForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const bookId = currentEditId;
      books[bookId] = {
        ...books[bookId],
        title: document.getElementById('editTitle').value,
        author: document.getElementById('editAuthor').value,
        category: document.getElementById('editCategory').value,
        status: document.getElementById('editStatus').value,
        description: document.getElementById('editDescription').value,
        image: document.getElementById('editImage').value || undefined
      };
      
      localStorage.setItem('books', JSON.stringify(books));
      closeModal();
      renderBooksTable();
      showAlert('تم تحديث بيانات الكتاب بنجاح', 'success');
    });

    // تأكيد الحذف
    function confirmDelete(bookId) {
      if (confirm('هل أنت متأكد من حذف هذا الكتاب؟ لا يمكن التراجع عن هذه العملية.')) {
        books.splice(bookId, 1);
        localStorage.setItem('books', JSON.stringify(books));
        renderBooksTable();
        showAlert('تم حذف الكتاب بنجاح', 'success');
      }
    }

    // إغلاق النموذج
    function closeModal() {
      document.getElementById('editModal').style.display = 'none';
      currentEditId = null;
    }

    // عرض رسائل التنبيه
    function showAlert(message, type) {
      const alertDiv = document.getElementById('alertMessage');
      alertDiv.innerHTML = message;
      alertDiv.className = `alert alert-${type}`;
      alertDiv.style.display = 'block';
      
      setTimeout(() => {
        alertDiv.style.display = 'none';
      }, 3000);
    }

    // تحميل الصفحة
    window.onload = function() {
      renderBooksTable();
      
      // إغلاق النموذج عند النقر خارج المحتوى
      window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
          closeModal();
        }
      }
    };
  </script>
</body>
</html>
