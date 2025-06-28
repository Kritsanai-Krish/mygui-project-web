<?php require_once __DIR__."/core/functions.php"; requireLicense(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu GUI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* General Setup */
        :root {
            --white: hsl(0, 0%, 100%);
            --black: hsl(240, 15%, 9%);
            --paragraph: hsl(0, 0%, 83%);
            --line: hsl(240, 9%, 17%);
            --primary: hsl(266, 92%, 58%);
            --danger: hsl(0, 79%, 63%);
            --bg-color: #191a1a;
            --grid-color: rgba(114, 114, 114, 0.3);
        }

        body {
            width: 100%;
            min-height: 100vh;
            --color: var(--grid-color);
            background-color: var(--bg-color);
            background-image: linear-gradient(0deg, transparent 24%, var(--color) 25%, var(--color) 26%, transparent 27%,transparent 74%, var(--color) 75%, var(--color) 76%, transparent 77%,transparent),
                            linear-gradient(90deg, transparent 24%, var(--color) 25%, var(--color) 26%, transparent 27%,transparent 74%, var(--color) 75%, var(--color) 76%, transparent 77%,transparent);
            background-size: 55px 55px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 0;
            color: var(--white);
        }

        /* Main Menu Card Container */
        .menu-card {
            width: 90%;
            max-width: 600px;
            background-color: hsla(240, 15%, 9%, 1);
            background-image: radial-gradient(at 88% 40%, hsla(240, 15%, 9%, 1) 0px, transparent 85%),
                              radial-gradient(at 49% 30%, hsla(240, 15%, 9%, 1) 0px, transparent 85%),
                              radial-gradient(at 14% 26%, hsla(240, 15%, 9%, 1) 0px, transparent 85%),
                              radial-gradient(at 0% 64%, hsla(263, 93%, 56%, 0.3) 0px, transparent 85%),
                              radial-gradient(at 41% 94%, hsla(284, 100%, 84%, 0.2) 0px, transparent 85%),
                              radial-gradient(at 100% 99%, hsla(306, 100%, 57%, 0.4) 0px, transparent 85%);
            border-radius: 1rem;
            box-shadow: 0px -16px 24px 0px rgba(255, 255, 255, 0.1) inset, 0 20px 50px rgba(0,0,0,0.5);
            padding: 1.5rem 2rem;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Tab Navigation */
        .tabs-container {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .tabs {
            display: flex;
            position: relative;
            background-color: #2a2a2e;
            box-shadow: 0 0 1px 0 rgba(24, 94, 224, 0.15), 0 6px 12px 0 rgba(0, 0, 0, 0.3);
            padding: 0.5rem;
            border-radius: 99px;
        }

        .tabs * { z-index: 2; }

        .tabs input[type="radio"] { display: none; }

        .tab-label {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            width: 120px;
            font-size: 1rem;
            color: var(--paragraph);
            font-weight: 500;
            border-radius: 99px;
            cursor: pointer;
            transition: color 0.15s ease-in;
        }

        .tabs input[type="radio"]:checked + .tab-label { color: var(--white); }

        .glider {
            position: absolute;
            display: flex;
            height: 40px;
            width: 120px;
            background-color: var(--primary);
            z-index: 1;
            border-radius: 99px;
            transition: transform 0.25s ease-out;
            box-shadow: 0 0 15px 2px rgba(154, 73, 230, 0.5);
        }
        
        #radio-1:checked ~ .glider { transform: translateX(0); }
        #radio-2:checked ~ .glider { transform: translateX(100%); }
        #radio-3:checked ~ .glider { transform: translateX(200%); }

        /* Tab Content */
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            font-size: 1.8rem;
            color: var(--white);
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
            padding-left: 1rem;
        }

        .setting-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
        }
        .setting-row span.label-text, .setting-row .label-text {
            font-size: 1rem;
            font-weight: 500;
        }


        /* Toggle Button */
        .toggle-label {
            height: 40px;
            width: 80px;
            background-color: #333;
            border-radius: 20px;
            box-shadow: inset 0 0 5px 2px rgba(0, 0, 0, 0.5), 0 5px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
            transition: transform 0.4s;
        }

        .toggle-label:hover {
            transform: scale(1.05);
        }

        .toggle-checkbox { display: none; }

        .toggle-checkbox:checked + .toggle-label { background-color: var(--primary); }

        .toggle-checkbox:checked + .toggle-label::before {
            transform: translateX(40px);
            background-color: #fff;
            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.3), 5px 5px 5px rgba(0, 0, 0, 0.2);
        }

        .toggle-label::before {
            position: absolute;
            content: "";
            height: 32px;
            width: 32px;
            border-radius: 50%;
            background-color: #555;
            left: 4px;
            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.3), -5px 5px 5px rgba(0, 0, 0, 0.2);
            transition: 0.4s ease;
        }

        /* Custom Dropdown */
        .dropdown {
            position: relative;
            width: 150px;
        }
        .dropdown-selected {
            background-color: #ccc;
            color: #333;
            padding: 10px 15px;
            border-radius: 15px;
            cursor: pointer;
            box-shadow: inset 2px 5px 10px rgba(0,0,0,0.3);
            transition: 300ms ease-in-out;
            text-align: center;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 110%;
            left: 0;
            width: 100%;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
            z-index: 10;
            overflow: hidden;
        }
        .dropdown-item {
            padding: 10px 15px;
            color: var(--paragraph);
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .dropdown-item:hover {
            background-color: var(--primary);
            color: var(--white);
        }

        /* Key Input Button */
        .key-input {
            border: none;
            outline: none;
            border-radius: 15px;
            padding: 1em;
            background-color: #ccc;
            color: #333;
            box-shadow: inset 2px 5px 10px rgba(0,0,0,0.3);
            transition: 300ms ease-in-out;
            cursor: pointer;
            font-weight: bold;
            min-width: 150px;
            text-align: center;
        }
        .key-input:hover, .key-input.listening {
            background-color: white;
            transform: scale(1.05);
            box-shadow: 13px 13px 100px #969696, -13px -13px 100px #ffffff;
        }
        .key-input.listening {
            cursor: wait;
        }

        /* Custom Slider */
        .slider-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .slider {
            -webkit-appearance: none;
            width: 150px;
            height: 10px;
            background: #444;
            outline: none;
            border-radius: 5px;
            opacity: 0.7;
            transition: opacity .2s;
        }
        .slider:hover { opacity: 1; }
        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: var(--primary);
            cursor: pointer;
            border-radius: 50%;
            border: 2px solid var(--white);
        }
        .slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: var(--primary);
            cursor: pointer;
            border-radius: 50%;
            border: 2px solid var(--white);
        }
        .slider-value {
            font-weight: bold;
            min-width: 30px;
        }

        /* Color Input */
        .color-input-container {
             display: flex;
             align-items: center;
             gap: 10px;
        }

        .color-input {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 40px;
            height: 40px;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }
        .color-input::-webkit-color-swatch {
            border-radius: 50%;
            border: 2px solid #fff;
        }
        .color-input::-moz-color-swatch {
            border-radius: 50%;
            border: 2px solid #fff;
        }
        
        #visible-check-options {
            display: none;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--line);
        }

        /* Settings Page Buttons */
        .settings-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .styled-button {
            outline: none;
            cursor: pointer;
            border: 0;
            position: relative;
            border-radius: 100px;
            background-color: #080808;
            transition: all 0.2s ease;
            box-shadow: inset 0 0.3rem 0.9rem rgba(255, 255, 255, 0.3), inset 0 -0.1rem 0.3rem rgba(0, 0, 0, 0.7), inset 0 -0.4rem 0.9rem rgba(255, 255, 255, 0.5), 0 3rem 3rem rgba(0, 0, 0, 0.3), 0 1rem 1rem -0.6rem rgba(0, 0, 0, 0.8);
            width: 250px;
        }

        .styled-button.reset {
            background-color: var(--danger);
            box-shadow: inset 0 0.3rem 0.9rem rgba(255, 255, 255, 0.4), inset 0 -0.1rem 0.3rem rgba(0, 0, 0, 0.7), inset 0 -0.4rem 0.9rem rgba(255, 255, 255, 0.6), 0 3rem 3rem rgba(0, 0, 0, 0.3), 0 1rem 1rem -0.6rem rgba(0, 0, 0, 0.8);
        }

        .styled-button .wrap {
            font-size: 20px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            padding: 20px 30px;
            border-radius: inherit;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
        }
        
        .styled-button.reset .wrap {
            color: var(--white);
        }

        .styled-button .wrap::before, .styled-button .wrap::after {
            content: "";
            position: absolute;
            transition: all 0.3s ease;
        }

        .styled-button .wrap::before {
            left: -15%; right: -15%; bottom: 25%; top: -100%;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.12);
        }

        .styled-button .wrap::after {
            left: 6%; right: 6%; top: 12%; bottom: 40%;
            border-radius: 22px 22px 0 0;
            box-shadow: inset 0 10px 8px -10px rgba(255, 255, 255, 0.8);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.3) 0%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0) 100%);
        }

        .styled-button:hover {
            box-shadow: inset 0 0.3rem 0.5rem rgba(255, 255, 255, 0.4), inset 0 -0.1rem 0.3rem rgba(0, 0, 0, 0.7), inset 0 -0.4rem 0.9rem rgba(255, 255, 255, 0.7), 0 3rem 3rem rgba(0, 0, 0, 0.3), 0 1rem 1rem -0.6rem rgba(0, 0, 0, 0.8);
        }
        .styled-button:active {
            transform: translateY(4px);
        }
        #upload-config-input {
            display: none;
        }
        
        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--primary);
            color: var(--white);
            padding: 1rem 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s, transform 0.3s;
        }

        .toast.show {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -10px);
        }

        .toast.error {
            background-color: #e62222;
        }

    </style>
