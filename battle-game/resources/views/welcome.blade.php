<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>AETHERIS ARENA | Cinematic Battle Simulator</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&amp;family=Inter:wght@400;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-bright": "#3a3939",
                        "primary-container": "#ffbf00",
                        "on-error-container": "#ffdad6",
                        "inverse-surface": "#e5e2e1",
                        "on-error": "#690005",
                        "inverse-primary": "#795900",
                        "outline-variant": "#504532",
                        "surface-container-low": "#1c1b1b",
                        "outline": "#9c8f78",
                        "on-primary": "#402d00",
                        "primary": "#ffe2ab",
                        "surface-variant": "#353534",
                        "background": "#131313",
                        "secondary-container": "#2ff801",
                        "error-container": "#93000a",
                        "on-background": "#e5e2e1",
                        "surface-container-highest": "#353534",
                        "on-secondary": "#053900",
                        "on-tertiary-fixed-variant": "#93000c",
                        "secondary-fixed": "#79ff5b",
                        "inverse-on-surface": "#313030",
                        "secondary-fixed-dim": "#2ae500",
                        "secondary": "#d7ffc5",
                        "tertiary-container": "#ffb8b0",
                        "on-secondary-container": "#0f6d00",
                        "tertiary-fixed-dim": "#ffb4ab",
                        "on-surface": "#e5e2e1",
                        "on-primary-fixed": "#261a00",
                        "on-secondary-fixed-variant": "#095300",
                        "error": "#ffb4ab",
                        "surface-dim": "#131313",
                        "tertiary": "#ffdeda",
                        "on-secondary-fixed": "#022100",
                        "tertiary-fixed": "#ffdad6",
                        "on-tertiary-container": "#ad0011",
                        "on-primary-fixed-variant": "#5c4300",
                        "on-primary-container": "#6d5000",
                        "on-tertiary-fixed": "#410002",
                        "primary-fixed-dim": "#fbbc00",
                        "surface-container-high": "#2a2a2a",
                        "surface-tint": "#fbbc00",
                        "surface": "#131313",
                        "primary-fixed": "#ffdfa0",
                        "surface-container-lowest": "#0e0e0e",
                        "surface-container": "#201f1f",
                        "on-surface-variant": "#d4c5ab",
                        "on-tertiary": "#690006"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "container-max": "1440px",
                        "unit": "4px",
                        "margin-desktop": "48px",
                        "margin-mobile": "16px",
                        "gutter": "24px"
                    },
                    "fontFamily": {
                        "body-lg": ["Inter"],
                        "label-caps": ["Inter"],
                        "headline-md": ["Outfit"],
                        "headline-lg-mobile": ["Outfit"],
                        "body-md": ["Inter"],
                        "display-hero": ["Outfit"],
                        "headline-lg": ["Outfit"]
                    },
                    "fontSize": {
                        "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "label-caps": ["12px", {"lineHeight": "1", "letterSpacing": "0.1em", "fontWeight": "700"}],
                        "headline-md": ["24px", {"lineHeight": "1.2", "fontWeight": "600"}],
                        "headline-lg-mobile": ["28px", {"lineHeight": "1.2", "fontWeight": "700"}],
                        "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "display-hero": ["48px", {"lineHeight": "1.1", "letterSpacing": "0.05em", "fontWeight": "800"}],
                        "headline-lg": ["32px", {"lineHeight": "1.2", "letterSpacing": "0.02em", "fontWeight": "700"}]
                    }
                },
            },
        }
    </script>
    <style>
        .glass-panel {
            background: rgba(18, 18, 18, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Combat Animations */
        /* ataca/lansarea proiectilului */
        @keyframes projectile-right {
            0% { transform: translateX(0) scaleX(1); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateX(450px) scaleX(2); opacity: 0; }
        }
        @keyframes projectile-left {
            0% { transform: translateX(0) scaleX(-1); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateX(-450px) scaleX(-2); opacity: 0; }
        }
        @keyframes impact-spark {
            0% { transform: scale(0); opacity: 1; }
            100% { transform: scale(3); opacity: 0; }
        }
        /* Cartea aparatorului este zguduita cand e lovita */
        @keyframes shake-impact {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-12px) rotate(-1deg); }
            50% { transform: translateX(12px) rotate(1deg); }
            75% { transform: translateX(-6px); }
        }
        @keyframes shield-ripple {
            0% { transform: scale(0.7); opacity: 0; border-width: 20px; }
            20% { opacity: 1; }
            100% { transform: scale(1.5); opacity: 0; border-width: 1px; }
        }
        @keyframes aura-pulse {
            0%, 100% { filter: drop-shadow(0 0 20px rgba(255, 191, 0, 0.4)); }
            50% { filter: drop-shadow(0 0 50px rgba(255, 191, 0, 0.8)); }
        }
        @keyframes energy-burst {
            0% { filter: brightness(1); }
            50% { filter: brightness(2) drop-shadow(0 0 30px #ffbf00); }
            100% { filter: brightness(1); }
        }
        /*Peste imaginea personajului se aplica o culoare rosie aprinsa temporar*/
        @keyframes damage-flash {
            0% { filter: brightness(1) sepia(0) saturate(1); }
            20% { filter: brightness(1.5) sepia(1) saturate(5) hue-rotate(-50deg); }
            100% { filter: brightness(1) sepia(0) saturate(1); }
        }
        /* scanteie e fundal*/
        @keyframes ember-float {
            0% { transform: translateY(0) rotate(0deg); opacity: 0; }
            50% { opacity: 0.8; }
            100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
        }
        /* personajele se misca usor */
        @keyframes idle-breathe {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.02); }
        }

        .anim-idle { animation: idle-breathe 4s ease-in-out infinite; }
        .anim-shake { animation: shake-impact 0.3s cubic-bezier(.36,.07,.19,.97) both; }
        .anim-aura { animation: aura-pulse 0.8s infinite; }
        .anim-burst { animation: energy-burst 0.4s ease-out forwards; }
        .anim-flash { animation: damage-flash 0.4s ease-out forwards; }

        .projectile {
            position: absolute;
            top: 50%;
            width: 100px;
            height: 6px;
            z-index: 100;
            pointer-events: none;
            filter: blur(1px);
        }
        .hero-bolt {
            background: linear-gradient(90deg, transparent, #ffbf00, #fff);
            box-shadow: 0 0 30px #ffbf00, 0 0 10px #fff;
        }
        .monster-bolt {
            background: linear-gradient(-90deg, transparent, #2ff801, #fff);
            box-shadow: 0 0 30px #2ff801, 0 0 10px #fff;
        }

        .impact-effect {
            position: absolute;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(255,191,0,0.6) 40%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 110;
            animation: impact-spark 0.35s ease-out forwards;
        }

        .damage-popup {
            position: absolute;
            pointer-events: none;
            animation: damage-float 1s forwards cubic-bezier(0.18, 0.89, 0.32, 1.28);
            font-weight: 900;
            z-index: 120;
            white-space: nowrap;
        }
        @keyframes damage-float {
            0% { transform: translate(-50%, 0) scale(0.5); opacity: 0; }
            20% { transform: translate(-50%, -80px) scale(2); opacity: 1; }
            100% { transform: translate(-50%, -200px) scale(1); opacity: 0; }
        }

        .ember {
            position: fixed;
            background: #ffbf00;
            width: 2px;
            height: 2px;
            border-radius: 50%;
            pointer-events: none;
            z-index: -1;
            filter: blur(1px);
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #353534; border-radius: 10px; }

        .history-panel {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .history-panel.active {
            transform: translateX(0);
        }

        .health-bar-transition {
            transition: width 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .stat-panel-left {
            background: linear-gradient(to right, rgba(0,0,0,0.8), transparent);
            border-left: 2px solid rgba(255, 191, 0, 0.3);
        }
        .stat-panel-right {
            background: linear-gradient(to left, rgba(0,0,0,0.8), transparent);
            border-right: 2px solid rgba(47, 248, 1, 0.3);
        }

        .character-glow-primary {
            filter: drop-shadow(0 0 30px rgba(255, 191, 0, 0.2));
        }
        .character-glow-secondary {
            filter: drop-shadow(0 0 30px rgba(47, 248, 1, 0.2));
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md overflow-x-hidden min-h-screen">
<!-- Atmospheric Embers -->
<div class="fixed inset-0 pointer-events-none overflow-hidden z-[-1]" id="particle-container"><div class="ember" style="left: 33.0261vw; top: 42.1363vh; animation: 10.4798s linear 4.43405s infinite ember-float;"></div><div class="ember" style="left: 28.0617vw; top: 50.5534vh; animation: 12.2999s linear 1.71888s infinite ember-float;"></div><div class="ember" style="left: 39.4588vw; top: 77.7333vh; animation: 13.5779s linear 1.11005s infinite ember-float;"></div><div class="ember" style="left: 23.8405vw; top: 0.217459vh; animation: 6.77738s linear 3.032s infinite ember-float;"></div><div class="ember" style="left: 8.77554vw; top: 49.9448vh; animation: 8.93607s linear 8.69855s infinite ember-float;"></div><div class="ember" style="left: 7.24791vw; top: 97.9715vh; animation: 8.3885s linear 0.697489s infinite ember-float;"></div><div class="ember" style="left: 38.6012vw; top: 19.8139vh; animation: 13.5897s linear 7.67553s infinite ember-float;"></div><div class="ember" style="left: 8.08656vw; top: 77.978vh; animation: 12.8416s linear 5.56256s infinite ember-float;"></div><div class="ember" style="left: 32.0892vw; top: 9.15944vh; animation: 12.3148s linear 8.36503s infinite ember-float;"></div><div class="ember" style="left: 91.3727vw; top: 51.3948vh; animation: 8.13313s linear 0.799347s infinite ember-float;"></div><div class="ember" style="left: 73.4228vw; top: 75.2275vh; animation: 8.98905s linear 7.17769s infinite ember-float;"></div><div class="ember" style="left: 55.7418vw; top: 59.9031vh; animation: 9.74442s linear 5.30119s infinite ember-float;"></div><div class="ember" style="left: 22.7098vw; top: 66.8437vh; animation: 17.8875s linear 8.10954s infinite ember-float;"></div><div class="ember" style="left: 14.4791vw; top: 96.4531vh; animation: 16.9166s linear 4.2874s infinite ember-float;"></div><div class="ember" style="left: 52.9478vw; top: 42.2086vh; animation: 14.3118s linear 0.0102124s infinite ember-float;"></div><div class="ember" style="left: 15.4561vw; top: 2.13114vh; animation: 15.975s linear 1.30078s infinite ember-float;"></div><div class="ember" style="left: 22.9756vw; top: 38.5954vh; animation: 12.2113s linear 3.52148s infinite ember-float;"></div><div class="ember" style="left: 10.8741vw; top: 88.2728vh; animation: 10.6803s linear 9.97121s infinite ember-float;"></div><div class="ember" style="left: 46.6389vw; top: 2.36567vh; animation: 17.646s linear 9.08025s infinite ember-float;"></div><div class="ember" style="left: 15.8805vw; top: 19.6107vh; animation: 10.7369s linear 9.95641s infinite ember-float;"></div><div class="ember" style="left: 5.06533vw; top: 75.8074vh; animation: 12.226s linear 5.49126s infinite ember-float;"></div><div class="ember" style="left: 26.3214vw; top: 40.7942vh; animation: 16.0519s linear 7.07501s infinite ember-float;"></div><div class="ember" style="left: 84.0576vw; top: 4.54059vh; animation: 7.52091s linear 4.93789s infinite ember-float;"></div><div class="ember" style="left: 49.644vw; top: 64.2269vh; animation: 9.89487s linear 5.26142s infinite ember-float;"></div><div class="ember" style="left: 48.7509vw; top: 21.9147vh; animation: 11.4276s linear 8.26543s infinite ember-float;"></div><div class="ember" style="left: 51.0162vw; top: 10.0691vh; animation: 8.11629s linear 4.55845s infinite ember-float;"></div><div class="ember" style="left: 80.4369vw; top: 0.43649vh; animation: 11.7567s linear 9.54475s infinite ember-float;"></div><div class="ember" style="left: 91.6278vw; top: 60.8559vh; animation: 16.0833s linear 0.708621s infinite ember-float;"></div><div class="ember" style="left: 22.7641vw; top: 79.1833vh; animation: 9.31535s linear 6.99358s infinite ember-float;"></div><div class="ember" style="left: 62.3857vw; top: 11.3002vh; animation: 14.106s linear 4.44819s infinite ember-float;"></div><div class="ember" style="left: 14.7149vw; top: 55.9209vh; animation: 13.6246s linear 3.1309s infinite ember-float;"></div><div class="ember" style="left: 8.94445vw; top: 82.7156vh; animation: 14.0797s linear 3.73141s infinite ember-float;"></div><div class="ember" style="left: 11.3402vw; top: 29.8491vh; animation: 8.17084s linear 0.485207s infinite ember-float;"></div><div class="ember" style="left: 36.2772vw; top: 36.9557vh; animation: 11.1218s linear 9.18401s infinite ember-float;"></div><div class="ember" style="left: 88.0069vw; top: 8.33853vh; animation: 14.5549s linear 0.811119s infinite ember-float;"></div><div class="ember" style="left: 29.908vw; top: 61.1564vh; animation: 17.1493s linear 6.15208s infinite ember-float;"></div><div class="ember" style="left: 22.3801vw; top: 35.3198vh; animation: 13.0838s linear 9.9842s infinite ember-float;"></div><div class="ember" style="left: 45.7511vw; top: 51.5338vh; animation: 6.82795s linear 9.77231s infinite ember-float;"></div><div class="ember" style="left: 46.4821vw; top: 40.3797vh; animation: 16.3222s linear 4.8729s infinite ember-float;"></div><div class="ember" style="left: 64.0751vw; top: 12.6496vh; animation: 6.46325s linear 3.54854s infinite ember-float;"></div></div>
<!-- Top Navigation Bar -->
<header class="fixed top-0 w-full bg-background/60 backdrop-blur-xl border-b border-white/10 shadow-[0_0_15px_rgba(255,191,0,0.05)] flex justify-between items-center px-margin-desktop h-20 z-50">
    <div class="font-display-hero text-headline-md tracking-widest text-primary-fixed-dim">AETHERIS ARENA</div>
    <nav class="hidden md:flex gap-8">
        <a class="text-primary-container border-b-2 border-primary-container pb-1 font-label-caps text-label-caps transition-all duration-300" href="#">Dashboard</a>
        <a class="text-on-surface-variant hover:text-primary hover:bg-white/5 font-label-caps text-label-caps transition-all duration-300" href="#">Armory</a>
        <a class="text-on-surface-variant hover:text-primary hover:bg-white/5 font-label-caps text-label-caps transition-all duration-300" href="#">Tactics</a>
        <a class="text-on-surface-variant hover:text-primary hover:bg-white/5 font-label-caps text-label-caps transition-all duration-300" href="#">Rankings</a>
    </nav>
    <div class="flex items-center gap-4">
        <button class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-all">notifications</button>
        <button class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-all">settings</button>
        <div class="w-10 h-10 rounded-full border border-primary/20 overflow-hidden">
            <img alt="Commander Profile" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name=Commander&background=ffbf00&color=131313">
        </div>
    </div>
</header>
<!-- History Slide-over -->
<div class="fixed inset-y-0 right-0 w-80 bg-surface-container-highest/95 backdrop-blur-2xl z-[60] border-l border-white/10 history-panel p-6 shadow-2xl flex flex-col" id="history-sidebar">
    <div class="flex items-center justify-between mb-8">
        <h3 class="font-headline-md text-primary tracking-tight">BATTLE RECORDS</h3>
        <button class="material-symbols-outlined hover:text-primary" onclick="toggleHistory()">close</button>
    </div>
    <div class="flex-1 overflow-y-auto space-y-4" id="history-list">
        <div class="text-center py-8 opacity-40 italic font-body-md">No records found.</div>
    </div>
</div>
<!-- Main Content Canvas -->
<main class="pt-36 pb-20 px-margin-mobile md:px-margin-desktop max-w-screen-2xl mx-auto relative min-h-screen">
    <!-- Arena Visualizer Background -->
    <div class="fixed inset-0 -z-10 opacity-60 pointer-events-none overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-background"></div>
        <img class="w-full h-full object-cover grayscale brightness-[0.4]" src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1920&q=80" alt="Arena Background">
    </div>
    <!-- Combat Arena -->
    <div class="relative flex flex-col items-center justify-center min-h-[70vh] gap-12">
        <div class="w-full flex justify-between items-center relative gap-8 lg:gap-20">
            <!-- Kratos Combatant -->
            <div class="flex-1 flex justify-center relative group" id="hero-card-container">
                <!-- Floating Health Bar Hero -->
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-64 space-y-2 z-40">
                    <div class="flex justify-between items-end font-label-caps text-[10px] text-primary-container">
                        <span class="tracking-widest">VITALITY</span>
                        <span class="font-bold" id="hero-health-val">152 / 152</span>
                    </div>
                    <div class="h-3.5 bg-black/40 rounded-full overflow-hidden border border-white/10">
                        <div class="h-full bg-gradient-to-r from-primary-container to-amber-600 health-bar-transition shadow-[0_0_10px_rgba(255,191,0,0.5)]" id="hero-health-bar" style="width: 100%;"></div>
                    </div>
                </div>
                <!-- Attribute Panel Hero (Left) -->
                <div class="stat-panel-left absolute left-0 top-1/2 -translate-y-1/2 p-4 py-8 rounded-r-xl z-30 hidden lg:block backdrop-blur-sm">
                    <div class="space-y-6">
                        <div class="space-y-1">
                            <p class="font-label-caps text-[10px] text-on-surface-variant opacity-50">STRENGTH</p>
                            <div class="flex items-center gap-2 text-primary">
                                <span class="material-symbols-outlined text-sm">swords</span>
                                <span class="font-headline-md text-headline-md" id="hero-str">94</span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="font-label-caps text-[10px] text-on-surface-variant opacity-50">DEFENCE</p>
                            <div class="flex items-center gap-2 text-primary">
                                <span class="material-symbols-outlined text-sm">shield</span>
                                <span class="font-headline-md text-headline-md" id="hero-def">60</span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="font-label-caps text-[10px] text-on-surface-variant opacity-50">SPEED</p>
                            <div class="flex items-center gap-2 text-primary">
                                <span class="material-symbols-outlined text-sm">bolt</span>
                                <span class="font-headline-md text-headline-md" id="hero-spd">59</span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="font-label-caps text-[10px] text-on-surface-variant opacity-50">LUCK</p>
                            <div class="flex items-center gap-2 text-primary">
                                <span class="material-symbols-outlined text-sm">casino</span>
                                <span class="font-headline-md text-headline-md" id="hero-lck">23%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Kratos Character Silhouette -->
                <div class="relative character-glow-primary anim-idle transition-all duration-700" id="hero-card">
                    <!-- Shield Overlay (Magic Armour) -->
                    <div class="absolute inset-0 z-30 pointer-events-none border-[12px] border-blue-400/60 rounded-full opacity-0 scale-75" id="shield-overlay"></div>
                    <!-- Damage Flash Overlay -->
                    <div class="absolute inset-0 z-40 pointer-events-none opacity-0" id="hero-flash"></div>
                    <img alt="Kratos" class="h-[500px] w-auto object-contain drop-shadow-[0_0_40px_rgba(255,191,0,0.1)] mask-image-[linear-gradient(to_bottom,black_70%,transparent_100%)]" src="{{ asset('kratos.png') }}">
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 text-center w-full">
                        <h2 class="font-headline-lg text-headline-lg text-primary uppercase tracking-widest drop-shadow-lg">Kratos</h2>
                        <span class="font-label-caps text-label-caps text-primary-container tracking-tighter opacity-70">CHAMPION ASCENDANT</span>
                    </div>
                </div>
            </div>
            <!-- Center Command Circle -->
            <div class="flex flex-col items-center gap-6 z-40">
                <button class="w-40 h-40 rounded-full bg-primary-container text-on-primary-container font-headline-md text-headline-md flex flex-col items-center justify-center gap-1 transition-all duration-300 hover:scale-105 active:scale-95 shadow-[0_0_60px_rgba(255,191,0,0.4)] border-4 border-white/20 group overflow-hidden" id="simulate-btn" onclick="startBattle()">
                    <span class="material-symbols-outlined text-3xl group-hover:rotate-180 transition-transform duration-500">sports_kabaddi</span>
                    <span class="text-center tracking-tighter text-sm font-black">SIMULATE</span>
                </button>
                <div class="flex flex-col gap-2">
                    <button class="flex items-center gap-2 font-label-caps text-[10px] text-on-surface-variant hover:text-primary transition-colors bg-white/5 px-6 py-2 rounded-full border border-white/10 backdrop-blur-md" onclick="toggleHistory()">
                        <span class="material-symbols-outlined text-xs">history</span>
                        RECORDS
                    </button>
                    <div class="flex justify-center items-center gap-2 glass-panel p-1 rounded-full">
                        <button class="speed-btn p-1 px-3 rounded-full hover:bg-white/10 transition-colors font-label-caps text-[10px] opacity-50" onclick="changeSpeed(0.5, this)">.5x</button>
                        <button class="speed-btn p-1 px-3 rounded-full bg-primary-container/20 text-primary-container transition-colors font-label-caps text-[10px]" onclick="changeSpeed(1, this)">1x</button>
                        <button class="speed-btn p-1 px-3 rounded-full hover:bg-white/10 transition-colors font-label-caps text-[10px] opacity-50" onclick="changeSpeed(2, this)">2x</button>
                    </div>
                </div>
            </div>
            <!-- Monster Combatant -->
            <div class="flex-1 flex justify-center relative group" id="monster-card-container">
                <!-- Floating Health Bar Monster -->
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-64 space-y-2 z-40">
                    <div class="flex justify-between items-end font-label-caps text-[10px] text-secondary-container">
                        <span class="tracking-widest">ESSENCE</span>
                        <span class="font-bold" id="monster-health-val">146 / 146</span>
                    </div>
                    <div class="h-3.5 bg-black/40 rounded-full overflow-hidden border border-white/10">
                        <div class="h-full bg-gradient-to-r from-secondary-container to-green-800 health-bar-transition shadow-[0_0_10px_rgba(47,248,1,0.5)]" id="monster-health-bar" style="width: 100%;"></div>
                    </div>
                </div>
                <!-- Attribute Panel Monster (Right) -->
                <div class="stat-panel-right absolute right-0 top-1/2 -translate-y-1/2 p-4 py-8 rounded-l-xl z-30 hidden lg:block backdrop-blur-sm">
                    <div class="space-y-6 text-right">
                        <div class="space-y-1">
                            <p class="font-label-caps text-[10px] text-on-surface-variant opacity-50">STRENGTH</p>
                            <div class="flex items-center justify-end gap-2 text-secondary-container">
                                <span class="font-headline-md text-headline-md" id="monster-str">95</span>
                                <span class="material-symbols-outlined text-sm">skull</span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="font-label-caps text-[10px] text-on-surface-variant opacity-50">DEFENCE</p>
                            <div class="flex items-center justify-end gap-2 text-secondary-container">
                                <span class="font-headline-md text-headline-md" id="monster-def">60</span>
                                <span class="material-symbols-outlined text-sm">security</span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="font-label-caps text-[10px] text-on-surface-variant opacity-50">SPEED</p>
                            <div class="flex items-center justify-end gap-2 text-secondary-container">
                                <span class="font-headline-md text-headline-md" id="monster-spd">62</span>
                                <span class="material-symbols-outlined text-sm">bolt</span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="font-label-caps text-[10px] text-on-surface-variant opacity-50">LUCK</p>
                            <div class="flex items-center justify-end gap-2 text-secondary-container">
                                <span class="font-headline-md text-headline-md" id="monster-lck">38%</span>
                                <span class="material-symbols-outlined text-sm">casino</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Monster Character Silhouette -->
                <div class="relative character-glow-secondary anim-idle transition-all duration-700" id="monster-card">
                    <!-- Damage Flash Overlay -->
                    <div class="absolute inset-0 z-40 pointer-events-none opacity-0" id="monster-flash"></div>
                    <img alt="Monster" class="h-[500px] w-auto object-contain scale-x-[-1] drop-shadow-[0_0_40px_rgba(47,248,1,0.1)] mask-image-[linear-gradient(to_bottom,black_70%,transparent_100%)]" src="{{ asset('hydra.png') }}">
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 text-center w-full">
                        <h2 class="font-headline-lg text-headline-lg text-secondary-fixed uppercase tracking-widest drop-shadow-lg">HYDRA</h2>
                        <span class="font-label-caps text-label-caps text-secondary-container tracking-tighter opacity-70">WILD ENTITY</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Battle Log Section -->
    <section class="mt-12 glass-panel rounded-xl p-6 border-white/5 max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-headline-md text-headline-md flex items-center gap-2 tracking-tight">
                <span class="material-symbols-outlined text-primary-container">description</span>
                CHRONICLE
            </h3>
            <div class="flex gap-2 opacity-50">
                <button class="material-symbols-outlined p-1 hover:bg-white/5 rounded">fast_rewind</button>
                <button class="material-symbols-outlined p-1 hover:bg-white/5 rounded">fast_forward</button>
            </div>
        </div>
        <div class="h-40 overflow-y-auto space-y-3 font-body-md text-on-surface-variant text-sm pr-4" id="battle-log">
            <div class="flex gap-4 p-2 border-l-2 border-primary-container bg-primary-container/5">
                <span class="font-label-caps text-primary-container opacity-60">[ARENA]</span>
                <span class="italic opacity-60">Ready for combat initiation.</span>
            </div>
        </div>
    </section>
</main>
<!-- Mobile Navigation -->
<nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-margin-mobile h-16 md:hidden bg-surface-container-lowest/90 backdrop-blur-2xl border-t border-white/10">
    <div class="flex flex-col items-center justify-center bg-primary-container text-on-primary-container rounded-full px-6 py-1 shadow-[0_0_15px_rgba(255,191,0,0.4)] scale-90">
        <span class="material-symbols-outlined text-xl">sports_kabaddi</span>
        <span class="font-label-caps text-[8px]">ARENA</span>
    </div>
    <div class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 scale-90">
        <span class="material-symbols-outlined text-xl">radar</span>
        <span class="font-label-caps text-[8px]">INTEL</span>
    </div>
    <div class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 scale-90">
        <span class="material-symbols-outlined text-xl">flight_takeoff</span>
        <span class="font-label-caps text-[8px]">EVAC</span>
    </div>
</nav>
<!-- Victory Overlay -->
<div class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-xl flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-1000" id="victory-overlay">
    <div class="text-center p-12 glass-panel border-2 border-primary-container/50 max-w-xl w-full scale-90 transition-transform duration-700">
        <span class="font-label-caps text-primary-container text-headline-md tracking-[0.3em] block mb-4" id="victory-badge">BATTLE CONCLUDED</span>
        <h1 class="font-display-hero text-headline-lg text-primary mb-8 uppercase tracking-widest leading-none" id="victory-title">--</h1>
        <div class="grid grid-cols-2 gap-6 mb-10">
            <div class="bg-white/5 p-6 rounded border border-white/10 group">
                <p class="font-label-caps text-on-surface-variant text-[10px] opacity-60 mb-2">SEQUENCE LENGTH</p>
                <p class="font-headline-md text-headline-lg text-primary" id="stat-turns">--</p>
            </div>
            <div class="bg-white/5 p-6 rounded border border-white/10 group">
                <p class="font-label-caps text-on-surface-variant text-[10px] opacity-60 mb-2">REMAINING POWER</p>
                <p class="font-headline-md text-headline-lg text-primary" id="stat-hp">--</p>
            </div>
        </div>
        <button class="w-full bg-primary-container text-on-primary-container py-5 font-headline-md tracking-[0.2em] hover:brightness-110 active:scale-95 transition-all uppercase font-black" onclick="location.reload()">SYNC NEW REALITY</button>
    </div>
</div>
<script>
    const randomInt = (min, max) => Math.floor(Math.random() * (max - min + 1)) + min;

    let kratos, monster;
    let battleState = {
        speed: 1,
        isBattling: false,
        turn: 0,
        maxTurns: 15,
        history: []
    };

    function initParticles() {
        const container = document.getElementById('particle-container');
        for(let i=0; i<40; i++) {
            const ember = document.createElement('div');
            ember.className = 'ember';
            ember.style.left = Math.random() * 100 + 'vw';
            ember.style.top = Math.random() * 100 + 'vh';
            ember.style.animation = `ember-float ${6 + Math.random() * 12}s linear infinite`;
            ember.style.animationDelay = `${Math.random() * 10}s`;
            container.appendChild(ember);
        }
    }

    function toggleHistory() {
        document.getElementById('history-sidebar').classList.toggle('active');
    }

    function addHistoryEntry(winner, turns, hp) {
        const entry = {
            winner,
            turns,
            hp,
            timestamp: new Date().toLocaleTimeString()
        };
        battleState.history.unshift(entry);
        localStorage.setItem('battle_history', JSON.stringify(battleState.history));
        renderHistory();
    }

    function renderHistory() {
        const list = document.getElementById('history-list');
        if (battleState.history.length === 0) {
            list.innerHTML = '<div class="text-center py-8 opacity-40 italic font-body-md">No records found.</div>';
            return;
        }
        list.innerHTML = battleState.history.map(h => `
            <div class="bg-white/5 p-4 rounded border border-white/10 border-l-4 ${h.winner === 'Kratos' ? 'border-l-primary-container' : 'border-l-secondary-container'}">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-label-caps text-[10px] opacity-60">${h.timestamp}</span>
                    <span class="font-bold text-xs uppercase ${h.winner === 'Kratos' ? 'text-primary' : 'text-secondary-fixed'}">${h.winner} WON</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-body-md text-xs opacity-70">${h.turns} Turns</span>
                    <span class="font-body-md text-xs opacity-70">${h.hp}% Energy</span>
                </div>
            </div>
        `).join('');
    }

    function initStats() {
        kratos = {
            id: 'hero',
            name: 'Kratos',
            maxHp: randomInt(65, 100),
            strength: randomInt(75, 90),
            defence: randomInt(40, 50),
            speed: randomInt(40, 50),
            luck: randomInt(10, 20) / 100
        };
        kratos.hp = kratos.maxHp;

        monster = {
            id: 'monster',
            name: 'Hydra',
            maxHp: randomInt(50, 80),
            strength: randomInt(55, 80),
            defence: randomInt(50, 70),
            speed: randomInt(40, 60),
            luck: randomInt(30, 45) / 100
        };
        monster.hp = monster.maxHp;

        updateStaticStats();
    }

    function updateStaticStats() {
        document.getElementById('hero-str').innerText = kratos.strength;
        document.getElementById('hero-def').innerText = kratos.defence;
        document.getElementById('hero-spd').innerText = kratos.speed;
        document.getElementById('hero-lck').innerText = Math.round(kratos.luck * 100) + '%';

        document.getElementById('monster-str').innerText = monster.strength;
        document.getElementById('monster-def').innerText = monster.defence;
        document.getElementById('monster-spd').innerText = monster.speed;
        document.getElementById('monster-lck').innerText = Math.round(monster.luck * 100) + '%';

        updateHpUI(kratos);
        updateHpUI(monster);
    }

    function updateHpUI(entity) {
        const bar = document.getElementById(`${entity.id}-health-bar`);
        const val = document.getElementById(`${entity.id}-health-val`);
        const pct = Math.max(0, (entity.hp / entity.maxHp) * 100);

        bar.style.width = pct + '%';
        val.innerText = `${Math.ceil(entity.hp)} / ${entity.maxHp}`;
    }

    function changeSpeed(val, btn) {
        battleState.speed = val;
        document.querySelectorAll('.speed-btn').forEach(b => {
            b.classList.remove('bg-primary-container/20', 'text-primary-container');
            b.classList.add('opacity-50');
        });
        btn.classList.add('bg-primary-container/20', 'text-primary-container');
        btn.classList.remove('opacity-50');
    }

    async function startBattle() {
        if (battleState.isBattling) return;
        initStats();
        battleState.isBattling = true;
        battleState.turn = 0;

        const btn = document.getElementById('simulate-btn');
        btn.disabled = true;
        btn.classList.add('opacity-50', 'grayscale');

        document.getElementById('battle-log').innerHTML = '';
        logMessage("Synchronization establishing...", "primary-container");

        await new Promise(r => setTimeout(r, 800));
        logMessage("Real-time simulation protocol: ONLINE", "primary-container");

        runSimulationLoop();
    }

    function runSimulationLoop() {
        const loopInterval = 1600 / battleState.speed;
        const interval = setInterval(() => {
            if (kratos.hp <= 0 || monster.hp <= 0 || battleState.turn >= battleState.maxTurns) {
                clearInterval(interval);
                showVictory();
                return;
            }

            battleState.turn++;

            let attacker, defender;
            if (kratos.speed > monster.speed) {
                attacker = kratos; defender = monster;
            } else if (monster.speed > kratos.speed) {
                attacker = monster; defender = kratos;
            } else {
                attacker = kratos.luck > monster.luck ? kratos : monster;
                defender = attacker === kratos ? monster : kratos;
            }

            // Skill checks - Rapid fire: 15% chance
            if (attacker === kratos && Math.random() < 0.15) {
                triggerRapidFire(attacker, defender);
            } else {
                executeAttack(attacker, defender);
            }

            if (defender.hp > 0) {
                setTimeout(() => {
                    if (attacker.hp > 0 && defender.hp > 0) executeAttack(defender, attacker);
                }, 800 / battleState.speed);
            }

        }, loopInterval);
    }

    function triggerRapidFire(attacker, defender) {
        logMessage("KRATOS: Unleashing RAPID STRIKE!", "primary-container");
        const card = document.getElementById('hero-card');
        card.classList.add('anim-aura');

        executeAttack(attacker, defender, true);
        setTimeout(() => {
            if (defender.hp > 0) executeAttack(attacker, defender, true);
            setTimeout(() => {
                card.classList.remove('anim-aura');
            }, 600 / battleState.speed);
        }, 300 / battleState.speed);
    }

    function triggerShieldEffect() {
        const shield = document.getElementById('shield-overlay');
        shield.style.animation = 'none';
        void shield.offsetWidth;
        shield.style.animation = 'shield-ripple 0.8s ease-out forwards';
    }

    function spawnProjectile(attackerId, isRapid = false) {
        const attackerCard = document.getElementById(`${attackerId}-card`);
        const rect = attackerCard.getBoundingClientRect();

        const bolt = document.createElement('div');
        bolt.className = `projectile ${attackerId === 'hero' ? 'hero-bolt' : 'monster-bolt'}`;

        bolt.style.left = (rect.left + rect.width / 2) + 'px';
        bolt.style.top = (rect.top + rect.height / 2) + 'px';

        if (isRapid) {
            bolt.style.height = '8px';
            bolt.style.filter = 'blur(0px) brightness(2)';
        }

        const animName = attackerId === 'hero' ? 'projectile-right' : 'projectile-left';
        bolt.style.animation = `${animName} ${0.35 / battleState.speed}s cubic-bezier(0.19, 1, 0.22, 1) forwards`;

        document.body.appendChild(bolt);
        setTimeout(() => bolt.remove(), 500 / battleState.speed);
    }

    // Cartea aparatorului este zguduita cand e lovita
    function spawnImpact(targetId) {
        const targetCard = document.getElementById(`${targetId}-card`);
        const rect = targetCard.getBoundingClientRect();

        const impact = document.createElement('div');
        impact.className = 'impact-effect';
        impact.style.left = (rect.left + rect.width / 2 - 60) + 'px';
        impact.style.top = (rect.top + rect.height / 2 - 60) + 'px';

        if(targetId === 'monster') {
            impact.style.background = 'radial-gradient(circle, #fff 0%, rgba(47, 248, 1, 0.6) 40%, transparent 70%)';
        }

        document.body.appendChild(impact);
        setTimeout(() => impact.remove(), 400);
    }

    function triggerHitFeedback(targetId) {
        const card = document.getElementById(`${targetId}-card`);
        const flash = document.getElementById(`${targetId}-flash`);

        card.classList.remove('anim-shake');
        void card.offsetWidth;
        card.classList.add('anim-shake');

        flash.classList.remove('anim-flash');
        void flash.offsetWidth;
        flash.classList.add('anim-flash');
    }

    function executeAttack(attacker, defender, isRapid = false) {
        spawnProjectile(attacker.id, isRapid);

        setTimeout(() => {
            if (Math.random() < defender.luck) {
                logMessage(`${defender.name} EVADED the strike!`, "inverse-surface");
                showPopup("EVADE", defender.id);
                return;
            }

            // Strict Formula: Damage = Attacker strength - Defender defence
            let damage = attacker.strength - defender.defence;
            if (damage < 0) damage = 0; // prevent negative damage

            let skillText = "";
            // Magic armour: 15% chance to halve damage when defending
            if (defender.id === 'hero' && Math.random() < 0.15) {
                damage = Math.floor(damage * 0.5);
                skillText = "[MAGIC ARMOUR] ";
                triggerShieldEffect();
            }

            spawnImpact(defender.id);
            triggerHitFeedback(defender.id);

            defender.hp = Math.max(0, defender.hp - damage);
            updateHpUI(defender);
            showPopup(`-${damage}`, defender.id);

            logMessage(`${skillText}${attacker.name} strikes for ${damage} damage (Defender HP left: ${Math.ceil(defender.hp)}).`, attacker.id === 'hero' ? "primary-container" : "secondary-container");
        }, 320 / battleState.speed);
    }

    function showPopup(text, targetId) {
        const card = document.getElementById(`${targetId}-card`);
        const rect = card.getBoundingClientRect();
        const popup = document.createElement('div');
        popup.className = `damage-popup font-headline-md text-headline-lg ${text === 'EVADE' ? 'text-white' : (targetId === 'hero' ? 'text-red-500' : 'text-primary-container')}`;
        popup.style.left = (rect.left + rect.width / 2) + 'px';
        popup.style.top = (rect.top + rect.height / 4) + 'px';
        popup.innerText = text;
        document.body.appendChild(popup);
        setTimeout(() => popup.remove(), 1000);
    }

    function logMessage(msg, colorClass) {
        const log = document.getElementById('battle-log');
        const entry = document.createElement('div');
        entry.className = `flex gap-4 p-2 border-l-2 border-${colorClass}/40 hover:bg-white/5 transition-colors animate-in fade-in slide-in-from-left-4`;
        entry.innerHTML = `<span class="font-label-caps text-${colorClass} opacity-70">[SEQ ${battleState.turn.toString().padStart(2, '0')}]</span><span>${msg}</span>`;
        log.prepend(entry);
    }

    function showVictory() {
        const overlay = document.getElementById('victory-overlay');
        const title = document.getElementById('victory-title');
        const badge = document.getElementById('victory-badge');

        let winnerName = "";
        let winPct = 0;

        if (kratos.hp > monster.hp) {
            winnerName = "Kratos";
            winPct = Math.round((kratos.hp / kratos.maxHp) * 100);
            title.innerText = "KRATOS TRANSCENDENT";
            title.classList.add('text-primary');
            badge.innerText = "CHAMPION ASCENDANT";
            document.getElementById('stat-hp').innerText = winPct + '%';
        } else if (monster.hp > kratos.hp) {
            winnerName = "Hydra";
            winPct = Math.round((monster.hp / monster.maxHp) * 100);
            title.innerText = "HYDRA WON";
            title.classList.add('text-secondary-fixed');
            badge.innerText = "SIMULATION TERMINATED";
            document.getElementById('stat-hp').innerText = winPct + '%';
        } else {
            winnerName = "None";
            title.innerText = "MUTUAL VOID";
            badge.innerText = "PROTOCOL CRITICAL";
            document.getElementById('stat-hp').innerText = "0%";
        }

        addHistoryEntry(winnerName, battleState.turn, winPct);
        document.getElementById('stat-turns').innerText = battleState.turn;
        overlay.classList.remove('opacity-0', 'pointer-events-none');
        overlay.querySelector('div').classList.remove('scale-90');
    }

    window.onload = () => {
        const savedHistory = localStorage.getItem('battle_history');
        if (savedHistory) {
            try {
                battleState.history = JSON.parse(savedHistory);
                renderHistory();
            } catch (e) {
                console.error("Failed to parse battle history", e);
            }
        }
        initStats();
        initParticles();
    };
</script>
</body>
</html>
