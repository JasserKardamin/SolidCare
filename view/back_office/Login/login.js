
if (performance.navigation.type == 1) {
    window.location.href = 'login.php';
}


function show() {
    var show = document.getElementById('pass') ; 
    if (show.type == 'password' ){
        show.type = 'text';
    } 
    else {
        show.type = 'password';
    }
}

function verify(){
    var cin = document.getElementById('cin').value ; 
    if(isNaN(cin) || cin.length > 8 || cin.length == 0  ) {
        alert('invalid CIN ! ') ;  
    }
} 