</head>
<body>

    <div class="menu-card">
        <!-- Tab Navigation -->
        <div class="tabs-container">
            <div class="tabs">
                <input type="radio" id="radio-1" name="tabs" data-content="aim-content" checked>
                <label class="tab-label" for="radio-1">Aim</label>
                <input type="radio" id="radio-2" name="tabs" data-content="visuals-content">
                <label class="tab-label" for="radio-2">Visuals</label>
                <input type="radio" id="radio-3" name="tabs" data-content="settings-content">
                <label class="tab-label" for="radio-3">Settings</label>
                <span class="glider"></span>
            </div>
        </div>
        
        <!-- Aim Tab Content -->
        <div id="aim-content" class="tab-content active">
            <h2>Aim Settings</h2>
            <div class="setting-row">
                <span class="label-text">Aimbot</span>
                <input type="checkbox" id="aimbot-toggle" class="toggle-checkbox" data-config="aimbotEnabled">
                <label for="aimbot-toggle" class="toggle-label"></label>
            </div>
            <div class="setting-row">
                <span class="label-text">Target</span>
                <div class="dropdown" id="aim-target-dropdown">
                    <div class="dropdown-selected" data-config="aimTarget">Head</div>
                    <div class="dropdown-menu">
                        <div class="dropdown-item">Head</div>
                        <div class="dropdown-item">Chest</div>
                        <div class="dropdown-item">Legs</div>
                        <div class="dropdown-item">Automatic</div>
                    </div>
                </div>
            </div>
             <div class="setting-row">
                <span class="label-text">Wall Check</span>
                <input type="checkbox" id="wallcheck-toggle" class="toggle-checkbox" data-config="wallCheckEnabled">
                <label for="wallcheck-toggle" class="toggle-label"></label>
            </div>
            <div class="setting-row">
                <span class="label-text">Aimbot Button</span>
                <button class="key-input" id="aimbot-key" data-config="aimbotKey">Not Set</button>
            </div>
            <div class="setting-row">
                <span class="label-text">FOV</span>
                <div class="slider-container">
                    <input type="range" min="1" max="100" value="10" class="slider" id="fov-slider" data-config="fovValue">
                    <span class="slider-value" id="fov-value">10</span>
                </div>
            </div>
            <div class="setting-row">
                <span class="label-text">Smooth</span>
                 <div class="slider-container">
                    <input type="range" min="1" max="100" value="5" class="slider" id="smooth-slider" data-config="smoothValue">
                    <span class="slider-value" id="smooth-value">5</span>
                </div>
            </div>
        </div>

        <!-- Visuals Tab Content -->
        <div id="visuals-content" class="tab-content">
            <h2>Visuals Settings</h2>
            <div class="setting-row">
                <span class="label-text">Enable ESP</span>
                <input type="checkbox" id="esp-toggle" class="toggle-checkbox" data-config="espEnabled">
                <label for="esp-toggle" class="toggle-label"></label>
            </div>
            <div class="setting-row">
                <span class="label-text">Disable / Enable ESP</span>
                <button class="key-input" id="esp-key" data-config="espKey">Not Set</button>
            </div>
            <div class="setting-row">
                <span class="label-text">Skeleton</span>
                <input type="checkbox" id="skeleton-toggle" class="toggle-checkbox" data-config="skeletonEnabled">
                <label for="skeleton-toggle" class="toggle-label"></label>
            </div>
            <div class="setting-row">
                <span class="label-text">Box ESP</span>
                <input type="checkbox" id="box-toggle" class="toggle-checkbox" data-config="boxEnabled">
                <label for="box-toggle" class="toggle-label"></label>
            </div>
            <div class="setting-row">
                <span class="label-text">Visibility Check</span>
                <input type="checkbox" id="visible-check-toggle" class="toggle-checkbox" data-config="visibilityCheckEnabled">
                <label for="visible-check-toggle" class="toggle-label"></label>
            </div>
            <div id="visible-check-options">
                <div class="setting-row">
                    <span class="label-text">Visible Color</span>
                    <div class="color-input-container">
                        <input type="color" class="color-input" id="visible-color" value="#00ff00" data-config="visibleColor">
                    </div>
                </div>
                 <div class="setting-row">
                    <span class="label-text">Invisible Color</span>
                    <div class="color-input-container">
                       <input type="color" class="color-input" id="invisible-color" value="#ff0000" data-config="invisibleColor">
                    </div>
                </div>
                 <div class="setting-row">
                    <span class="label-text">Last Seen Color</span>
                    <div class="color-input-container">
                       <input type="color" class="color-input" id="lastseen-color" value="#ffff00" data-config="lastSeenColor">
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Tab Content -->
        <div id="settings-content" class="tab-content">
            <h2>Configuration</h2>
            <div class="settings-buttons">
                <button id="save-config-button" class="styled-button">
                    <span class="wrap"><i class="fas fa-save"></i> Save Config</span>
                </button>
                <button id="export-config-button" class="styled-button">
                    <span class="wrap"><i class="fas fa-file-export"></i> Export Config</span>
                </button>
                <button id="upload-config-button" class="styled-button">
                    <span class="wrap"><i class="fas fa-upload"></i> Load Config</span>
                </button>
                 <button id="reset-config-button" class="styled-button reset">
                    <span class="wrap"><i class="fas fa-sync-alt"></i> Reset Config</span>
                </button>
                <input type="file" id="upload-config-input" accept=".json">
            </div>
        </div>
    </div>
    
    <div id="toast" class="toast"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const CONFIG_COOKIE_NAME = 'gameMenuConfig';

        // --- HELPER FUNCTIONS ---
        function showToast(message, isError = false) {
            const toast = document.getElementById('toast');
            if (!toast) return;

            toast.textContent = message;
            toast.className = 'toast show';
            if (isError) {
                toast.classList.add('error');
            }

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // --- Cookie Functions ---
        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/; SameSite=Lax";
        }

        function getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }
        
        function eraseCookie(name) {   
            document.cookie = name+'=; Max-Age=-99999999;';  
        }


        // --- UI LOGIC ---

        // Tab switching logic
        const tabs = document.querySelectorAll('input[name="tabs"]');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('change', () => {
                tabContents.forEach(content => content.classList.remove('active'));
                const activeContentId = tab.dataset.content;
                const activeContent = document.getElementById(activeContentId);
                if (activeContent) {
                    activeContent.classList.add('active');
                }
            });
        });

        // Dropdown logic
        const dropdown = document.getElementById('aim-target-dropdown');
        if (dropdown) {
            const selected = dropdown.querySelector('.dropdown-selected');
            const menu = dropdown.querySelector('.dropdown-menu');
            const items = dropdown.querySelectorAll('.dropdown-item');

            selected.addEventListener('click', () => {
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });

            items.forEach(item => {
                item.addEventListener('click', () => {
                    selected.textContent = item.textContent;
                    selected.dataset.value = item.textContent;
                    menu.style.display = 'none';
                });
            });

            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    menu.style.display = 'none';
                }
            });
        }

        // --- NEW Keybinding logic ---
        const keyButtons = document.querySelectorAll('.key-input');
        let currentButton = null;
        let pendingKey = null;

        function stopListening() {
            if (currentButton) {
                currentButton.classList.remove('listening');
                currentButton.textContent = currentButton.dataset.confirmedValue || 'Not Set';
            }
            document.removeEventListener('keydown', handleInput);
            document.removeEventListener('mousedown', handleInput);
            currentButton = null;
            pendingKey = null;
        }

        function handleInput(e) {
            if (!currentButton) return;
            e.preventDefault();
            e.stopPropagation();

            if (e.type === 'keydown' && e.key === 'Enter') {
                if (pendingKey) {
                    currentButton.textContent = pendingKey;
                    currentButton.dataset.confirmedValue = pendingKey;
                    stopListening();
                }
                return;
            }

            if (e.type === 'keydown' && e.key === 'Escape') {
                stopListening();
                return;
            }

            let capturedInput = null;
            if (e.type === 'keydown') {
                capturedInput = e.key.toUpperCase();
            } else if (e.type === 'mousedown') {
                const mouseMap = { 0: 'MOUSE 1', 1: 'MOUSE 3', 2: 'MOUSE 2' };
                capturedInput = mouseMap[e.button] || `MOUSE ${e.button + 1}`;
            }

            if (capturedInput) {
                pendingKey = capturedInput;
                currentButton.textContent = `Confirm: ${pendingKey} (Enter)`;
            }
        }

        keyButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                if (currentButton === button) return;
                
                if (currentButton) {
                    stopListening();
                }

                currentButton = button;
                if (!button.dataset.confirmedValue) {
                    button.dataset.confirmedValue = button.textContent;
                }
                
                button.textContent = 'Press a key or mouse...';
                button.classList.add('listening');
                pendingKey = null;

                document.addEventListener('keydown', handleInput);
                document.addEventListener('mousedown', handleInput);
            });
        });

        document.addEventListener('click', (e) => {
            if (currentButton && !currentButton.contains(e.target)) {
                stopListening();
            }
        });


        // Slider value display logic
        const fovSlider = document.getElementById('fov-slider');
        const fovValue = document.getElementById('fov-value');
        if(fovSlider && fovValue) fovSlider.oninput = () => { fovValue.textContent = fovSlider.value; };

        const smoothSlider = document.getElementById('smooth-slider');
        const smoothValue = document.getElementById('smooth-value');
        if(smoothSlider && smoothValue) smoothSlider.oninput = () => { smoothValue.textContent = smoothSlider.value; };

        // Visibility Check options toggle
        const visibleCheckToggle = document.getElementById('visible-check-toggle');
        const visibleCheckOptions = document.getElementById('visible-check-options');
        if(visibleCheckToggle && visibleCheckOptions) {
            visibleCheckToggle.addEventListener('change', () => {
                visibleCheckOptions.style.display = visibleCheckToggle.checked ? 'flex' : 'none';
            });
        }

        // --- CONFIGURATION LOGIC ---
        
        const saveButton = document.getElementById('save-config-button');
        const exportButton = document.getElementById('export-config-button');
        const loadButton = document.getElementById('upload-config-button');
        const loadInput = document.getElementById('upload-config-input');
        const resetButton = document.getElementById('reset-config-button');

        function collectConfig() {
            const config = {};
            const elements = document.querySelectorAll('[data-config]');
            elements.forEach(el => {
                const key = el.dataset.config;
                if (el.type === 'checkbox') {
                    config[key] = el.checked;
                } else if (el.type === 'range' || el.type === 'color') {
                    config[key] = el.value;
                } else if (el.classList.contains('dropdown-selected')) {
                    config[key] = el.textContent;
                } else {
                    config[key] = el.dataset.confirmedValue || el.textContent;
                }
            });
            return config;
        }

        function applyConfig(config) {
             const elements = document.querySelectorAll('[data-config]');
             elements.forEach(el => {
                const key = el.dataset.config;
                if (config.hasOwnProperty(key)) {
                    if (el.type === 'checkbox') {
                        el.checked = config[key];
                        if(el.id === 'visible-check-toggle') {
                             el.dispatchEvent(new Event('change'));
                        }
                    } else if (el.type === 'range') {
                        el.value = config[key];
                        el.dispatchEvent(new Event('input'));
                    } else if (el.type === 'color') {
                        el.value = config[key];
                    } else if (el.classList.contains('dropdown-selected')) {
                         el.textContent = config[key];
                    } else {
                        el.textContent = config[key];
                        if (el.classList.contains('key-input')) {
                            el.dataset.confirmedValue = config[key];
                        }
                    }
                }
             });
        }

        function downloadConfig(filename, text) {
            const element = document.createElement('a');
            element.setAttribute('href', 'data:text/json;charset=utf-8,' + encodeURIComponent(text));
            element.setAttribute('download', filename);
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }
        
        // Save to Cookies
        if(saveButton) {
            saveButton.addEventListener('click', () => {
                const configData = JSON.stringify(collectConfig());
                setCookie(CONFIG_COOKIE_NAME, configData, 365);
                showToast('Config Saved!');
            });
        }
        
        // Export to File
        if (exportButton) {
            exportButton.addEventListener('click', () => {
                const configData = JSON.stringify(collectConfig(), null, 2);
                downloadConfig('config.json', configData);
                showToast('Config exported to file!');
            });
        }
        
        // Load from File
        if(loadButton) {
            loadButton.addEventListener('click', () => {
                loadInput.click();
            });
        }

        if(loadInput) {
            loadInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    try {
                        const config = JSON.parse(e.target.result);
                        applyConfig(config);
                        showToast('Config loaded from file!');
                    } catch (error) {
                        console.error("Error parsing config file:", error);
                        showToast('Failed to load config from file.', true);
                    }
                };
                reader.readAsText(file);
                event.target.value = '';
            });
        }
        
        // Reset Config
        if(resetButton) {
            resetButton.addEventListener('click', () => {
                eraseCookie(CONFIG_COOKIE_NAME);
                showToast('Config reset. Reloading...');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            });
        }
        
        // --- Load Config From Cookie on Page Load ---
        function loadConfigOnStart() {
            const savedConfig = getCookie(CONFIG_COOKIE_NAME);
            if(savedConfig) {
                try {
                    const config = JSON.parse(savedConfig);
                    applyConfig(config);
                    showToast('Loaded config from cookies.');
                } catch(e) {
                    console.error("Could not parse config from cookie", e);
                    showToast('Could not load config from cookie.', true);
                }
            }
        }
        
        loadConfigOnStart();
    });
    </script>
</body>
</html>
