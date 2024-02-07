import { saveScore } from '../scriptAjaxScore';

const containerGame = document.querySelector('.play-game')

const canvas = document.querySelector('#snake')

canvas.setAttribute('width', 600)
canvas.setAttribute('height', 600)

let score = 0
const scoreSpan = document.createElement('span')
scoreSpan.textContent = score
const titleScore = document.createElement("h2")
titleScore.innerHTML = "Score : "
titleScore.append(scoreSpan)
titleScore.classList.add("h2-snake")

containerGame.insertBefore(titleScore, canvas)
containerGame.classList.add("container-snake")

const buttonReload = document.createElement("button")
buttonReload.innerHTML = "Reload"
buttonReload.classList.add("replay")
buttonReload.classList.add("replay-hidden")
containerGame.appendChild(buttonReload)

const context = canvas.getContext("2d")


const background = new Image()
background.src = require('../../../images/snake/background.png')

const foodImg = new Image()
foodImg.src  = require('../../../images/snake/food.png')

/*const eatAudio = new Audio()
eatAudio.src = require('../../../images/snake/eat.mp3')

const deadAudio = new Audio()
deadAudio.src = require('../../../images/snake/dead.mp3')*/

const unit = 30

let food = {
    x: Math.floor(Math.random() * 19 + 1) * unit,
    y: Math.floor(Math.random() * 19 + 1) * unit
}

let snake = []
snake[0] = {
    x: 10 * unit,
    y: 10 * unit
}

//deplacement avec le clavier
let d
document.addEventListener('keydown', (e) => {
    let key = e.keyCode;
    e.preventDefault();
    if (key == 37 && d != "R") {
        d = "L"
    } else if (key == 38 && d != "D") {
        d = "U"
    } else if (key == 39 && d != "L") {
        d = "R"
    } else if (key == 40 && d != "U") {
        d = "D"
    }
})

function collisionBody(head,snake)
{
    for (let index = 0; index < snake.length; index++) {
        if (head.x == snake[index].x && head.y == snake[index].y) {
            return true
        }
    }
    return false
}
function draw()
{
    context.drawImage(background,0,0)
    for (let index = 0; index < snake.length; index++) {
        if (index == 0) {
            context.fillStyle = "black"
        } else {
            context.fillStyle = "red"
        }
        context.fillRect(snake[index].x,snake[index].y,unit,unit)
        context.strokeStyle = 'yellow'
        context.strokeRect(snake[index].x,snake[index].y,unit,unit)
    }

    context.drawImage(foodImg,food.x,food.y)

    let snakeX = snake[0].x
    let snakeY = snake[0].y


    //manger la pomme
    if (snakeX == food.x && snakeY == food.y) {
        food = {
            x:Math.floor(Math.random() * 19 + 1) * unit,
            y:Math.floor(Math.random() * 19 + 1) * unit
        }
        score += 1
        /*eatAudio.play()*/
    } else {
        snake.pop()
    }

    if (d == "L") {
        snakeX -= unit
    }
    if (d == "U") {
        snakeY -= unit
    }
    if (d == "R") {
        snakeX += unit
    }
    if (d == "D") {
        snakeY += unit
    }

    let newHead = {
        x:snakeX,
        y:snakeY
    }
    //les collisions
    if (snakeX <= -unit ||
    snakeX >= canvas.width ||
    snakeY <= -unit ||
    snakeY >= canvas.height ||
    collisionBody(newHead,snake)) {
        clearInterval(play)
        saveScore(score, "snake")
        buttonReload.classList.remove('replay-hidden')
        buttonReload.classList.add('replay-visible')
        /*deadAudio.play()*/
    }
    snake.unshift(newHead)
    scoreSpan.textContent = score

}


buttonReload.addEventListener('click', function () {
    window.location.reload()
})
let play = setInterval(draw,100)
