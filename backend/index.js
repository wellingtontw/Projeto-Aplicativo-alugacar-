document.addEventListener("DOMContentLoaded", function () {
    const images = [
        "./images/pcx.png",
        "./images/civic.png",
        "./images/ranger.png"
    ];

    const texts = [
        "Descrição da imagem 1", 
        "Descrição da imagem 2", 
        "Descrição da imagem 3"  
    ];

    let currentIndex = 0;
    const imgElement = document.getElementById("carousel-image");
    const textElement = document.getElementById("carousel-text"); 
    const prevButton = document.getElementById("prev");
    const nextButton = document.getElementById("next");
    function updateImage() {
        imgElement.src = images[currentIndex];
        textElement.textContent = texts[currentIndex]; 
    }

    nextButton.addEventListener("click", function () {
        currentIndex = (currentIndex + 1) % images.length;
        updateImage();
    });

    prevButton.addEventListener("click", function () {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateImage();
    });

    updateImage();
});

document.addEventListener("DOMContentLoaded", function () {
                const images = [
                    { src: "./images/pcx.png", text: "Texto para a primeira imagem" },
                    { src: "./images/civic.png", text: "Texto para a segunda imagem" },
                    { src: "./images/ranger.png", text: "Texto para a terceira imagem" }
                ];

                let currentIndex = 0;
                const imgElement = document.getElementById("carousel-image");
                const textElement = document.getElementById("carousel-text");
                const prevButton = document.getElementById("prev");
                const nextButton = document.getElementById("next");

                function updateImage() {
                    imgElement.src = images[currentIndex].src;
                    textElement.textContent = images[currentIndex].text;
                }

                nextButton.addEventListener("click", function () {
                    currentIndex = (currentIndex + 1) % images.length;
                    updateImage();
                });

                prevButton.addEventListener("click", function () {
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                    updateImage();
                });

                setInterval(() => {
                    currentIndex = (currentIndex + 1) % images.length;
                    updateImage();
                }, 3000);

                updateImage();
            });

        function toggleTheme() {
            const link = document.getElementById('theme-style');
            const currentTheme = link.getAttribute('href');
            const btn = document.getElementById('toggle-btn');
            document.body.classList.toggle('dark-theme');
            if (currentTheme === 'SiteD.css') {
                link.setAttribute('href', 'SiteL.css');
                btn.innerHTML = `
                    <!-- Ícone de Lua -->
                    <svg width="28" height="28" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <radialGradient id="moonGradient" cx="50%" cy="50%" r="50%">
                                <stop offset="0%" stop-color="#B0C4DE"/>
                                <stop offset="100%" stop-color="#708090"/>
                            </radialGradient>
                        </defs>
                        <path fill="url(#moonGradient)" d="M21 12.79A9 9 0 0111.21 3 7 7 0 0012 21a9 9 0 009-8.21z"/>
                    </svg>
                `;        
                localStorage.setItem('theme', 'light'); 
            } else {
                link.setAttribute('href', 'SiteD.css');
                btn.innerHTML = `
                    <!-- Ícone de Sol -->
                    <svg width="28" height="28" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <radialGradient id="sunGradient" cx="50%" cy="50%" r="50%">
                                <stop offset="0%" stop-color="#FFD93B"/>
                                <stop offset="100%" stop-color="#FFA500"/>
                            </radialGradient>
                        </defs>
                        <circle cx="12" cy="12" r="5" fill="url(#sunGradient)"/>
                        <g stroke="#FFA500" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="3"/>
                            <line x1="12" y1="21" x2="12" y2="23"/>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                            <line x1="1" y1="12" x2="3" y2="12"/>
                            <line x1="21" y1="12" x2="23" y2="12"/>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                        </g>
                    </svg>
                `;
                localStorage.setItem('theme', 'dark'); 
            }
        }
        window.onload = () => {
            const savedTheme = localStorage.getItem('theme');
            const link = document.getElementById('theme-style');
            const btn = document.getElementById('toggle-btn');
            if (savedTheme === 'light') {
                link.setAttribute('href', 'SiteL.css');
                btn.innerHTML = `
                    <!-- Ícone de Lua -->
                    <svg width="28" height="28" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <radialGradient id="moonGradient" cx="50%" cy="50%" r="50%">
                                <stop offset="0%" stop-color="#B0C4DE"/>
                                <stop offset="100%" stop-color="#708090"/>
                            </radialGradient>
                        </defs>
                        <path fill="url(#moonGradient)" d="M21 12.79A9 9 0 0111.21 3 7 7 0 0012 21a9 9 0 009-8.21z"/>
                    </svg>
                `;
            } else {
                link.setAttribute('href', 'SiteD.css');
                btn.innerHTML = `
                    <!-- Ícone de Sol -->
                    <svg width="28" height="28" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <radialGradient id="sunGradient" cx="50%" cy="50%" r="50%">
                                <stop offset="0%" stop-color="#FFD93B"/>
                                <stop offset="100%" stop-color="#FFA500"/>
                            </radialGradient>
                        </defs>
                        <circle cx="12" cy="12" r="5" fill="url(#sunGradient)"/>
                        <g stroke="#FFA500" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="3"/>
                            <line x1="12" y1="21" x2="12" y2="23"/>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                            <line x1="1" y1="12" x2="3" y2="12"/>
                            <line x1="21" y1="12" x2="23" y2="12"/>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                        </g>
                    </svg>
                `;
            }
        };


        