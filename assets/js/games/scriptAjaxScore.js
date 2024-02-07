export function saveScore(score, nameGame) {
    const requete = new XMLHttpRequest();
    requete.open('GET', '/saveScore?score='+score+'&name_game='+nameGame, true)
    requete.send();
}
