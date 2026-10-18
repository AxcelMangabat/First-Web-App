function togglePassword2(InputId, link) {

    const passwordInput = document.getElementById(InputId);

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        link.textContent = 'Hide';
    } else {
        passwordInput.type = 'password';
        link.textContent = 'Show';
    }
}


function togglePassword(InputId, ConfirmPasswordId, link) {

    const passwordInput = document.getElementById(InputId);
    const ConfirmPasswordInput = document.getElementById(ConfirmPasswordId);

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        ConfirmPasswordInput.type = 'text';
        link.textContent = 'Hide';
    } else {
        passwordInput.type = 'password';
        ConfirmPasswordInput.type = 'password';
        link.textContent = 'Show';
    }
}

const StudentRecords = document.getElementById('StudentRecords');
const StudentRecordsSVG = document.querySelector('#StudentRecords svg');
const Profile = document.getElementById('Profile');
const ProfileSVG = document.querySelector('#Profile svg');


document.addEventListener('DOMContentLoaded', () => {
    StudentRecords.classList.add('active');
    StudentRecordsSVG.classList.add('active');
    document.querySelector('#contentCon').style.display = "flex";
    document.querySelector('#ProfilePage').style.display = "none";
});


function Records() {
    StudentRecords.classList.add('active');
    StudentRecordsSVG.classList.add('active');
    Profile.classList.remove('active');
    ProfileSVG.classList.remove('active');
    document.querySelector('#contentCon').style.display = "flex";
    document.querySelector('#ProfilePage').style.display = "none";
}


function Profiles() {
    StudentRecords.classList.remove('active');
    StudentRecordsSVG.classList.remove('active');
    Profile.classList.add('active');
    ProfileSVG.classList.add('active');
    document.querySelector('#contentCon').style.display = "none";
    document.querySelector('#ProfilePage').style.display = "flex";
}