<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>طلبات الكتب | منصة إدارة المكتبة</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
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
    .sidebar {
      width: 250px;
      background-color: white;
      position: fixed;
      top: 0;
      right: 0;
      height: 100vh;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      padding: 20px 0;
      overflow-y: auto;
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
      margin: 0;
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
      padding-bottom: 150px;
      min-height: 100vh;
      background-color: var(--light-bg);
    }
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      flex-wrap: wrap;
      gap: 10px;
    }
    .page-title {
      color: var(--primary-color);
      margin: 0;
      font-size: 28px;
    }
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
      word-break: break-word;
    }
    .books-table th {
      background-color: var(--primary-color);
      color: white;
      font-weight: bold;
    }
    .books-table tr:hover {
      background-color: #f9f9f9;
    }
    .action-btn {
      padding: 6px 12px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
      font-family: 'Tajawal';
      margin: 0 3px;
      font-size: 14px;
    }
    .delete-btn {
      background-color: #dc3545;
      color: white;
    }
    .delete-btn:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }
    .add-book-btn {
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      user-select: none;
    }
    .add-book-btn:hover {
      background-color: #218838;
    }
    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 4px;
      display: none;
      font-weight: bold;
      text-align: center;
    }
    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }
    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
    }
    .status-badge {
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 14px;
      font-weight: bold;
      display: inline-block;
      min-width: 70px;
    }
    .pending {
      background-color: #fff3cd;
      color: #856404;
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      overflow-y: auto;
      padding: 40px 0;
    }
    .modal-content {
      background-color: white;
      margin: 0 auto;
      padding: 20px;
      border-radius: 8px;
      width: 90%;
      max-width: 600px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      position: relative;
    }
    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    .modal-title {
      color: var(--primary-color);
      margin: 0;
      font-size: 22px;
    }
    .close-btn {
      font-size: 28px;
      cursor: pointer;
      color: #aaa;
      user-select: none;
      transition: color 0.3s;
      background: none;
      border: none;
    }
    .close-btn:hover {
      color: #333;
    }
    .modal-body {
      margin-bottom: 20px;
      font-size: 16px;
      line-height: 1.5;
      color: var(--text-color);
    }
    .detail-row {
      display: flex;
      margin-bottom: 10px;
      flex-wrap: wrap;
    }
    .detail-label {
      font-weight: bold;
      width: 120px;
      flex-shrink: 0;
    }
    .detail-value {
      flex: 1;
      word-break: break-word;
    }
    footer {
      text-align: center;
      padding: 15px 0;
      background-color: #423add;
      color: #f9f9f9;
      font-size: 14px;
      box-shadow: 0 -1px 5px rgba(0,0,0,0.05);
      position: fixed;
      bottom: 0;
      right: 250px;
      width: calc(100% - 250px);
      user-select: none;
    }
    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        box-shadow: none;
      }
      .main-content {
        margin-right: 0;
        padding: 20px;
      }
      footer {
        right: 0;
        width: 100%;
        position: relative;
      }
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
      <li><a href="gerelbbok.html"><i class="fas fa-book"></i> إدارة الكتب</a></li>
      <li><a href="manage-accounts.html"><i class="fas fa-users"></i> إدارة الحسابات</a></li>
      <li><a href="messag.html"><i class="fas fa-bell"></i> الإشعارات</a></li>
      <li><a href="registerloan.html"><i class="fas fa-history"></i> سجل الإعارة</a></li>
      <li><a href="ordermang.html"><i class="fas fa-calendar-plus"></i> طلبات التمديد</a></li>
      <li><a href="barren.html" ><i class="fas fa-clipboard-check"></i> جرد </a></li>
      <li><a href="DAR-AINasher.html"><i class="fas fa-building"></i> دور النشر</a></li>
      <li><a href="book-requests.html" class="active"><i class="fas fa-clipboard-list"></i> طلبات توفير الكتب</a></li>
      <li><a href="approved-books.html" ><i class="fas fa-check-circle"></i> الموافقة على الكتب</a></li>
    </ul>
  </div>
  
  <!-- المحتوى الرئيسي -->
  <div class="main-content">
    <div class="page-header">
      <h1 class="page-title">طلبات الكتب</h1>
      <div>
        <a href="javascript:void(0)" class="add-book-btn" onclick="openAddBookModal()">
          <i class="fas fa-plus"></i> توفير كتاب 
        </a>
      </div>
    </div>
    
    <div id="alertMessage" class="alert"></div>
    
    <table class="books-table" aria-label="جدول طلبات الكتب">
      <thead>
        <tr>
          <th>#</th>
          <th>عنوان الكتاب</th>
          <th>المؤلف</th>
          <th>تاريخ الطلب</th>
          <th>الحالة</th>
          <th>الإجراءات</th>
        </tr>
      </thead>
      <tbody id="requestsTableBody">
        <!-- سيتم ملء الجدول من خلال JavaScript -->
      </tbody>
    </table>
  </div>

  <!-- مودال إضافة كتاب جديد -->
  <div id="addBookModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="addBookModalTitle" tabindex="-1">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="addBookModalTitle">إضافة كتاب جديد</h3>
        <button class="close-btn" aria-label="إغلاق" onclick="closeAddBookModal()">&times;</button>
      </div>
      <div class="modal-body">
        <form id="addBookForm">
          <div class="detail-row">
            <label class="detail-label" for="bookTitleInput">عنوان الكتاب:</label>
            <input type="text" id="bookTitleInput" name="bookTitle" required placeholder="أدخل عنوان الكتاب" style="flex:1; padding:6px; border-radius:4px; border:1px solid #ccc;" />
          </div>
          <div class="detail-row">
            <label class="detail-label" for="authorInput">المؤلف:</label>
            <input type="text" id="authorInput" name="author" required placeholder="أدخل اسم المؤلف" style="flex:1; padding:6px; border-radius:4px; border:1px solid #ccc;" />
          </div>
          <div class="detail-row">
            <label class="detail-label" for="requestDateInput">تاريخ الطلب:</label>
            <input type="date" id="requestDateInput" name="requestDate" required style="flex:1; padding:6px; border-radius:4px; border:1px solid #ccc;" />
          </div>
          <div style="text-align: center; margin-top: 20px;">
            <button type="submit" class="add-book-btn" style="padding: 10px 30px; font-size: 16px;">
              <i class="fas fa-plus"></i> إضافة
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <footer>
    © 2025 منصة إدارة المكتبة. جميع الحقوق محفوظة.
  </footer>

  <script>
    let requests = JSON.parse(localStorage.getItem('bookRequests')) || [
      {
        id: 1,
        bookTitle: 'تعلم البرمجة بلغة جافا',
        author: 'جون ديو',
        requestDate: '2025-05-10',
        status: 'انتظار'
      },
      {
        id: 2,
        bookTitle: 'تعلم تصميم الويب',
        author: 'سامي أحمد',
        requestDate: '2025-05-12',
        status: 'انتظار'
      },
      {
        id: 3,
        bookTitle: 'أساسيات قواعد البيانات',
        author: 'محمد حسن',
        requestDate: '2025-05-15',
        status: 'انتظار'
      }
    ];

    function renderRequestsTable() {
      const tbody = document.getElementById('requestsTableBody');
      tbody.innerHTML = '';
      if (requests.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="6" style="text-align: center; padding: 30px;">
              <i class="fas fa-clipboard-list" style="font-size: 50px; color: #ccc;"></i>
              <p>لا توجد طلبات كتب حالياً</p>
            </td>
          </tr>
        `;
        return;
      }
      requests.forEach((request, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${index + 1}</td>
          <td>${request.bookTitle}</td>
          <td>${request.author}</td>
          <td>${request.requestDate}</td>
          <td><span class="status-badge pending">${request.status}</span></td>
          <td>
            <button class="action-btn delete-btn" onclick="deleteBook(${request.id})" aria-label="حذف الطلب رقم ${index + 1}">
              <i class="fas fa-trash"></i> حذف
            </button>
          </td>
        `;
        tbody.appendChild(row);
      });
    }

    function openAddBookModal() {
      document.getElementById('addBookModal').style.display = 'block';
      document.getElementById('addBookModal').focus();
    }
    function closeAddBookModal() {
      document.getElementById('addBookModal').style.display = 'none';
      document.getElementById('addBookForm').reset();
    }

    document.getElementById('addBookForm').addEventListener('submit', function(event) {
      event.preventDefault();
      const bookTitle = this.bookTitle.value.trim();
      const author = this.author.value.trim();
      const requestDate = this.requestDate.value;
      if (!bookTitle || !author || !requestDate) {
        showAlert('يرجى ملء جميع الحقول المطلوبة', 'error');
        return;
      }
      const newRequest = {
        id: requests.length > 0 ? Math.max(...requests.map(r => r.id)) + 1 : 1,
        bookTitle,
        author,
        requestDate,
        status: 'قيد الدراسة'
      };
      requests.push(newRequest);
      localStorage.setItem('bookRequests', JSON.stringify(requests));
      renderRequestsTable();
      closeAddBookModal();
      showAlert('تم إضافة الكتاب بنجاح', 'success');
    });

    function deleteBook(id) {
      if (!confirm('هل أنت متأكد من حذف هذا الطلب؟')) return;
      requests = requests.filter(r => r.id !== id);
      localStorage.setItem('bookRequests', JSON.stringify(requests));
      renderRequestsTable();
      showAlert('تم حذف الطلب بنجاح', 'success');
    }

    function showAlert(message, type) {
      const alertDiv = document.getElementById('alertMessage');
      alertDiv.innerHTML = message;
      alertDiv.className = `alert alert-${type}`;
      alertDiv.style.display = 'block';
      setTimeout(() => {
        alertDiv.style.display = 'none';
      }, 3000);
    }

    window.onload = function() {
      renderRequestsTable();
    };

    window.addEventListener('click', function(event) {
      const modal = document.getElementById('addBookModal');
      if (event.target === modal) {
        closeAddBookModal();
      }
    });
    window.addEventListener('keydown', function(event) {
      if(event.key === "Escape") {
        closeAddBookModal();
      }
    });
  </script>
</body>
</html>
