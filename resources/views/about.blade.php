<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>حول كتابي | منصة إدارة المكتبة</title>
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
      line-height: 1.6;
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
      border: 1px solid rgb(220, 220, 220);
      transition: all 0.3s;
      border: none;
    }
    nav a:hover {
      background-color: #423add;
      color: white;
    }
    .auth-button {
      width: 120px;
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
      border: none; /* إزالة الحدود */
    }

    
    /* محتوى الصفحة */
    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px;
    }
    
    .page-header {
      text-align: center;
      margin-bottom: 40px;
    }
    
    .page-title {
      color: var(--primary-color);
      font-size: 32px;
      margin-bottom: 15px;
    }
    
    .page-subtitle {
      color: #666;
      font-size: 18px;
      max-width: 700px;
      margin: 0 auto;
    }
    
    /* أقسام حول الموقع */
    .about-section {
      background-color: white;
      border-radius: 8px;
      padding: 30px;
      margin-bottom: 30px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .section-title {
      color: var(--primary-color);
      font-size: 24px;
      margin-top: 0;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
    }
    
    .section-title i {
      margin-left: 10px;
    }
    
    /* فريق العمل */
    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 25px;
      margin-top: 30px;
    }
    
    .team-member {
      background-color: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.3s;
    }
    
    .team-member:hover {
      transform: translateY(-5px);
    }
    
    .member-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    
    .member-info {
      padding: 20px;
    }
    
    .member-name {
      font-weight: bold;
      font-size: 18px;
      margin: 10px 0 5px;
    }
    
    .member-position {
      color: var(--primary-color);
      font-size: 14px;
    }
    
    /* ميزات الموقع */
    .features {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }
    
    .feature-card {
      background-color: white;
      border-radius: 8px;
      padding: 25px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      border-top: 4px solid var(--primary-color);
    }
    
    .feature-icon {
      font-size: 40px;
      color: var(--primary-color);
      margin-bottom: 15px;
    }
    
    .feature-title {
      font-weight: bold;
      font-size: 18px;
      margin: 10px 0;
    }
    
    /* الفوتر */
    footer {
      text-align: center;
      padding: 30px;
      background-color: var(--primary-color);
      color: white;
      margin-top: 50px;
    }
    
    .social-links {
      margin: 20px 0;
    }
    
    .social-links a {
      color: white;
      font-size: 20px;
      margin: 0 10px;
      transition: all 0.3s;
    }
    
    .social-links a:hover {
      color: #ddd;
      transform: translateY(-3px);
    }
    
    /* تأثيرات للقوائم */
    .info-list {
      list-style-type: none;
      padding: 0;
    }
    
    .info-list li {
      padding: 10px 0;
      border-bottom: 1px dashed #eee;
      display: flex;
    }
    
    .info-list li:last-child {
      border-bottom: none;
    }
    
    .info-list i {
      color: var(--primary-color);
      margin-left: 10px;
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
    <img src="image/pexels-olga-volkovitskaia-131638009-17406787.jpg" class="header-image" alt="خلفية المكتبة">
    <div class="header-content">
      <h1>حول منصة كتابي</h1>
      <p>نافذتك إلى عالم المعرفة والقراءة الرقمية</p>
    </div>
  </header>

  <nav>
    <a href="home.html">الصفحة الرئيسية</a>
    <a href="books.html">قائمة الكتب</a>
    <a href="about.html">حول كتابي</a>
    <a href="kotbi.html" >كتبي المستعارة</a>
    <a href="manage-accounts.html">لوحة التحكم</a>
  </nav>

  <div class="container">
    <div class="page-header">
      <h2 class="page-title">منصة كتابي لإدارة المكتبات</h2>
      <p class="page-subtitle">نقدم حلولاً متكاملة لإدارة المحتوى الثقافي وتسهيل عملية استعارة الكتب إلكترونياً</p>
    </div>
    
    <div class="about-section">
      <h3 class="section-title"><i class="fas fa-info-circle"></i>عن المنصة</h3>
      <p>منصة "كتابي" هي نظام متكامل لإدارة المكتبات الرقمية، تم تطويرها لتلبية احتياجات القراء والباحثين في العالم العربي. تأسست المنصة عام 2023 بهدف تسهيل الوصول إلى المحتوى الثقافي والمعرفي.</p>
      <p>نحن نؤمن بأن المعرفة يجب أن تكون في متناول الجميع، لذلك صممنا واجهة بسيطة وسهلة الاستخدام تمكنك من تصفح آلاف الكتب والمصادر بكل سهولة.</p>
    </div>
    
    <div class="about-section">
      <h3 class="section-title"><i class="fas fa-star"></i>رؤيتنا ورسالتنا</h3>
      <div class="features">
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-eye"></i></div>
          <h4 class="feature-title">الرؤية</h4>
          <p>أن نكون المنصة الرائدة في مجال إدارة المحتوى الثقافي العربي، ونشر المعرفة بطرق مبتكرة تواكب العصر الرقمي.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-bullseye"></i></div>
          <h4 class="feature-title">الرسالة</h4>
          <p>توفير بيئة رقمية متكاملة لإدارة المكتبات، وتسهيل عملية البحث والاستعارة، ودعم الناشرين والكتاب العرب.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
          <h4 class="feature-title">أهدافنا</h4>
          <p>1. رقمنة المحتوى العربي<br>2. دعم المؤلفين والناشرين<br>3. تشجيع القراءة</p>
        </div>
      </div>
    </div>
    
    <div class="about-section">
      <h3 class="section-title"><i class="fas fa-cogs"></i>مميزات المنصة</h3>
      <ul class="info-list">
        <li><i class="fas fa-check"></i> واجهة مستخدم سهلة وبسيطة</li>
        <li><i class="fas fa-check"></i> نظام بحث متقدم للكتب والمؤلفين</li>
        <li><i class="fas fa-check"></i> إدارة كاملة لعملية الاستعارة والإرجاع</li>
        <li><i class="fas fa-check"></i> تقارير وإحصائيات مفصلة</li>
        <li><i class="fas fa-check"></i> دعم متعدد اللغات</li>
        <li><i class="fas fa-check"></i> تطبيقات متوافقة مع جميع الأجهزة</li>
      </ul>
    </div>
    
    <div class="about-section">
      <h3 class="section-title"><i class="fas fa-users"></i>فريق العمل</h3>
      <div class="team-grid">
        <div class="team-member">
          <img src="." alt="عضو الفريق" class="member-image">
          <div class="member-info">
            <h4 class="member-name">عبد الرزاق عائبة</h4>
            <p class="member-position">احد اعضاء الفريق</p>
          </div>
        </div>
        <div class="team-member">
          <img src="" alt="عضو الفريق" class="member-image">
          <div class="member-info">
            <h4 class="member-name">اية معوش</h4>
            <p class="member-position">  احد اعضاء الفريق</p>
          </div>
        </div>
        <div class="team-member">
          <img src="" alt="عضو الفريق" class="member-image">
          <div class="member-info">
            <h4 class="member-name">خماس عبدالله</h4>
            <p class="member-position">احد اعضاء الفريق</p>
          </div>
        </div>
      </div>
    </div>
    
    <div class="about-section">
      <h3 class="section-title"><i class="fas fa-chart-pie"></i>إحصائيات</h3>
      <div class="features">
        <div class="feature-card" style="text-align: center;">
          <div class="feature-icon"><i class="fas fa-book"></i></div>
          <h4 class="feature-title">+10</h4>
          <p>كتاب متوفر</p>
        </div>
        <div class="feature-card" style="text-align: center;">
          <div class="feature-icon"><i class="fas fa-users"></i></div>
          <h4 class="feature-title">+0,000</h4>
          <p>مستخدم مسجل</p>
        </div>
        <div class="feature-card" style="text-align: center;">
          <div class="feature-icon"><i class="fas fa-university"></i></div>
          <h4 class="feature-title"></h4>
          <p>مكتبة معهد</p>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <p>© 2025 جميع الحقوق محفوظة لمنصة كتابي</p>
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
  </script>
</body>
</html>
