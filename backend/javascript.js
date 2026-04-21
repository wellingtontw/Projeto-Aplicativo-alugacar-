document.addEventListener("DOMContentLoaded", function () {
    const images = [
        "./images/pcx.png",
        "./images/civic.png",
        "./images/ranger.png"
    ];

    const texts = [
        "Descrição da imagem 1", // Descrição para a primeira imagem
        "Descrição da imagem 2", // Descrição para a segunda imagem
        "Descrição da imagem 3"  // Descrição para a terceira imagem
    ];

    let currentIndex = 0;
    const imgElement = document.getElementById("carousel-image");
    const textElement = document.getElementById("carousel-text"); // Novo elemento de texto
    const prevButton = document.getElementById("prev");
    const nextButton = document.getElementById("next");

    function updateImage() {
        imgElement.src = images[currentIndex];
        textElement.textContent = texts[currentIndex]; // Atualiza o texto
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

