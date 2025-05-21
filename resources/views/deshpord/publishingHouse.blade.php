<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إدارة دور النشر | منصة كتابي</title>
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

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .page-title {
      color: var(--primary-color);
      margin: 0;
      font-size: 28px;
    }

    .publishers-table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }

    .publishers-table th, .publishers-table td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }

    .publishers-table th {
      background-color: var(--primary-color);
      color: white;
      font-weight: bold;
    }

    .publishers-table tr:hover {
      background-color: #f9f9f9;
    }

    .publisher-card {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 20px;
    }

    .publisher-header {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      border-bottom: 1px solid #eee;
      padding-bottom: 15px;
    }

    .publisher-logo {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      margin-left: 15px;
      border: 2px solid #e0e0e0;
    }

    .publisher-name {
      font-size: 20px;
      font-weight: bold;
      color: var(--primary-color);
      margin: 0;
    }

    .publisher-city {
      color: #666;
      margin: 5px 0 0;
    }

    .publisher-info {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 15px;
      margin-bottom: 15px;
    }

    .info-item {
      display: flex;
      align-items: center;
      padding: 8px;
      background-color: #f9f9f9;
      border-radius: 6px;
    }

    .info-item i {
      margin-left: 8px;
      color: var(--primary-color);
    }

    .action-btn {
      padding: 8px 15px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
      font-family: 'Tajawal';
      font-weight: bold;
      margin-left: 8px;
    }

    .edit-btn {
      background-color: #ffc107;
      color: #212529;
    }

    .delete-btn {
      background-color: #dc3545;
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
      font-family: 'Tajawal';
      font-weight: bold;
    }

    .action-btn:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }

    .search-bar {
      margin-bottom: 20px;
      display: flex;
      gap: 10px;
    }

    .search-input {
      flex: 1;
      padding: 12px 15px;
      border-radius: 6px;
      border: 1px solid #ddd;
      font-family: 'Tajawal';
      font-size: 16px;
    }

    .search-btn {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 0 20px;
      border-radius: 6px;
      cursor: pointer;
      font-family: 'Tajawal';
    }

    .view-toggle {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 15px;
    }

    .toggle-btn {
      background: none;
      border: none;
      font-size: 20px;
      cursor: pointer;
      color: var(--primary-color);
      margin-left: 10px;
      padding: 5px;
    }

    .empty-state {
      text-align: center;
      padding: 50px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .empty-state i {
      font-size: 50px;
      color: #ccc;
      margin-bottom: 20px;
    }

    .empty-state p {
      font-size: 18px;
      color: #666;
      margin-bottom: 20px;
    }

    .actions-container {
      display: flex;
      justify-content: flex-end;
      margin-top: 15px;
    }

    .created-date {
      color: #666;
      font-size: 14px;
      margin-top: 10px;
      text-align: left;
    }

    footer {
      text-align: center;
      padding: 20px;
      background-color: var(--primary-color);
      color: white;
      margin-right: 250px;
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
      <li><a href="barren.html"><i class="fas fa-calendar-plus"></i>  جرد الكتب</a></li>
      <li><a href="DAR-AINasher.html" class="active"><i class="fas fa-building"></i> دور النشر</a></li>
    </ul>
  </div>

  <!-- المحتوى الرئيسي -->
  <div class="main-content">
    <div class="page-header">
      <h1 class="page-title">إدارة دور النشر</h1>
      <a href="add_publisher.html" class="add-btn">
        <i class="fas fa-plus"></i> إضافة دار نشر
      </a>
    </div>

    <div id="alertMessage" class="alert" style="display: none;"></div>

    <div class="search-bar">
      <input type="text" id="searchInput" class="search-input" placeholder="ابحث عن دار نشر بالاسم أو المدينة..." onkeyup="searchPublishers()">
      <button class="search-btn" onclick="searchPublishers()">
        <i class="fas fa-search"></i> بحث
      </button>
    </div>

    <div class="view-toggle">
      <button class="toggle-btn" onclick="setViewMode('cards')" title="عرض البطاقات">
        <i class="fas fa-th-large"></i>
      </button>
      <button class="toggle-btn" onclick="setViewMode('table')" title="عرض الجدول">
        <i class="fas fa-table"></i>
      </button>
    </div>

    <!-- عرض البطاقات -->
    <div id="cardsView">
      <div id="publishersCardsContainer">
        <!-- سيتم ملء هذا القسم بواسطة JavaScript -->
      </div>
    </div>

    <!-- عرض الجدول -->
    <div id="tableView" style="display: none;">
      <table class="publishers-table">
        <thead>
          <tr>
            <th>#</th>
            <th>الشعار</th>
            <th>اسم دار النشر</th>
            <th>المدينة</th>
            <th>البريد الإلكتروني</th>
            <th>الهاتف</th>
            <th>الإجراءات</th>
          </tr>
        </thead>
        <tbody id="publishersTableBody">
          <!-- سيتم ملء الجدول من خلال JavaScript -->
        </tbody>
      </table>
    </div>
  </div>

  <footer>
    © 2025 منصة كتابي - جميع الحقوق محفوظة
  </footer>

  <script>
    // تحميل البيانات عند فتح الصفحة
    document.addEventListener('DOMContentLoaded', function() {
      // التحقق من وجود رسالة نجاح في URL
      const urlParams = new URLSearchParams(window.location.search);
      const success = urlParams.get('success');

      if (success === 'true') {
        showAlert('تمت العملية بنجاح!', 'success');
      }

      loadPublishers();

      // تعيين وضع العرض المفضل من localStorage
      const viewMode = localStorage.getItem('publishersViewMode') || 'cards';
      setViewMode(viewMode);
    });

    // تحميل دور النشر وعرضها
    function loadPublishers(publishersData = null) {
      const publishers = publishersData || JSON.parse(localStorage.getItem('publishers')) || [];
      const cardsContainer = document.getElementById('publishersCardsContainer');
      const tableBody = document.getElementById('publishersTableBody');

      if (publishers.length === 0) {
        cardsContainer.innerHTML = `
          <div class="empty-state">
            <i class="fas fa-building"></i>
            <p>لا توجد دور نشر مسجلة بعد</p>
            <a href="add_publisher.html" class="add-btn">
              <i class="fas fa-plus"></i> إضافة دار نشر جديدة
            </a>
          </div>
        `;

        tableBody.innerHTML = `
          <tr>
            <td colspan="7" style="text-align: center; padding: 30px;">
              <div class="empty-state" style="padding: 0; box-shadow: none;">
                <i class="fas fa-building"></i>
                <p>لا توجد دور نشر مسجلة بعد</p>
                <a href="add_publisher.html" class="add-btn">
                  <i class="fas fa-plus"></i> إضافة دار نشر جديدة
                </a>
              </div>
            </td>
          </tr>
        `;
        return;
      }

      // عرض البطاقات
      cardsContainer.innerHTML = publishers.map((publisher, index) => `
        <div class="publisher-card">
          <div class="publisher-header">
            ${publisher.logo ? `
              <img src="${publisher.logo}" alt="${publisher.name_ed}" class="publisher-logo">
            ` : `
              <div class="publisher-logo" style="display: flex; align-items: center; justify-content: center; background-color: #f5f7fa;">
                <i class="fas fa-building" style="font-size: 24px; color: #666;"></i>
              </div>
            `}
            <div>
              <h3 class="publisher-name">${publisher.name_ed}</h3>
              <p class="publisher-city">${publisher.city_ed}</p>
            </div>
          </div>

          <div class="publisher-info">
            <div class="info-item">
              <i class="fas fa-map-marker-alt"></i>
              <span>${publisher.address_ed}</span>
            </div>
            <div class="info-item">
              <i class="fas fa-phone"></i>
              <span>${publisher.tel_ed}</span>
            </div>
            <div class="info-item">
              <i class="fas fa-envelope"></i>
              <span>${publisher.email_ed}</span>
            </div>
          </div>

          <div class="actions-container">
            <button class="action-btn edit-btn" onclick="editPublisher(${publisher.id})">
              <i class="fas fa-edit"></i> تعديل
            </button>
            <button class="action-btn delete-btn" onclick="deletePublisher(${publisher.id})">
              <i class="fas fa-trash"></i> حذف
            </button>
          </div>

          <div class="created-date">
            تاريخ الإضافة: ${new Date(publisher.created_at).toLocaleDateString('ar-EG')}
          </div>
        </div>
      `).join('');

      // عرض الجدول
      tableBody.innerHTML = publishers.map((publisher, index) => `
        <tr>
          <td>${index + 1}</td>
          <td>
            ${publisher.logo ? `
              <img src="${publisher.logo}" alt="${publisher.name_ed}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
            ` : `
              <i class="fas fa-building" style="font-size: 24px; color: #666;"></i>
            `}
          </td>
          <td>${publisher.name_ed}</td>
          <td>${publisher.city_ed}</td>
          <td>${publisher.email_ed}</td>
          <td>${publisher.tel_ed}</td>
          <td>
            <button class="action-btn edit-btn" onclick="editPublisher(${publisher.id})">
              <i class="fas fa-edit"></i>
            </button>
            <button class="action-btn delete-btn" onclick="deletePublisher(${publisher.id})">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      `).join('');
    }

    // البحث عن دور النشر
    function searchPublishers() {
      const searchTerm = document.getElementById('searchInput').value.toLowerCase();
      const publishers = JSON.parse(localStorage.getItem('publishers')) || [];

      if (!searchTerm) {
        loadPublishers();
        return;
      }

      const filteredPublishers = publishers.filter(publisher =>
        publisher.name_ed.toLowerCase().includes(searchTerm) ||
        publisher.city_ed.toLowerCase().includes(searchTerm) ||
        publisher.email_ed.toLowerCase().includes(searchTerm)
      );

      loadPublishers(filteredPublishers);
    }

    // حذف دار نشر
    function deletePublisher(id) {
      if (!confirm('هل أنت متأكد من حذف دار النشر هذه؟ لا يمكن التراجع عن هذا الإجراء.')) return;

      try {
        let publishers = JSON.parse(localStorage.getItem('publishers')) || [];
        publishers = publishers.filter(p => p.id !== id);
        localStorage.setItem('publishers', JSON.stringify(publishers));

        showAlert('تم حذف دار النشر بنجاح', 'success');
        loadPublishers();
      } catch (e) {
        showAlert('حدث خطأ أثناء حذف دار النشر', 'error');
        console.error(e);
      }
    }

    // تعديل دار نشر (يمكن تطويره لفتح نموذج التعديل)
    function editPublisher(id) {
      // هنا يمكنك توجيه المستخدم إلى صفحة التعديل مع تمرير معرف دار النشر
      // أو فتح نموذج تعديل مباشرة في الصفحة
      alert('سيتم تطوير وظيفة التعديل في المستقبل');
      console.log('تعديل دار النشر ذات المعرف:', id);
    }

    // تعيين وضع العرض (بطاقات أو جدول)
    function setViewMode(mode) {
      if (mode === 'cards') {
        document.getElementById('cardsView').style.display = 'block';
        document.getElementById('tableView').style.display = 'none';
      } else {
        document.getElementById('cardsView').style.display = 'none';
        document.getElementById('tableView').style.display = 'block';
      }

      // حفظ التفضيل في localStorage
      localStorage.setItem('publishersViewMode', mode);
    }

    // عرض رسائل التنبيه
    function showAlert(message, type) {
      const alertDiv = document.getElementById('alertMessage');
      alertDiv.textContent = message;
      alertDiv.className = `alert alert-${type}`;
      alertDiv.style.display = 'block';

      setTimeout(() => {
        alertDiv.style.display = 'none';
      }, 5000);
    }
    function editPublisher(id) {
    window.location.href = `edit_publisher.html?id=${id}`;
  }
  </script>
</body>
</html>
