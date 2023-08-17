const ringElem = document.createElement('audio')

ringElem.setAttribute('src', '/wp-content/themes/init/audio/ring.mp3')
ringElem.setAttribute('id', 'ring')

document.querySelector('body').appendChild(ringElem)

window.playRing = () => {
    const ring = document.getElementById('ring')

    ring.currentTime = 0
    ring.play().catch(error => {});
}