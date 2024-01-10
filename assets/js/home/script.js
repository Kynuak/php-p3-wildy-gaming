// Hover Card game

const cardGames = document.querySelectorAll(".home-card-game");



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
