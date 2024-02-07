if(document.body.contains(document.querySelector('canvas'))) {
    const canvas = document.querySelector('canvas')
    switch(canvas.getAttribute("id")) {
    case "snake":
        require('./snake/snake');
        break
    case "planet-defense":
        require('./planet_defense/planet_defense');
        break
    
    case "pac-man":
        require('./pac-man/pac-man');
        break
    }
}

