// Hover Card game

const cardGames = document.querySelectorAll(".hover-cadre-neon");



cardGames.forEach((element) => {
    element.onmouseover = () =>  {
        element.classList.remove('cadreblue')
        element.classList.add('cadrepurple')
    }
    
    element.onmouseout = () => {
        element.classList.remove('cadrepurple')
        element.classList.add('cadreblue')
    }
})