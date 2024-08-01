const grid = document.querySelector('.grid');
const timer = document.querySelector('.timer');
const pontos = document.querySelector('.pontos');
const radios = document.getElementsByName('modo');
const allEmojis = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
let tabEmojis = [];
let carta1 = '';
let carta2 = '';
let counter = 0;
var minuto = 0;
var segundo = 0;
let numCartas = 0;
let carta;
let frente;
let costas;
let jogadas = 0;
let xhttp;
let modalidade;
const today = new Date(timeElapsed);

const createElement = (tag, className) => {
    const element = document.createElement(tag);
    element.className = className;
    return element;
}

const checkEndGame = (counter) => {
    const desabilitarCarta = document.querySelectorAll('.carta-desabilitada');
    if (desabilitarCarta.length === counter * 2) {
        clearInterval(this.cronometro);
        alert('Parabens, você ganhou!');
        enviarDados();
        console.log(modalidade);
        //INSERIR VITÓRIA NO BD
    }
}

const checkCards = () => {
    const emoji1 = carta1.getAttribute('data-emoji');
    const emoji2 = carta2.getAttribute('data-emoji');

    if (emoji1 === emoji2) {
        carta1.firstChild.classList.add('carta-desabilitada');
        carta2.firstChild.classList.add('carta-desabilitada');
        carta1.setAttribute('carta-virada', '1');
        carta2.setAttribute('carta-virada', '1');
        carta1 = '';
        carta2 = '';

        setTimeout(() => {
            checkEndGame(counter);
        }, 300);
    } else {
        setTimeout(() => {
            carta1.classList.remove('carta-revelada');
            carta2.classList.remove('carta-revelada');
            carta1.setAttribute('carta-virada', '0');
            carta2.setAttribute('carta-virada', '0');
            carta1 = '';
            carta2 = '';
        }, 400);
    }
}

const revelarCarta = ({target}) => {
    if (target.parentNode.className.includes('carta-revelada')) {
        return;
    }
    if (carta1 === '') {
        target.parentNode.classList.add('carta-revelada');
        target.parentNode.setAttribute('carta-virada', '1');
        carta1 = target.parentNode;
        jogadas++;
        pontos.innerHTML = 'Jogadas: ' + jogadas;
    } else if (carta2 === '') {
        target.parentNode.classList.add('carta-revelada');
        target.parentNode.setAttribute('carta-virada', '1');
        carta2 = target.parentNode;
        jogadas++;
        pontos.innerHTML = 'Jogadas: ' + jogadas;
        checkCards();
    }
}

const modoTrapaca = () => {
    let cartas = document.querySelectorAll('.carta');
    let botao_tapaca = document.querySelector('.trapaca_btn');

    cartas.forEach((cartas) => {
        cartas.classList.add("carta-revelada");
    });

    botao_tapaca.textContent = "Desativar Modo Trapaça";
    botao_tapaca.setAttribute("onclick", "desfazTrapaca()");
}

const desfazTrapaca = () => {
    let cartas = document.querySelectorAll('.carta');
    let botao_tapaca = document.querySelector('.trapaca_btn');

    cartas.forEach((cartas) => {
        carta_virada = cartas.getAttribute('carta-virada');
        if (carta_virada === '0') {
            cartas.classList.remove("carta-revelada");
        }
    });
    botao_tapaca.textContent = "Ativar Modo Trapaça";
    botao_tapaca.setAttribute('onclick', 'modoTrapaca()');
}

const alteraGrid = (tamanho) => {
    switch (tamanho) {
        case 2:
            document.getElementById("grid").style.gridTemplateColumns = `repeat(${tamanho}, 1fr)`;
            break;
        case 8:
            document.getElementById("grid").style.gridTemplateColumns = 'repeat(4, 1fr)';
            break;
        case 18:
            document.getElementById("grid").style.gridTemplateColumns = 'repeat(6, 1fr)';
            break;
        case 32:
            document.getElementById("grid").style.gridTemplateColumns = 'repeat(8, 1fr)';
            break;
        default:
            break;
    }
}

