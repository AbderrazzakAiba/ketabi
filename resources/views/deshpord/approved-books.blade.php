<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>الموافقة على طلبات الكتب</title>
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
    .approve-btn {
      background-color: #28a745;
      color: white;
    }
    .reject-btn {
      background-color: #dc3545;
      color: white;
    }
    .approve-btn:hover,
    .reject-btn:hover {
      opacity: 0.9;
      transform: translateY(-2px);
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
    .completed {
      background-color: #e6f7ee;
      color: #28a745;
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
     <li><a href="barren.html"><i class="fas fa-clipboard-check"></i> جرد </a></li>
      <li><a href="DAR-AINasher.html"><i class="fas fa-building"></i> دور النشر</a></li>
      <li><a href="book-requests.html"><i class="fas fa-clipboard-list"></i> طلبات توفير الكتب</a></li>
      <li><a href="approved-books.html" class="active"><i class="fas fa-check-circle"></i> الموافقة على الكتب</a></li>
    </ul>
  </div>
  
  <!-- المحتوى الرئيسي -->
  <div class="main-content">
    <div class="page-header">
      <h1 class="page-title">الموافقة على طلبات الكتب</h1>
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
      <tbody id="approvedRequestsTableBody">
        <!-- سيتم ملء الجدول من خلال JavaScript -->
      </tbody>
    </table>
  </div>

  <footer>
    © 2025 منصة إدارة المكتبة. جميع الحقوق محفوظة.
  </footer>

  <script>
    // جلب الكتب من التخزين المحلي
    let requests = JSON.parse(localStorage.getItem('bookRequests')) || [];

    // عرض الطلبات التي حالتها "انتظار" أو "قيد الدراسة"
    function renderApprovedRequestsTable() {
      const tbody = document.getElementById('approvedRequestsTableBody');
      tbody.innerHTML = '';

      // نعرض فقط الطلبات التي حالتها "انتظار" أو "قيد الدراسة"
      const pendingRequests = requests.filter(request =>
        request.status === 'انتظار' || request.status === 'قيد الدراسة'
      );

      if (pendingRequests.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="6" style="text-align: center; padding: 30px;">
              <i class="fas fa-clipboard-list" style="font-size: 50px; color: #ccc;"></i>
              <p>لا توجد طلبات كتب قيد المراجعة حالياً</p>
            </td>
          </tr>
        `;
        return;
      }

      pendingRequests.forEach((request, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${index + 1}</td>
          <td>${request.bookTitle}</td>
          <td>${request.author}</td>
          <td>${request.requestDate}</td>
          <td><span class="status-badge pending">${request.status}</span></td>
          <td>
            <button class="action-btn approve-btn" onclick="approveBook(${request.id})" aria-label="موافقة">
              <i class="fas fa-check"></i> موافقة
            </button>
            <button class="action-btn reject-btn" onclick="rejectBook(${request.id})" aria-label="رفض">
              <i class="fas fa-times"></i> رفض
            </button>
          </td>
        `;
        tbody.appendChild(row);
      });
    }

    // الموافقة: تغيير الحالة إلى "تم"
    function approveBook(id) {
      const idx = requests.findIndex(r => r.id === id);
      if (idx !== -1) {
        requests[idx].status = 'تم';
        localStorage.setItem('bookRequests', JSON.stringify(requests));
        renderApprovedRequestsTable();
        showAlert('تمت الموافقة على الكتاب بنجاح', 'success');
      }
    }

    // الرفض: حذف الطلب نهائياً
    function rejectBook(id) {
      if (!confirm('هل أنت متأكد من رفض هذا الطلب؟')) return;
      requests = requests.filter(r => r.id !== id);
      localStorage.setItem('bookRequests', JSON.stringify(requests));
      renderApprovedRequestsTable();
      showAlert('تم رفض الطلب وحذفه بنجاح', 'success');
    }

    // رسائل تنبيه
    function showAlert(message, type) {
      const alertDiv = document.getElementById('alertMessage');
      alertDiv.innerHTML = message;
      alertDiv.className = `alert alert-${type}`;
      alertDiv.style.display = 'block';
      setTimeout(() => {
        alertDiv.style.display = 'none';
      }, 3000);
    }

    // عند تحميل الصفحة
    window.onload = renderApprovedRequestsTable;
  </script>
</body>
</html>
