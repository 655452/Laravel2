"use strict";

function checkEnvironment(val) {
    var element=document.getElementById('environment_text_input');
    if(val=='other') {
        element.style.display='block';
    } else {
        element.style.display='none';
    }
}

function showDatabaseSettings() {
    document.getElementById('tab2').checked = true;
}

function showApplicationSettings() {
    document.getElementById('tab3').checked = true;
}