<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=Noto+Sans+Sinhala:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          ink: '#101A30',
          paper: '#F6F5F1',
          primary: { DEFAULT: '#0F2F6E', light: '#E7ECFA', dark: '#0A2050' },
          accent: { DEFAULT: '#F2A73B', light: '#FDF1DD' },
          go: '#1C8F5A',
          stop: '#D5432E',
        },
        fontFamily: {
          display: ['"Space Grotesk"', 'sans-serif'],
          body: ['"Inter"', '"Noto Sans Sinhala"', 'sans-serif'],
          si: ['"Noto Sans Sinhala"', 'sans-serif'],
          mono: ['"JetBrains Mono"', 'monospace'],
        },
      }
    }
  }
</script>
<style>
  body{ font-family:'Inter','Noto Sans Sinhala',sans-serif; }
  .font-si, [data-si]{ font-family:'Noto Sans Sinhala', sans-serif; }
  .grid-texture{
    background-image:
      linear-gradient(to right, rgba(15,47,110,0.06) 1px, transparent 1px),
      linear-gradient(to bottom, rgba(15,47,110,0.06) 1px, transparent 1px);
    background-size: 28px 28px;
  }
  *:focus-visible{ outline: 3px solid #F2A73B; outline-offset: 2px; }
  @keyframes riseIn{ from{ opacity:0; transform:translateY(10px);} to{ opacity:1; transform:translateY(0);} }
  .rise-in{ animation: riseIn .35s ease-out both; }
  @media (prefers-reduced-motion: reduce){ .rise-in{ animation:none; } }

  /* License card — signature motif reused on the dashboard and elsewhere */
  .license-card{
    position:relative; overflow:hidden; border-radius:1.1rem;
    background: linear-gradient(135deg, #0F2F6E 0%, #16407F 55%, #0A2050 100%);
    color:#fff; padding:1.35rem 1.5rem;
    box-shadow: 0 18px 40px -18px rgba(15,47,110,.6);
  }
  .license-card::before{
    content:""; position:absolute; inset:0;
    background-image: linear-gradient(115deg, transparent 40%, rgba(255,255,255,.10) 50%, transparent 60%);
  }
  .license-chip{
    width:34px; height:24px; border-radius:5px;
    background: linear-gradient(135deg,#F2A73B,#D98A1E);
    box-shadow: inset 0 0 0 1px rgba(0,0,0,.15);
    position:relative; flex-shrink:0;
  }
  .license-chip::after{
    content:""; position:absolute; inset:4px;
    background-image: repeating-linear-gradient(180deg, rgba(0,0,0,.18) 0 2px, transparent 2px 5px);
    border-radius:2px;
  }
  .barcode{
    height:22px;
    background-image: repeating-linear-gradient(90deg, rgba(255,255,255,.9) 0 2px, transparent 2px 4px, rgba(255,255,255,.55) 4px 5px, transparent 5px 7px);
    opacity:.85; border-radius:2px;
  }
</style>