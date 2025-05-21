<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>سجل الإعارة | نظام إدارة المكتبة</title>
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
      box-shadow: none !important;
    }
    .nav-links li a:hover,
    .nav-links li a.active {
      background-color: var(--light-bg);
      color: var(--primary-color);
      border-right: 4px solid var(--primary-color);
      box-shadow: none !important;
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
    .search-filter {
      display: flex;
      gap: 15px;
      margin-bottom: 20px;
    }
    .search-input {
      flex: 1;
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-family: 'Tajawal';
    }
    .filter-select {
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-family: 'Tajawal';
    }
    .history-table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }
    .history-table th, .history-table td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }
    .history-table th {
      background-color: var(--primary-color);
      color: white;
      font-weight: bold;
    }
    .history-table tr:hover {
      background-color: #f9f9f9;
    }
    .status-badge {
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 14px;
      font-weight: bold;
    }
    .status-active {
      background-color: #d4edda;
      color: #155724;
    }
    .status-returned {
      background-color: #e2e3e5;
      color: #383d41;
    }
    .status-overdue {
      background-color: #f8d7da;
      color: #721c24;
    }
    .status-canceled {
      background-color: #fff3cd;
      color: #856404;
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
    .notify-btn {
      background-color: #f59e42;
      color: white;
    }
    .action-btn:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }
    .status-select {
      padding: 8px 12px; /* Increased padding */
      border-radius: 6px; /* More rounded corners */
      border: 1px solid #ccc; /* Light gray border */
      font-family: 'Tajawal';
      font-size: 14px;
      cursor: pointer;
      background-color: white; /* White background */
      color: var(--text-color); /* Text color */
      transition: all 0.3s ease; /* Smooth transition */
    }
    .status-select:hover {
      border-color: #a0a0a0; /* Slightly darker gray border on hover */
    }
    .status-select-نشطة {
      background-color: #d4edda;
      color: #155724;
    }
    .status-select-تم_الإرجاع {
      background-color: #e2e3e5;
      color: #383d41;
    }
    .status-select-متأخرة {
      background-color: #f8d7da;
      color: #721c24;
    }
    .status-select-ملغاة {
      background-color: #fff3cd;
      color: #856404;
    }
    .button-style {
      padding: 10px 20px;
      border-radius: 6px;
      background-color: var(--primary-color);
      color: white;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
      font-family: 'Tajawal';
      font-size: 16px;
    }
    .button-style:hover {
      background-color: var(--secondary-color);
      transform: translateY(-2px);
    }
    #notificationModal {
      display: flex; /* Use flexbox for centering */
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000; /* Ensure it's on top */
    }
    #notificationModal > div {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      width: 400px;
      max-width: 90%;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    #notificationModal h3 {
      margin-top: 0;
      color: var(--primary-color);
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    #notificationModal label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    #notificationModal input[type="text"],
    #notificationModal textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-family: 'Tajawal';
      box-sizing: border-box; /* Include padding and border in element's total width and height */
    }
    #notificationModal textarea {
      resize: vertical; /* Allow vertical resizing */
    }
    #notificationModal .button-style {
      /* Inherits styles from .button-style */
      margin-top: 15px;
    }
    #notificationModal .action-btn {
       /* Inherits styles from .action-btn */
       margin-top: 15px;
    }
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
    footer {
      text-align: center;
      padding: 20px;
      background-color: var(--primary-color);
      color: white;
      margin-right: 250px;
      margin-top: 100%;
    }
    .info-icon {
      color: var(--primary-color);
      margin-left: 5px;
      cursor: help;
    }
    .date-cell {
      direction: ltr;
      text-align: center;
    }
    .button-style {
      padding: 10px 20px;
      border-radius: 6px;
      background-color: var(--primary-color);
      color: white;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
      font-family: 'Tajawal';
      font-size: 16px;
    }
    .button-style:hover {
      background-color: var(--secondary-color);
      transform: translateY(-2px);
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
      <li><a href="registerloan.html"class="active"><i class="fas fa-history"></i> سجل الإعارة</a></li>
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
      <h1 class="page-title">سجل الإعارة</h1>
    </div>
    
    <div id="alertMessage" style="display: none;"></div>
    
    <!-- فلتر البحث -->
    <div class="search-filter">
      <input type="text" id="searchInput" class="search-input" placeholder="ابحث عن كتاب أو مستعير...">
      <select id="statusFilter" class="filter-select">
        <option value="all">كل الحالات</option>
        <option value="active">نشطة</option>
        <option value="returned">تم الإرجاع</option>
        <option value="overdue">متأخرة</option>
        <option value="canceled">ملغاة</option>
      </select>
      <select id="typeFilter" class="filter-select">
        <option value="all">كل الأنواع</option>
        <option value="internal">داخلية</option>
        <option value="external">خارجية</option>
        <option value="online">عبر النت</option>
      </select>
    </div>
    
    <!-- جدول سجل الإعارة -->
    <table class="history-table">
      <thead>
        <tr>
          <th>#</th>
          <th>عنوان الكتاب</th>
          <th>المستعير</th>
          <th>نوع الإعارة</th>
          <th>تاريخ الإعارة</th>
          <th>تاريخ الإرجاع</th>
          <th>الحالة</th>
          <th>تغيير الحالة</th>
          <th>الإجراءات</th>
        </tr>
      </thead>
      <tbody id="historyTableBody">
        <!-- سيتم ملؤها بالجافاسكربت -->
      </tbody>
    </table>
  </div>

  <footer>
    © 2025 نظام إدارة المكتبة. جميع الحقوق محفوظة.
  </footer>

  <script>
    // بيانات سجل الإعارة (ستأتي من قاعدة البيانات في التطبيق الحقيقي)
    const borrowHistory = [
      {
        id: 'borrow-2023-001',
        bookId: 'book-001',
        bookTitle: 'تعلم البرمجة بلغة جافا سكريبت',
        borrowerId: 'user-005',
        borrowerName: 'أحمد محمد',
        type: 'داخلية',
        borrowDate: '2023-05-10',
        returnDate: '2023-05-24',
        actualReturnDate: '2023-05-23',
        status: 'تم الإرجاع',
        extended: false
      },
      {
        id: 'borrow-2023-002',
        bookId: 'book-003',
        bookTitle: 'إدارة المشاريع الاحترافية',
        borrowerId: 'user-012',
        borrowerName: 'سارة عبدالله',
        type: 'خارجية',
        borrowDate: '2023-05-15',
        returnDate: '2023-05-29',
        actualReturnDate: '2023-06-01',
        status: 'متأخرة',
        extended: false
      },
      {
        id: 'borrow-2023-003',
        bookId: 'book-007',
        bookTitle: 'أساسيات قواعد البيانات',
        borrowerId: 'user-008',
        borrowerName: 'خالد سالم',
        type: 'عبر النت',
        borrowDate: '2023-06-01',
        returnDate: '2023-06-15',
        actualReturnDate: null,
        status: 'نشطة',
        extended: true
      },
      {
        id: 'borrow-2023-004',
        bookId: 'book-012',
        bookTitle: 'التسويق الرقمي في العصر الحديث',
        borrowerId: 'user-003',
        borrowerName: 'لمى ناصر',
        type: 'داخلية',
        borrowDate: '2023-06-10',
        returnDate: '2023-06-24',
        actualReturnDate: null,
        status: 'ملغاة',
        extended: false
      },
      {
        id: 'borrow-2023-005',
        bookId: 'book-005',
        bookTitle: 'تعلم تصميم الويب',
        borrowerId: 'user-007',
        borrowerName: 'محمد علي',
        type: 'خارجية',
        borrowDate: '2023-06-05',
        returnDate: '2023-06-19',
        actualReturnDate: '2023-06-18',
        status: 'تم الإرجاع',
        extended: false
      }
    ];

    // عرض جدول سجل الإعارة
    function renderHistoryTable() {
      const tbody = document.getElementById('historyTableBody');
      tbody.innerHTML = '';
      
      const searchText = document.getElementById('searchInput').value.toLowerCase();
      const statusFilter = document.getElementById('statusFilter').value;
      const typeFilter = document.getElementById('typeFilter').value;
      
      let filteredRecords = borrowHistory;
      
      // تطبيق فلتر البحث
      if (searchText) {
        filteredRecords = filteredRecords.filter(record => 
          record.bookTitle.toLowerCase().includes(searchText) || 
          record.borrowerName.toLowerCase().includes(searchText)
        );
      }
      
      // تطبيق فلتر الحالة
      if (statusFilter !== 'all') {
        filteredRecords = filteredRecords.filter(record => 
          record.status === (statusFilter === 'active' ? 'نشطة' :
                           statusFilter === 'returned' ? 'تم الإرجاع' :
                           statusFilter === 'overdue' ? 'متأخرة' : 'ملغاة')
        );
      }
      
      // تطبيق فلتر النوع
      if (typeFilter !== 'all') {
        filteredRecords = filteredRecords.filter(record => 
          record.type === (typeFilter === 'internal' ? 'داخلية' :
                         typeFilter === 'external' ? 'خارجية' : 'عبر النت')
        );
      }
      
      if (filteredRecords.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="9" style="text-align: center; padding: 30px;">
              <i class="fas fa-history" style="font-size: 50px; color: #ccc;"></i>
              <p>لا توجد سجلات إعارة</p>
            </td>
          </tr>
        `;
        return;
      }
      
      filteredRecords.forEach((record, index) => {
        const statusClass = record.status === 'نشطة' ? 'status-active' :
                           record.status === 'تم الإرجاع' ? 'status-returned' :
                           record.status === 'متأخرة' ? 'status-overdue' : 'status-canceled';
        
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${index + 1}</td>
          <td>${record.bookTitle}</td>
          <td>${record.borrowerName}</td>
          <td>${record.type}</td>
          <td class="date-cell">${formatDate(record.borrowDate)}</td>
          <td class="date-cell">${formatDate(record.returnDate)} ${record.extended ? '<span style="color: var(--primary-color);">(ممددة)</span>' : ''}</td>
          <td><span class="status-badge ${statusClass}">${record.status}</span></td>
          <td>
            <select class="status-select status-select-${record.status.replace(' ', '_')}" onchange="updateStatus('${record.id}', this.value)">
              <option value="نشطة" ${record.status === 'نشطة' ? 'selected' : ''}>نشطة</option>
              <option value="تم الإرجاع" ${record.status === 'تم الإرجاع' ? 'selected' : ''}>تم الإرجاع</option>
              <option value="متأخرة" ${record.status === 'متأخرة' ? 'selected' : ''}>متأخرة</option>
              <option value="ملغاة" ${record.status === 'ملغاة' ? 'selected' : ''}>ملغاة</option>
            </select>
          </td>
          <td>
            <button class="button-style" onclick="sendNotification('${record.id}')">
              <i class="fas fa-bell"></i> إرسال إشعار
            </button>
          </td>
        `;
        tbody.appendChild(row);
      });
    }

    // دالة لتحديث حالة الإعارة
    function updateStatus(borrowId, newStatus) {
      const record = borrowHistory.find(r => r.id === borrowId);
      if (record) {
        record.status = newStatus;
        // هنا يمكنك إضافة كود لإرسال التحديث إلى قاعدة البيانات
        showAlert(`تم تحديث حالة الإعارة لـ "${record.bookTitle}" إلى "${newStatus}"`, 'success');
        // إعادة عرض الجدول لتحديث الحالة المرئية
        renderHistoryTable();
      }
    }

    // دالة إرسال الإشعار (تفتح المودال)
    function sendNotification(borrowId) {
      // يمكنك تخزين borrowId إذا احتجت إليه عند إرسال الإشعار الفعلي
      document.getElementById('notificationModal').style.display = 'flex';
    }

    // دالة لإرسال الإشعار الفعلي (placeholder)
    function sendNotificationAction() {
      const subject = document.getElementById('notificationSubject').value;
      const message = document.getElementById('notificationMessage').value;
      
      // هنا يمكنك إضافة كود لإرسال الموضوع والرسالة إلى المستعير عبر الخادم
      console.log('Sending notification:', { subject, message });
      
      // إغلاق المودال وعرض رسالة نجاح
      closeNotificationModal();
      showAlert('تم إرسال الإشعار (تجريبي)', 'success');
      
      // مسح حقول الإدخال
      document.getElementById('notificationSubject').value = '';
      document.getElementById('notificationMessage').value = '';
    }

    // دالة لإغلاق المودال
    function closeNotificationModal() {
      document.getElementById('notificationModal').style.display = 'none';
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

    // تنسيق التاريخ
    function formatDate(dateString) {
      if (!dateString) return '---';
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('ar-EG', options);
    }

    // تطبيق الفلاتر عند تغيير القيم
    document.getElementById('searchInput').addEventListener('input', renderHistoryTable);
    document.getElementById('statusFilter').addEventListener('change', renderHistoryTable);
    document.getElementById('typeFilter').addEventListener('change', renderHistoryTable);

    // تحميل الصفحة
    window.onload = function() {
      renderHistoryTable();
    };
  </script>

  <!-- Notification Modal -->
  <div id="notificationModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center;">
    <div style="background-color: white; padding: 20px; border-radius: 8px; width: 400px; max-width: 90%;">
      <h3 style="margin-top: 0; color: var(--primary-color);">إرسال إشعار</h3>
      <div style="margin-bottom: 15px;">
        <label for="notificationSubject" style="display: block; margin-bottom: 5px; font-weight: bold;">الموضوع:</label>
        <input type="text" id="notificationSubject" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-family: 'Tajawal';">
      </div>
      <div style="margin-bottom: 15px;">
        <label for="notificationMessage" style="display: block; margin-bottom: 5px; font-weight: bold;">الرسالة:</label>
        <textarea id="notificationMessage" rows="6" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-family: 'Tajawal';"></textarea>
      </div>
      <div style="text-align: right;">
        <button class="button-style" onclick="sendNotificationAction()">إرسال</button>
        <button class="action-btn" onclick="closeNotificationModal()" style="background-color: #ccc; color: #333; margin-right: 10px;">إلغاء</button>
      </div>
    </div>
  </div>
</body>
</html>
