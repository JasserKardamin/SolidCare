function setSessionCookie(cookieName, cookieValue) {
    document.cookie = cookieName + "=" + cookieValue + ";path=/";
}

function search() {
    var targetValue = document.getElementById('searchValue').value;
    setSessionCookie("idd", targetValue);

    // ad3ath XML request ll serveur ->
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "infos.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var responseData = JSON.parse(xhr.responseText);
            $("#name").text(responseData.name);
            $("#surname").text(responseData.surname);
            $("#email").text(responseData.email);
            $("#phone").text(responseData.phone);
            $("#price").text(responseData.price);
            $("#dur").text(responseData.duration);

            // 7awem f table ->
            var tableRows = document.querySelectorAll('#myTable tbody tr');
            var wheretosearch = document.querySelectorAll('#id');
            var found = false;

            for (var i = 0; i < tableRows.length; i++) {
                var rowTextContent = tableRows[i].textContent || tableRows[i].innerText;
                var content  = wheretosearch[i].textContent || wheretosearch[i].innerText;

                if (content == targetValue) {
                    wheretosearch[i].scrollIntoView({ behavior: 'smooth', block: 'center' });

                    // Highlight after scrolling is complete with a shorter delay
                    setTimeout(function () {
                        var blinkCount = 0;
                        var currentRow = $(tableRows[i]);

                        var blinkInterval = setInterval(function () {
                            currentRow.toggleClass('highlight');
                                
                            blinkCount++;
                            if (blinkCount === 6) {
                                clearInterval(blinkInterval);
                                currentRow.removeClass('highlight');
                            }
                        }, 300);
                    }, 500);
                    
                    found = true;
                    break;
                }
            }

            // l target mahish mawjouda 
            if (!found) {
                alert("Invalid transaction id ");
            }
        }
    };
    xhr.send();
}
