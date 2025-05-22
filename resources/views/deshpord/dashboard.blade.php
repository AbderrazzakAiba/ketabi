<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>لوحة التحكم</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
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
      min-height: 100vh;
    }

    /* رسالة الترحيب */
    .welcome-message {
      margin-bottom: 20px;
      padding: 15px;
      background-color: #e9f7ef;
      border-left: 5px solid #28a745;
      color: #155724;
      border-radius: 4px;
      font-weight: bold;
    }

    /* زر الصفحة الرئيسية */
    .home-link {
      position: absolute;
      bottom: 20px;
      right: 0;
      left: 0;
      text-align: center;
    }

    .home-link a {
      display: inline-block;
      padding: 10px 20px;
      background-color: var(--primary-color);
      color: white;
      border-radius: 4px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .home-link a:hover {
      background-color: var(--secondary-color);
    }
  </style>
</head>
<body class="flex h-screen bg-gray-100 font-sans">

  <!-- الشريط الجانبي الثابت -->
  <div class="sidebar">
    <div class="sidebar-header">
      <i class="fas fa-book" style="font-size: 30px; color: var(--primary-color);"></i>
      <h3 class="sidebar-title">لوحة التحكم</h3>
    </div>
    <ul class="nav-links">
      <li><a href="gerelbbok.html" onclick="loadPage('gerelbbok.html')" class="active"><i class="fas fa-book"></i> إدارة الكتب</a></li>
      <li><a href="manage-accounts.html" onclick="loadPage('manage-accounts.html')"><i class="fas fa-users"></i> إدارة الحسابات</a></li>
      <li><a href="messag.html" onclick="loadPage('messag.html')"><i class="fas fa-bell"></i> الإشعارات</a></li>
      <li><a href="registerloan.html" onclick="loadPage('registerloan.html')"><i class="fas fa-history"></i> سجل الإعارة</a></li>
      <li><a href="ordermang.html" onclick="loadPage('ordermang.html')"><i class="fas fa-calendar-plus"></i> طلبات التمديد</a></li>
      <li><a href="barren.html" onclick="loadPage('barren.html')"><i class="fas fa-clipboard-check"></i> جرد</a></li>
      <li><a href="DAR-AINasher.html" onclick="loadPage('DAR-AINasher.html')"><i class="fas fa-building"></i> دور النشر</a></li>
      <li><a href="book-requests.html" onclick="loadPage('book-requests.html')"><i class="fas fa-clipboard-list"></i> طلبات توفير الكتب</a></li>
      <li><a href="approved-books.html" onclick="loadPage('approved-books.html')"><i class="fas fa-check-circle"></i> الموافقة على الكتب</a></li>
    </ul>

    <!-- زر العودة إلى الصفحة الرئيسية -->
    <div class="home-link">
      <a href="#" onclick="loadPage('dashboard.html')">
        <i class="fas fa-home"></i> الصفحة الرئيسية
      </a>
    </div>
  </div>

  <main id="main-content" class="main-content">
    <!-- رسالة الترحيب -->
    <div class="welcome-message">
      مرحبًا بك في لوحة التحكم!
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
      <h1 class="text-2xl font-bold text-gray-800 mb-4" style="color: #423add;">مرحبًا بك في لوحة التحكم</h1>
      <p class="text-gray-600">اختر قسمًا من الشريط الجانبي لبدء إدارة النظام.</p>

      <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
        <h2 class="text-lg font-semibold text-blue-800 mb-2">نظرة سريعة</h2>
        <p class="text-blue-600">يمكنك من خلال هذه اللوحة إدارة جميع جوانب نظام المكتبة بسهولة.</p>
      </div>
    </div>

    <div id="dashboardAlertMessage" class="mt-6 p-4 bg-red-100 text-red-700 rounded-lg border border-red-200 hidden">
      <!-- رسائل الخطأ ستظهر هنا -->
    </div>
  </main>

  <script>
    // تحميل الصفحة الأولى عند الدخول
    document.addEventListener('DOMContentLoaded', function() {
      loadPage('dashboard.html');
    });

    // دالة لتحميل المحتوى
    function loadPage(page) {
      fetch(page)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
        })
        .then(data => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(data, 'text/html');
          const content = doc.body.innerHTML;
          document.getElementById('main-content').innerHTML = content;
          // تحديث العنصر النشط في القائمة
          updateActiveLink(page);
        })
        .catch(error => {
          console.error('Error loading page:', error);
          document.getElementById('main-content').innerHTML = `
            <div class="p-4 bg-red-100 text-red-700 rounded">
              <h2 class="text-xl font-bold">حدث خطأ</h2>
              <p>تعذر تحميل الصفحة المطلوبة. يرجى المحاولة مرة أخرى.</p>
              <p>الصفحة المطلوبة: ${page}</p>
            </div>
          `;
        });
    }

    // تحديث العنصر النشط في القائمة الجانبية
    function updateActiveLink(page) {
      const links = document.querySelectorAll('.nav-links li a');
      links.forEach(link => {
        link.classList.remove('active');
        const linkPage = link.getAttribute('onclick').match(/'([^']+)'/)[1];
        if (linkPage === page) {
          link.classList.add('active');
        }
      });
    }
  </script>
</body>
</html>
