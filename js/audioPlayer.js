const playlist = [
{name: 'This is how it feels when the code finally works', src: 'fire/Bliss.mp3'},
{name: 'Back again', src: 'fire/Back again.mp3'},
{name: 'Brizzy', src: 'fire/brizzy.mp3'},
{name: '', src: 'fire/155 oui.mp3'},
{name: 'This is how I felt when doing the exercises', src: 'fire/She be.mp3'},
{name: '', src: 'fire/fcked.mp3'},
{name: '', src: 'fire/Sylvestre.mp3'},
{name: "I do not own the rights to the original so please don't listen to it too much", src: 'fire/Mr Wilson.mp3'},
{name: '', src: 'fire/Not it.mp3'},
{name: '', src: 'fire/sea.mp3'},
{name: 'I made this one just for you', src: 'fire/Mello.mp3'},
{name: '', src: 'fire/sai.mp3'},
{name: 'Rain cookies', src: 'fire/rain cookies.mp3'},
{name: '', src: 'fire/Xmas blue.mp3'},
{name: '', src: 'fire/Burt.mp3'},
{name: '', src: "fire/fifi brin d'acier.mp3"},
{name: 'space milk', src: 'fire/space milk.mp3'},
{name: '', src: 'fire/That thangggg.mp3'},
{name: '', src: 'fire/back pain.mp3'},
{name: '', src: 'fire/finess.mp3'},
{name: '', src: 'fire/That thang.mp3'},
{name: '', src: 'fire/Mk Ultra.mp3'},
{name: '', src: 'fire/No relief.mp3'},
{name: '', src: 'fire/Dead Star.mp3'},
{name: '', src: 'fire/lost Aminor 154 bpm.mp3'},
{name: "I do not own the rights to the original so please don't listen to it too much", src: 'fire/Juliet.mp3'},
{name: '', src: 'fire/Finally.mp3'},
];

let currentTrack = 0;

const audioPlayer = document.getElementById('audioPlayer');
const trackName = document.getElementById('trackName');

function loadTrack(index) {
audioPlayer.src = playlist[index].src;

if (playlist[index].name) {
trackName.textContent = playlist[index].name
} else {
trackName.textContent = "Here are some beats to help you relax while you do the exercises"
}
	
audioPlayer.play()
setCookie("lastPlayedTrack", index, 7); // Store track index in cookie for 7 days
}

//Next Button
document.getElementById('audioNextBtn').addEventListener('click', () => {
currentTrack = (currentTrack + 1) % playlist.length;
loadTrack(currentTrack);
});

//Previous Button
document.getElementById('audioPrevBtn').addEventListener('click', () => {
currentTrack = (currentTrack - 1 + playlist.length) % playlist.length;
loadTrack(currentTrack);
});

//Auto Next Track
audioPlayer.addEventListener('ended', () => {
currentTrack = (currentTrack + 1) % playlist.length;
loadTrack(currentTrack);
});

// Function to load the last played track on page load
function loadLastPlayedTrack() {
    const lastPlayedIndex = getCookie("lastPlayedTrack");
    if (lastPlayedIndex !== null) {
        const index = parseInt(lastPlayedIndex);
        if (!isNaN(index) && playlist[index]) {
            loadTrack(index); // Play the last track
        }
    }
}

// Load the last played track when the page loads
document.addEventListener('DOMContentLoaded', loadLastPlayedTrack);
