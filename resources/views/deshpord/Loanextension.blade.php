<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>طلبات تمديد الاستعارة | منصة كتابي</title>
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

    /* الشريط الجانبي */
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
    }

    h1 {
      color: var(--primary-color);
      text-align: center;
      margin-bottom: 30px;
    }

    .requests-table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }

    .requests-table th, .requests-table td {
      padding: 12px 15px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }

    .requests-table th {
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

    .approve-btn {
      background-color: #28a745;
      color: white;
    }

    .reject-btn {
      background-color: #dc3545;
      color: white;
    }

    .status-badge {
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 14px;
    }

    .pending {
      background-color: #fff3cd;
      color: #856404;
    }

    .approved {
      background-color: #d4edda;
      color: #155724;
    }

    .rejected {
      background-color: #f8d7da;
      color: #721c24;
    }

    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 4px;
      text-align: center;
      display: none;
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
  </style>
</head>
<body>
  <!-- الشريط الجانبي -->
  <div class="sidebar">
    <div class="sidebar-header">
      <i class="fas fa-user-tie" style="font-size: 30px; color: var(--primary-color);"></i>
      <h3 class="sidebar-title">لوحة الموظف</h3>
    </div>
    <ul class="nav-links">
        <li><a href="gerelbbok.html"><i class="fas fa-book"></i> إدارة الكتب</a></li>
        <li><a href="manage-accounts.html"><i class="fas fa-users"></i> إدارة الحسابات</a></li>
        <li><a href="messag.html"><i class="fas fa-bell"></i> الإشعارات</a></li>
        <li><a href="registerloan.html" ><i class="fas fa-history"></i> سجل الإعارة</a></li>
      <li><a href="ordermang.html"class="active"><i class="fas fa-calendar-plus"></i> طلبات التمديد</a></li>
      <li><a href="barren.html" ><i class="fas fa-calendar-plus"></i> جرد</a></li>
      <li><a href="DAR-AINasher.html"><i class="fas fa-building"></i> دور النشر</a></li>
    </ul>
    <div class="btn-clo">
      <button class="btn-01" style="height: 35px;
      width: 200px; background-color: #423add;color: white;border-radius:10px;margin-top:580px;margin-right: 20px;"onclick="history.back()" > الرجوع</button>
    </div>
  </div>

  <!-- المحتوى الرئيسي -->
  <div class="main-content">
    <h1><i class="fas fa-calendar-plus"></i> طلبات تمديد الاستعارة</h1>

    <div id="alertMessage" class="alert"></div>

    <table class="requests-table">
      <thead>
        <tr>
          <th>#</th>
          <th>اسم المستخدم</th>
          <th>عنوان الكتاب</th>
          <th>تاريخ الانتهاء الحالي</th>
          <th>مدة التمديد المطلوبة</th>
          <th>الحالة</th>
          <th>الإجراء</th>
        </tr>
      </thead>
      <tbody id="requestsTableBody">
        <!-- سيتم ملء الجدول من خلال JavaScript -->
      </tbody>
    </table>
  </div>

  <footer>
    © 2025 منصة كتابي - جميع الحقوق محفوظة
  </footer>

  <script>
    // بيانات الطلبات (يمكن استبدالها ببيانات من قاعدة بيانات)
    let extensionRequests = [
      {
        id: 1,
        userName: "أحمد محمد",
        bookTitle: "تعلم البرمجة بلغة جافا",
        currentDueDate: "2025-06-15",
        extensionDays: 14,
        status: "pending",
        reason: "بحاجة لمزيد من الوقت لإنهاء البحث"
      },
      {
        id: 2,
        userName: "سارة علي",
        bookTitle: "أساسيات قواعد البيانات",
        currentDueDate: "2025-06-20",
        extensionDays: 7,
        status: "pending",
        reason: "الكتاب مطلوب لإكمال المشروع"
      },
      {
        id: 3,
        userName: "خالد عبدالله",
        bookTitle: "التصميم الجرافيكي الحديث",
        currentDueDate: "2025-06-10",
        extensionDays: 30,
        status: "pending",
        reason: "الكتاب مرجع أساسي للدراسة"
      }
    ];

    // عرض الطلبات في الجدول
    function renderRequests() {
      const tbody = document.getElementById('requestsTableBody');
      tbody.innerHTML = '';

      if (extensionRequests.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="7" style="text-align: center; padding: 30px;">
              <i class="fas fa-clipboard-list" style="font-size: 50px; color: #ccc;"></i>
              <p>لا توجد طلبات تمديد حالياً</p>
            </td>
          </tr>
        `;
        return;
      }

      extensionRequests.forEach((request, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${index + 1}</td>
          <td>${request.userName}</td>
          <td>${request.bookTitle}</td>
          <td>${formatDate(request.currentDueDate)}</td>
          <td>${request.extensionDays} يوم</td>
          <td><span class="status-badge ${request.status}">${getStatusArabic(request.status)}</span></td>
          <td>
            ${request.status === 'pending' ? `
              <button class="action-btn approve-btn" onclick="approveRequest(${request.id})">
                <i class="fas fa-check"></i> موافقة
              </button>
              <button class="action-btn reject-btn" onclick="rejectRequest(${request.id})">
                <i class="fas fa-times"></i> رفض
              </button>
            ` : 'تمت المعالجة'}
          </td>
        `;
        tbody.appendChild(row);
      });
    }

    // تحويل التاريخ إلى صيغة مقروءة
    function formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('ar-EG', options);
    }

    // تحويل حالة الطلب إلى العربية
    function getStatusArabic(status) {
      switch(status) {
        case 'pending': return 'قيد الانتظار';
        case 'approved': return 'تمت الموافقة';
        case 'rejected': return 'مرفوض';
        default: return status;
      }
    }

    // موافقة على طلب التمديد
    function approveRequest(requestId) {
      if (confirm('هل أنت متأكد من الموافقة على تمديد الاستعارة؟')) {
        const request = extensionRequests.find(req => req.id === requestId);
        if (request) {
          request.status = 'approved';
          showAlert('تمت الموافقة على طلب التمديد بنجاح', 'alert-success');
          renderRequests();
        }
      }
    }

    // رفض طلب التمديد
    function rejectRequest(requestId) {
      const reason = prompt('الرجاء إدخال سبب الرفض:');
      if (reason !== null) {
        const request = extensionRequests.find(req => req.id === requestId);
        if (request) {
          request.status = 'rejected';
          request.rejectionReason = reason;
          showAlert('تم رفض طلب التمديد', 'alert-danger');
          renderRequests();
        }
      }
    }

    // عرض رسالة تنبيه
    function showAlert(message, className) {
      const alertBox = document.getElementById('alertMessage');
      alertBox.textContent = message;
      alertBox.className = `alert ${className}`;
      alertBox.style.display = 'block';

      setTimeout(() => {
        alertBox.style.display = 'none';
      }, 3000);
    }

    // تحميل الطلبات عند فتح الصفحة
    window.onload = renderRequests;
  </script>
</body>
</html>