const createCard = (emoji) => {
    carta = createElement('div', 'carta');
    frente = createElement('div', 'face front');
    costas = createElement('div', 'face back');

    frente.style.backgroundImage = `url('images/cards/${emoji}.png')`;

    carta.appendChild(frente);
    carta.appendChild(costas);

    carta.addEventListener('click', revelarCarta);
    carta.setAttribute('data-emoji', emoji)
    carta.setAttribute('carta-virada', '0'); // 0 - NÃO; 1 - SIM

    numCartas++;
    return carta;
}

const montaArray = (i) => {
    let k;

    if (i === 32) {
        tabEmojis = allEmojis;
    } else {
        for (k = 1; k <= i; k++) {
            let numero = Math.floor(Math.random() * allEmojis.length);
            if (tabEmojis.includes(`${numero}`)) {
                numero = Math.floor(Math.random() * allEmojis.length);
            }
            tabEmojis.push(`${numero}`);
        }
    }
}

const loadGame = (i) => {
    tabEmojis.length = 0;
    montaArray(i);
    counter = i;

    const duplicateEmojis = [...tabEmojis, ...tabEmojis];

    let shuffledArray = duplicateEmojis.sort(() => Math.random() - 0.5);

    if (numCartas === 0) {
        createCardController(shuffledArray);
        alteraGrid(i);

        if (radios[0].checked === true) {
            startTimer(0, 0, 0);
            modalidade = 'Clássico';
        } else if (radios[1].checked) {
            modalidade = 'Contra Tempo';
            switch (i) {
                case 2:
                    startTimer(1, 5, 0);
                    break;
                case 8:
                    startTimer(1, 30, 0);
                    break;
                case 18:
                    startTimer(1, 30, 1);
                    break;
                case 32:
                    startTimer(1, 15, 2);
                    break;
                default:
                    break;
            }
        }
    } else {
        return;
    }
}

reloadGame = () => {
    location.reload();
}

createCardController = (array) => {
    array.forEach((emoji) => {
        const carta = createCard(emoji);
        grid.appendChild(carta);
    });
}

stopTimer = () => {
    clearInterval(this.cronometro);
    minuto = 0;
    segundo = 0;
}

const startTimer = (opcao, segundos, minutos) => {
    if (opcao === 0) {
        this.cronometro = setInterval(() => { timerControllerClassico() }, 1000);
    } else if (opcao === 1) {
        segundo = segundos;
        minuto = minutos;
        this.cronometro = setInterval(() => { timerControllerContraTempo() }, 1000);
    }
}

const timerControllerClassico = () => {
    segundo++;

    if (segundo == 60) {
        segundo = 0;
        minuto++;
    }

    var format = (minuto < 10 ? '0' + minuto : minuto) + ':' + (segundo < 10 ? '0' + segundo : segundo);

    timer.innerHTML = format;

    return format;
}

const timerControllerContraTempo = () => {
    let cartas = document.querySelectorAll('.carta');
    segundo--;

    if (segundo <= 0) {
        if (minuto > 0) {
            minuto--;
            segundo = 59;
        } else {
            setTimeout(() => {
                clearInterval(this.cronometro);
                minuto = 0;
                segundo = 0;
                alert("Acabou o tempo. Você perdeu :(");
                //INCLUIR DERROTA NO BD
                cartas.forEach((cartas) => {
                    cartas.classList.add("carta-revelada");
                });
            }, 500);
        }
    }

    var format = (minuto < 10 ? '0' + minuto : minuto) + ':' + (segundo < 10 ? '0' + segundo : segundo);

    timer.innerHTML = format;

    return format;
}

const enviarDados = () => {
    xhttp = new XMLHttpRequest();

    if(!xhttp)
    {
        alert('Não foi possível criar um objeto XMLHttpRequest');
        return false;
    }
    xhttp.onreadystatechange = incluirHistorico;
    xhttp.open('POST', 'enviarDados.php', true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send("minutos=" + minuto, "segundos=" + segundo, "modalidade=" + modalidade, "dimensao=" + i, "data=" + today.toISOString, "resultado=" + resultado);
    console.log(modalidade);
}


const incluirHistorico = () => {

}
