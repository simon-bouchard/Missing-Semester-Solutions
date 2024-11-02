const lectureList = [ 
		{lect: 'lect1'},
		{lect: 'lect2'},
		{lect: 'lect3'},
		{lect: 'lect4'},
		{lect: 'lect5'},
		{lect: 'lect6'},
		{lect: 'lect7'},
		{lect: 'lect8'},
		{lect: 'lect9'},
		{lect: 'lect10'}
];

let lecture;

/*To recieve lecture num from parent page*/
window.addEventListener('message', (event) => {
	lecture = lectureList.findIndex(item => item.lect === event.data);
});

/*To send new lecture ref to the parent page*/
function loadLecture(lecture) {
	window.parent.postMessage(lectureList[lecture], '*');
}

document.getElementById('prevBtn').addEventListener('click', () => {
		lecture = (lecture - 1 + lectureList.length) % lectureList.length;
		loadLecture(lecture);
});

document.getElementById('nextBtn').addEventListener('click', () => {
		lecture = (lecture + 1) % lectureList.length;
		loadLecture(lecture);
});

