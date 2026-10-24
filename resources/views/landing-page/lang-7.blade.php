<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TOONHUB - Character Figurine Carousel</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    body {
      margin: 0;
      padding: 0;
      overflow: hidden;
      font-family: 'Inter', sans-serif;
    }
    /* Khởi tạo mượt mà cho việc đổi màu nền */
    .hero-container {
      transition: background-color 650ms cubic-bezier(0.4, 0, 0.2, 1);
    }
    /* Cấu hình các thuộc tính chuyển động đồng bộ cho các item của carousel */
    .carousel-item {
      position: absolute;
      aspect-ratio: 0.6 / 1;
      left: 50%;
      transform: translateX(-50%);
      transition: transform 650ms cubic-bezier(0.4, 0, 0.2, 1),
                  filter 650ms cubic-bezier(0.4, 0, 0.2, 1),
                  opacity 650ms cubic-bezier(0.4, 0, 0.2, 1),
                  left 650ms cubic-bezier(0.4, 0, 0.2, 1),
                  height 650ms cubic-bezier(0.4, 0, 0.2, 1),
                  bottom 650ms cubic-bezier(0.4, 0, 0.2, 1);
      will-change: transform, filter, opacity, left, height, bottom;
    }
  </style>
</head>
<body class="select-none">

  <div id="hero" class="relative w-full overflow-hidden hero-container">
    <div class="relative w-full h-screen overflow-hidden">

      <div
        class="absolute inset-0 pointer-events-none opacity-40 mix-blend-overlay"
        style="
          background-image: url(&quot;data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.08'/%3E%3C/svg%3E&quot;);
          background-size: 200px 200px;
          z-index: 50;
        "
      ></div>

      <div
        style="font-family: 'Anton', sans-serif; font-size: clamp(90px, 28vw, 380px); line-height: 1; letter-spacing: -0.02em; top: 18%; z-index: 2;"
        class="absolute inset-x-0 flex items-center justify-center font-black text-white uppercase pointer-events-none whitespace-nowrap"
      >
        3D SHAPE
      </div>

      <div
        style="letter-spacing: 0.18em; z-index: 60;"
        class="absolute text-xs font-semibold text-white uppercase top-6 left-4 sm:left-8 opacity-90"
      >
        TOONHUB
      </div>

      <div id="carousel-viewport" class="absolute inset-0" style="z-index: 3;">
        </div>

      <div
        style="max-width: 320px; z-index: 60;"
        class="absolute text-white bottom-6 left-4 sm:bottom-20 sm:left-24"
      >
        <p
          style="letter-spacing: 0.02em;"
          class="font-bold uppercase mb-2 sm:mb-3 text-base sm:text-[22px] opacity-95"
        >
          TOONHUB FIGURINES
        </p>
        <p
          style="line-height: 1.6;"
          class="hidden mb-4 text-xs sm:block sm:text-sm opacity-85 sm:mb-5"
        >
          The artwork is stunning, shipped fully prepared. The finish is a vision, the 3D craft is flawless. Many thanks! Wishing you the win. Order now.
        </p>

        <div class="flex gap-3 sm:gap-4">
          <button
            id="btn-prev"
            class="flex items-center justify-center w-12 h-12 text-white transition-all duration-150 bg-transparent border-2 border-white rounded-full sm:w-16 sm:h-16 hover:scale-108 hover:bg-white/12 active:scale-95 disabled:opacity-50"
            aria-label="Previous character"
          >
            <i data-lucide="arrow-left" style="width: 26px; height: 26px; stroke-width: 2.25;"></i>
          </button>
          <button
            id="btn-next"
            class="flex items-center justify-center w-12 h-12 text-white transition-all duration-150 bg-transparent border-2 border-white rounded-full sm:w-16 sm:h-16 hover:scale-108 hover:bg-white/12 active:scale-95 disabled:opacity-50"
            aria-label="Next character"
          >
            <i data-lucide="arrow-right" style="width: 26px; height: 26px; stroke-width: 2.25;"></i>
          </button>
        </div>
      </div>

      <div style="z-index: 60;" class="absolute bottom-6 right-4 sm:bottom-20 sm:right-10">
        <a
          href="#discover"
          style="font-family: 'Anton', sans-serif; font-size: clamp(20px, 4vw, 56px); letter-spacing: -0.02em; line-height: 1;"
          class="flex items-center gap-2 text-white no-underline uppercase transition-opacity duration-200 opacity-95 hover:opacity-100"
        >
          <span>DISCOVER IT</span>
          <i data-lucide="arrow-right" class="w-5 h-5 sm:w-8 sm:h-8" style="stroke-width: 2.25;"></i>
        </a>
      </div>

    </div>
  </div>

  <script>
    // Dữ liệu ảnh cấu hình tương đương
    const IMAGES = [
      { src: 'https://fifth-gentle-45902158.figma.site/_components/v2/4de492f6d9cf8244ad5293233e5c6f52407d42fc/1.02464a56.png', bg: '#F4845F' },
      { src: 'https://fifth-gentle-45902158.figma.site/_components/v2/4de492f6d9cf8244ad5293233e5c6f52407d42fc/2.b977faab.png', bg: '#6BBF7A' },
      { src: 'https://fifth-gentle-45902158.figma.site/_components/v2/4de492f6d9cf8244ad5293233e5c6f52407d42fc/3.4df853b4.png', bg: '#E882B4' },
      { src: 'https://fifth-gentle-45902158.figma.site/_components/v2/4de492f6d9cf8244ad5293233e5c6f52407d42fc/4.4457fbce.png', bg: '#6EB5FF' }
    ];

    let activeIndex = 0;
    let isAnimating = false;
    let isMobile = window.innerWidth < 640;

    // Tự động tải trước (Preload) 4 ảnh
    IMAGES.forEach(item => {
      const img = new Image();
      img.src = item.src;
    });

    // Lắng nghe thay đổi kích thước màn hình (Resize)
    window.addEventListener('resize', () => {
      const currentMobileState = window.innerWidth < 640;
      if (currentMobileState !== isMobile) {
        isMobile = currentMobileState;
        updateCarousel(); // Re-render lại layout khi điểm gãy thay đổi
      }
    });

    // Tạo các phần tử ảnh trong DOM
    const viewport = document.getElementById('carousel-viewport');
    IMAGES.forEach((item, index) => {
      const div = document.createElement('div');
      div.className = 'carousel-item';
      div.id = `item-${index}`;

      const img = document.createElement('img');
      img.src = item.src;
      img.alt = `Toonhub figurine character ${index + 1}`;
      img.className = 'w-full h-full object-contain object-bottom';
      img.setAttribute('draggable', 'false');

      div.appendChild(img);
      viewport.appendChild(div);
    });

    // Hàm cập nhật trạng thái hiển thị (CSS Injection dựa trên Role)
    function updateCarousel() {
      // 1. Thay đổi màu nền của Hero
      document.getElementById('hero').style.backgroundColor = IMAGES[activeIndex].bg;

      // 2. Định dạng lại cấu trúc vị trí cho từng khối ảnh
      IMAGES.forEach((_, index) => {
        const itemEl = document.getElementById(`item-${index}`);
        if (!itemEl) return;

        const isCenter = index === activeIndex;
        const isLeft = index === (activeIndex + 3) % 4;
        const isRight = index === (activeIndex + 1) % 4;
        const isBack = index === (activeIndex + 2) % 4;

        let transformStr = '';
        let filterStr = '';
        let opacityVal = 1;
        let zIndexVal = 5;
        let leftVal = '50%';
        let heightVal = '22%';
        let bottomVal = '12%';

        if (isCenter) {
          transformStr = `translateX(-50%) scale(${isMobile ? 1.25 : 1.68})`;
          filterStr = 'blur(0px)';
          opacityVal = 1;
          zIndexVal = 20;
          leftVal = '50%';
          heightVal = isMobile ? '60%' : '92%';
          bottomVal = isMobile ? '22%' : '0';
        } else if (isLeft) {
          transformStr = 'translateX(-50%) scale(1)';
          filterStr = 'blur(2px)';
          opacityVal = 0.85;
          zIndexVal = 10;
          leftVal = isMobile ? '20%' : '30%';
          heightVal = isMobile ? '16%' : '28%';
          bottomVal = isMobile ? '32%' : '12%';
        } else if (isRight) {
          transformStr = 'translateX(-50%) scale(1)';
          filterStr = 'blur(2px)';
          opacityVal = 0.85;
          zIndexVal = 10;
          leftVal = isMobile ? '80%' : '70%';
          heightVal = isMobile ? '16%' : '28%';
          bottomVal = isMobile ? '32%' : '12%';
        } else if (isBack) {
          transformStr = 'translateX(-50%) scale(1)';
          filterStr = 'blur(4px)';
          opacityVal = 1;
          zIndexVal = 5;
          leftVal = '50%';
          heightVal = isMobile ? '13%' : '22%';
          bottomVal = isMobile ? '32%' : '12%';
        }

        // Thực thi gán Style trực tiếp
        itemEl.style.transform = transformStr;
        itemEl.style.filter = filterStr;
        itemEl.style.opacity = opacityVal;
        itemEl.style.zIndex = zIndexVal;
        itemEl.style.left = leftVal;
        itemEl.style.height = heightVal;
        itemEl.style.bottom = bottomVal;
      });
    }

    // Cơ chế điều hướng chuyển đổi index
    function navigate(direction) {
      if (isAnimating) return;
      isAnimating = true;

      if (direction === 'next') {
        activeIndex = (activeIndex + 1) % 4;
      } else {
        activeIndex = (activeIndex + 3) % 4;
      }

      updateCarousel();

      // Khóa thao tác trong thời gian chuyển cảnh (650ms)
      setTimeout(() => {
        isAnimating = false;
      }, 650);
    }

    // Gán sự kiện click cho các nút điều hướng
    document.getElementById('btn-prev').addEventListener('click', () => navigate('prev'));
    document.getElementById('btn-next').addEventListener('click', () => navigate('next'));

    // Chạy khởi tạo giao diện ban đầu
    updateCarousel();

    // Khởi tạo các biểu tượng từ gói thư viện Lucide
    lucide.createIcons();
  </script>
</body>
</html>
