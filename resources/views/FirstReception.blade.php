<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>عن كتابي</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Tajawal', sans-serif;
      background-color: #ffffff;
      color: #30382F;
    }

    .hero {
      background-color: #4139d6;
      color: white;
      padding: 60px 30px;
      text-align: center;
      border-bottom-left-radius: 40px;
      border-bottom-right-radius: 40px;
    }

    .hero h1 {
      font-size: 48px;
      margin-bottom: 20px;
      font-weight: bold;
    }

    .hero p {
      font-size: 20px;
      max-width: 800px;
      margin: auto;
    }

    .section {
      max-width: 1000px;
      margin: 60px auto;
      background-color: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }

    .section h2 {
      font-size: 32px;
      margin-bottom: 20px;
      color: #4F46E5;
      border-bottom: 2px solid #e0e0e0;
      padding-bottom: 10px;
    }

    .section p {
      font-size: 18px;
      line-height: 1.8;
      margin-top: 20px;
      background-color: #f6f7f9;
      padding: 20px;
      border-radius: 12px;
    }

    .image-container {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      margin-top: 30px;
      align-items: center;
      justify-content: center;
    }

    .image-container img {
      width: 450px;
      border-radius: 12px;
    }

    .box {
      flex: 1;
      background-color: #e5e7fb;
      padding: 25px;
      border-radius: 16px;
      font-size: 18px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .quote {
      font-style: italic;
      font-size: 20px;
      text-align: center;
      color: #444;
      margin-top: 40px;
    }

    .join-us {
      text-align: center;
      margin-top: 60px;
    }

    .join-us label {
      font-size: 22px;
      display: block;
      margin-bottom: 10px;
    }

    .join-us a img {
      height: 50px;
    }

    footer {
      background-color: white;
      padding: 30px;
      margin-top: 60px;
      border-top: 1px solid #ccc;
      text-align: center;
    }

    footer p {
      font-size: 16px;
      margin: 5px 0;
    }
    .btn-h{
     height: 50px;
     width: 200px;
     border-radius:10px;
     border: #30382F;
     background-color: #4d45e2;
     color: white;

    }
    .btn-v4{
      display: flex;
      justify-content: center;
      align-items:center ;
      gap: 1rem;
      height: 200px;
      background-color: #f3f3f3;
      border-radius:15px ;

    }
  </style>
</head>
<body>

  <div class="hero">
    <h1>مرحباً بك في موقع كتابي</h1>
    <p>منصة كتابي هي أكبر مكتبة رقمية عربية تهدف إلى نشر المعرفة وتسهيل الوصول إلى الكتب لكل قارئ عربي في أي مكان.</p>
  </div>

  <div class="section">
    <h2>لماذا تم إنشاء موقع كتابي؟</h2>
    <p>تم انشاء موقع كتابي عام 2025 بهدف توفير مكتبة رقمية شاملة باللغة العربية تتيح للقراء الوصول إلى آلاف الكتب بسهولة.</p>

    <div class="image-container">
      <img src="/image/pexels-element5-1370298.jpg" alt="المعرفة">
      <div class="box">المعرفة ليست رفاهية، بل وسيلة للحرية والتقدم في عالم متغير.</div>
    </div>
  </div>

  <div class="section">
    <h2>ما هو الغرض من إنشاء موقع كتابي؟</h2>
    <p>نسعى لبناء مجتمع عربي قارئ ومثقف، يؤمن بقوة المعرفة ويجعل من القراءة عادة يومية.</p>

    <div class="image-container">
      <img  src="/image/pexels-pixabay-256559.jpg" alt="مجتمع القراءة">
      <div class="box">كل قارئ يضيف طوبة في بناء أمة مثقفة… القراءة هي البداية.</div>
    </div>
  <p class="quote">تخيل لو بإمكانك أن تعيش مئات التجارب… كل ذلك ممكن عندما تفتح كتاباً.</p>

  <div class="btn-v4">
    <button class="btn-h" onclick="window.location.href='{{ route('login.form') }}' ">تسجيل دخول </button>
  </div>

  </div>

  <footer>
    <p>رقم الهاتف: 0655243707</p>
    <p>تابعنا على: فيسبوك | إنستغرام</p>
  </footer>

</body>
</html>
