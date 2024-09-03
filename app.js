document.addEventListener('DOMContentLoaded', function() {
    const seats = document.querySelectorAll('.seat')
    const selectedSeats = document.getElementById
    ('selected-seats')
    const statusMessage = document.getElementById
    ('status-message')
    const reserveButton = document.getElementById('btn-reserve')


let selectedSeatCount = 0;

function updateSelectedSetCount(){
    selectedSeats.innerText = "Places séléctionnés : " + selectedSeatCount;
}

function seatClickHandler(){
    if(this.classList.contains('selected')){
       this.classList.remove('selected');
         selectedSeatCount--;
    } else{
        this.classList.add('selected')
        selectedSeatCount++;
    }
    updateSelectedSetCount()
}

seats.forEach(function(seat){
    seat.addEventListener('click', seatClickHandler)
});

function reserveSeats(){
    if(selectedSeatCount > 0){
        statusMessage.innerText = "Réservation effectuée avec succès"
        statusMessage.style.color = 'green'

    } else{
        statusMessage.innerText = "Veuillez selectionner au moins un siège"
        statusMessage.style.color = 'red'
    }
}

reserveButton.addEventListener('click', reserveSeats)
});