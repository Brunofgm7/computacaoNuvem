//I've tried to explain each JavaScript line with comments....Hope you'll understand

//selecting all required elements
const selectBox = document.querySelector(".select-box"),
selectBtnStart = selectBox.querySelector(".options .start"),
playBoard = document.querySelector(".play-board"),
players = document.querySelector(".players"),
allBox = document.querySelectorAll("section span"),
resultBox = document.querySelector(".result-box"),
wonText = resultBox.querySelector(".won-text"),
replayBtn = resultBox.querySelector("button");

window.onload = ()=>{ //once window loaded
    for (let i = 0; i < allBox.length; i++) { //add onclick attribute in all available span
       allBox[i].setAttribute("onclick", "clickedBox(this)");
    }
}

selectBtnStart.onclick = ()=>{
    selectBox.classList.add("hide"); //hide select box
    playBoard.classList.add("show"); //show the playboard section
}

let playerXIcon = "fas fa-times"; //class name of fontawesome cross icon
let playerOIcon = "far fa-circle"; //class name of fontawesome circle icon
let playerChoice = "X";

// user click function
function clickedBox(element){
    if(playerChoice == "X"){
        element.innerHTML = `<i class="${playerXIcon}"></i>`; //adding circle icon tag inside user clicked element/box
        element.setAttribute("id", playerChoice); //set id attribute in span/box with player choosen sign
        selectWinner(); //calling selectWinner function
        playerChoice = "O";
    }else if(playerChoice == "O"){
        element.innerHTML = `<i class="${playerOIcon}"></i>`; //adding circle icon tag inside user clicked element/box
        element.setAttribute("id", playerChoice); //set id attribute in span/box with player choosen sign
        selectWinner(); //calling selectWinner function
        playerChoice = "X";
    }
    element.style.pointerEvents = "none"; //once user select any box then that box can'be clicked again
}


function getIdVal(classname){
    return document.querySelector(".box" + classname).id; //return id value
}
function checkIdSign(val1, val2, val3, sign){ //checking all id value is equal to sign (X or O) or not if yes then return true
    if(getIdVal(val1) == sign && getIdVal(val2) == sign && getIdVal(val3) == sign){
        return true;
    }
}
function selectWinner(){ //if the one of following winning combination match then select the winner
    //console.log(playerChoice);
    if(checkIdSign(1,2,3,playerChoice) || checkIdSign(4,5,6, playerChoice) || checkIdSign(7,8,9, playerChoice) || checkIdSign(1,4,7, playerChoice) || checkIdSign(2,5,8, playerChoice) || checkIdSign(3,6,9, playerChoice) || checkIdSign(1,5,9, playerChoice) || checkIdSign(3,5,7, playerChoice)){
        setTimeout(()=>{ //after match won by someone then hide the playboard and show the result box after 700ms
            resultBox.classList.add("show");
            playBoard.classList.remove("show");
        }, 700); //1s = 1000ms
        wonText.innerHTML = `Player <p>${playerChoice}</p> won the game!`; //displaying winning text with passing playerSign (X or O)
     
    }else{ //if all boxes/element have id value and still no one win then draw the match
        if(getIdVal(1) != "" && getIdVal(2) != "" && getIdVal(3) != "" && getIdVal(4) != "" && getIdVal(5) != "" && getIdVal(6) != "" && getIdVal(7) != "" && getIdVal(8) != "" && getIdVal(9) != ""){
            setTimeout(()=>{ //after match drawn then hide the playboard and show the result box after 700ms
                resultBox.classList.add("show");
                playBoard.classList.remove("show");
            }, 700); //1s = 1000ms
            wonText.textContent = "Draw!"; //displaying draw match text
        }
    }
}
/*
replayBtn.onclick = ()=>{
    window.location.reload(); //reload the current page on replay button click
}*/