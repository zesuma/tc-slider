const buttonsContainer = document.querySelector('.buttons-container')
const leftBtn = document.getElementById('left')
const rightBtn = document.getElementById('right')
const playBtn = document.querySelector('.play')
const imgs = document.getElementById('imgs')
const img = document.querySelectorAll('#imgs img')

let idx = 0

let interval = setInterval(run, 3000)

function run() {
    idx++
    changeImage()
}

function changeImage() {
    if(idx > img.length - 1) {
        idx = 0
    } else if(idx < 0) {
        idx = img.length -1
    }

    imgs.style.transform = `translateX(${-idx * 18}em)`
}

function resetInterval() {
    clearInterval(interval)
    interval = setInterval(run, 3000)
}

function pauseInterval() {
    if(playBtn.classList.contains('pause')) {
        clearInterval(interval)
        playBtn.innerHTML = '<span class="dashicons dashicons-controls-play"></span>'
    } else if(playBtn.classList.contains('play')) {
        changeImage()
        resetInterval()
        playBtn.innerHTML = '<span class="dashicons dashicons-controls-pause"></span>'
    }
}



img.forEach((image) => {
    image.addEventListener('mouseover', () => {
        clearInterval(interval)
    });
    image.addEventListener('mouseout', () => {
        resetInterval()
    });
  });

if(!!buttonsContainer) {
    rightBtn.addEventListener('click', () => {
        idx++
        changeImage()
        resetInterval()
        pauseInterval()
    })

    leftBtn.addEventListener('click', () => {
        idx--
        changeImage()
        resetInterval()
        pauseInterval()
    })

    playBtn.addEventListener('click', () => {
        playBtn.classList.toggle('pause')
        pauseInterval()
    })
}

// nav control variable 'CAROUSEL_OPTIONS.navControls' - located in plugins/tc-slider/functions/functions.php
const navControls = CAROUSEL_OPTIONS.navControls

// add or remove nav controls
if(!navControls) {
    buttonsContainer.remove()
}
